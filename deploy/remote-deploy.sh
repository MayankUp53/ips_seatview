#!/usr/bin/env bash
set -euo pipefail

if [[ "$#" -ne 6 ]]; then
    echo "Usage: remote-deploy.sh IMAGE_ARCHIVE ENV_FILE APP_PORT APP_BIND IMAGE_NAME IMAGE_TAG" >&2
    exit 2
fi

image_archive=$1
env_file=$2
app_port=$3
app_bind=$4
image_name=$5
image_tag=$6
container_name=ips_seatviewer
image="$image_name:$image_tag"
app_data_dir=$(dirname -- "$env_file")
logs_dir="$app_data_dir/logs"
uploads_dir="$app_data_dir/uploads"
old_image=

cleanup() {
    rm -f -- "$image_archive" "$0"
}
trap cleanup EXIT

if [[ ! -f "$image_archive" ]]; then
    echo "Image archive does not exist: $image_archive" >&2
    exit 1
fi
if [[ ! -r "$env_file" ]]; then
    echo "Application environment file is missing or unreadable: $env_file" >&2
    exit 1
fi
if [[ ! "$app_port" =~ ^[0-9]+$ ]] || ((app_port < 1 || app_port > 65535)); then
    echo "APP_PORT must be between 1 and 65535." >&2
    exit 1
fi
if [[ -z "$app_bind" || -z "$image_name" || -z "$image_tag" ]]; then
    echo "APP_BIND, IMAGE_NAME, and IMAGE_TAG must not be empty." >&2
    exit 1
fi

gzip -dc -- "$image_archive" | docker load
if ! docker run --rm \
    --env-file "$env_file" \
    --entrypoint php \
    "$image" \
    -r '$required = ["SECURITY_SALT"]; foreach ($required as $key) { $value = getenv($key); if ($value === false || $value === "") { fwrite(STDERR, "$key is required and must not be empty.\n"); exit(1); } } $url = getenv("DATABASE_URL"); if ($url !== false && $url !== "") { exit(0); } $required = ["DB_HOST", "DB_PORT", "DB_DATABASE", "DB_USERNAME", "DB_PASSWORD"]; foreach ($required as $key) { $value = getenv($key); if ($value === false || $value === "") { fwrite(STDERR, "$key is required when DATABASE_URL is not set.\n"); exit(1); } } $port = getenv("DB_PORT"); if (!ctype_digit($port) || (int)$port < 1 || (int)$port > 65535) { fwrite(STDERR, "DB_PORT must be between 1 and 65535.\n"); exit(1); }'
then
    echo "Required runtime settings are missing or invalid. Configure SECURITY_SALT and either DATABASE_URL or all DB_* settings." >&2
    exit 1
fi

if [[ ! -d "$logs_dir" || ! -d "$uploads_dir" ]]; then
    echo "Create the host logs and uploads directories before deploying: $logs_dir and $uploads_dir" >&2
    exit 1
fi

if ! docker run --rm \
    --user www-data \
    --volume "$logs_dir:/var/www/html/logs" \
    --volume "$uploads_dir:/var/www/html/webroot/uploads" \
    --entrypoint sh \
    "$image" \
    -ec 'test -w /var/www/html/logs && test -w /var/www/html/webroot/uploads'
then
    echo "The container's www-data user cannot write to the host logs/uploads directories." >&2
    echo "Set their ownership and permissions for UID/GID 33 before deploying." >&2
    exit 1
fi

docker volume create ips_seatviewer-tmp >/dev/null

if docker container inspect "$container_name" >/dev/null 2>&1; then
    old_image=$(docker container inspect --format '{{.Config.Image}}' "$container_name")
    docker container rm --force "$container_name"
fi

start_container() {
    docker run --detach \
        --name "$container_name" \
        --restart unless-stopped \
        --env-file "$env_file" \
        --publish "$app_bind:$app_port:80" \
        --volume "$logs_dir:/var/www/html/logs" \
        --volume "$uploads_dir:/var/www/html/webroot/uploads" \
        --volume ips_seatviewer-tmp:/var/www/html/tmp \
        "$1"
}

if ! start_container "$image"; then
    echo "New container could not start." >&2
    if [[ -n "$old_image" ]]; then
        echo "Restoring previous image: $old_image" >&2
        start_container "$old_image"
    fi
    exit 1
fi

health=
for ((attempt = 0; attempt < 60; attempt++)); do
    health=$(docker container inspect \
        --format '{{if .State.Health}}{{.State.Health.Status}}{{else}}{{.State.Status}}{{end}}' \
        "$container_name")
    if [[ "$health" == "healthy" ]]; then
        break
    fi
    if [[ "$health" == "unhealthy" || "$health" == "exited" ]]; then
        break
    fi
    sleep 2
done

if [[ "$health" != "healthy" ]]; then
    echo "New container did not become healthy (status: $health)." >&2
    if ! docker container logs --tail 100 "$container_name"; then
        echo "Could not retrieve new container logs." >&2
    fi
    docker container rm --force "$container_name"
    if [[ -n "$old_image" ]]; then
        echo "Restoring previous image: $old_image" >&2
        start_container "$old_image"
    fi
    exit 1
fi

echo "Deployed $image successfully."

image_count=0
while IFS= read -r old_image_tag; do
    image_count=$((image_count + 1))
    if ((image_count > 5)); then
        docker image rm "$old_image_tag"
    fi
done < <(docker image ls \
    --filter "reference=$image_name:*" \
    --format '{{.Repository}}:{{.Tag}}')
