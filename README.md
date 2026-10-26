# Seatview

Seatview runs on CakePHP 5 and PHP 8.2.35 in Docker.

## Local development

Install dependencies and run the focused application test:

```bash
composer install
vendor/bin/phpunit --filter ApplicationTest
```

Build an image locally with:

```bash
docker build -t ips-seatview:local .
```

## Server deployment without a registry

The `Build and deploy Seatview` GitHub Actions workflow runs on pushes to
`main` or when started manually. It builds the image in GitHub Actions, exports
it as a compressed archive, transfers the archive to the Linux server over
SSH, loads it into the server's Docker image store, and replaces the running
container. No image registry is used.

The workflow keeps the five newest `ips-seatview` images on the server for
rollback. The uploaded archive is removed after deployment. Docker-managed
volumes keep application logs and temporary files outside the image.

### Prepare the server

1. Install Docker Engine. The SSH deployment user must be allowed to run Docker
   commands and read the application environment file.
2. Create `/etc/ips-seatview/seatview.env` on the server. Keep it out of Git and
   make it readable only by the deployment account.
3. Add the required runtime settings, for example:

   ```dotenv
   DEBUG=false
   SECURITY_SALT=<generate-a-long-random-value>
   DATABASE_URL=mysql://<user>:<url-encoded-password>@<database-host>:3306/<database-name>?encoding=utf8mb4
   ```

   Use the database host as seen from inside the container; `localhost` refers
   to the container itself. URL-encode special characters in database
   usernames/passwords. Never put database credentials or the security salt in
   the repository, Docker image, or workflow file.

The container listens on port 80 internally. By default it binds to
`127.0.0.1:8080` on the server, so an existing reverse proxy should forward to
that address. Set the GitHub variable `APP_BIND` to `0.0.0.0` only if the
container should be directly reachable through the server firewall.

### Configure GitHub

Add these repository secrets:

| Secret | Value |
| --- | --- |
| `DEPLOY_HOST` | Server hostname or IP |
| `DEPLOY_USER` | SSH deployment account |
| `DEPLOY_SSH_KEY` | Private key for that account |
| `DEPLOY_KNOWN_HOSTS` | Verified SSH host-key entry for the server |

Optional repository variables:

| Variable | Default | Purpose |
| --- | --- | --- |
| `DEPLOY_PORT` | `22` | SSH port |
| `APP_ENV_FILE` | `/etc/ips-seatview/seatview.env` | Environment file path on the server |
| `APP_PORT` | `8080` | Server-side port mapped to container port 80 |
| `APP_BIND` | `127.0.0.1` | Server-side bind address |

After the server and GitHub settings are in place, push to `main` or run the
workflow manually from the Actions tab. A health-check failure leaves the
workflow failed and attempts to restart the previously deployed image.

Useful server commands:

```bash
docker logs -f ips-seatview
docker image ls ips-seatview
docker volume ls --filter name=ips-seatview
```
