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
docker build -t ips_seatviewer:local .
```

## Server deployment without a registry

The `Build and deploy Seatview` GitHub Actions workflow runs on pushes to
`main` or when started manually. It builds the image in GitHub Actions, exports
it as a compressed archive, transfers the archive to the Linux server over
SSH, loads it into the server's Docker image store, and replaces the running
container. No image registry is used.

The workflow keeps the five newest `ips_seatviewer` images on the server for
rollback. The uploaded archive is removed after deployment. Seatview's
`logs/` and `uploads/` directories are bind-mounted from its dedicated server
data directory; temporary files remain in a Docker-managed volume.

### Prepare the server

1. Install Docker Engine. The SSH deployment user must be allowed to run Docker
   commands and read the application environment file.
2. Create Seatview's own directory and persistent data folders. Do not reuse
   another site's `logs/` or `uploads/` directories:

   ```bash
   sudo mkdir -p /var/www/html/ips-seatview/logs /var/www/html/ips-seatview/uploads
   sudo chown 33:33 /var/www/html/ips-seatview/logs /var/www/html/ips-seatview/uploads
   sudo chmod 750 /var/www/html/ips-seatview/logs /var/www/html/ips-seatview/uploads
   ```

   UID/GID `33:33` is the `www-data` user used by the container. If those
   directories already contain Seatview files, inspect and back them up before
   changing ownership.
3. Create `/var/www/html/ips-seatview/.env` on the server, readable only by the
   deployment account. Because it is under `/var/www/html`, configure the host
   web server to deny HTTP requests for this file. For Apache, put this in
   `/var/www/html/ips-seatview/.htaccess`:

   ```apache
   <Files ".env">
       Require all denied
   </Files>
   ```

   If the host uses Nginx, add an equivalent deny rule to the active server
   configuration and reload Nginx; `.htaccess` does not protect Nginx.
4. Add the required runtime settings, for example:

   ```dotenv
   APP_NAME=ips_seatviewer
   APP_ENV=production
   APP_DEBUG=false
   SECURITY_SALT=<generate-a-long-random-value>
   DB_HOST=<database-host-reachable-from-container>
   DB_PORT=3306
   DB_DATABASE=<database-name>
   DB_USERNAME=<database-user>
   DB_PASSWORD=<database-password>
   ```

   Use the database host as seen from inside the container; `localhost` refers
   to the container itself. CakePHP reads `APP_DEBUG`, `SECURITY_SALT`, and the
   `DB_*` values above. The deployment requires `SECURITY_SALT` and either all
   listed `DB_*` values or `DATABASE_URL`. `APP_NAME` and `APP_ENV` are
   retained for deployment consistency but are not used by the current
   CakePHP config. Never put database credentials or the security salt in the
   repository, Docker image, or workflow file. The deployment passes these
   settings into the container; it does not copy `.env` into the image.

   Set the file permissions, substituting the GitHub `DEPLOY_USER`:

   ```bash
   DEPLOY_USER=your_actual_deploy_user
   sudo chown "$DEPLOY_USER:$(id -gn "$DEPLOY_USER")" /var/www/html/ips-seatview/.env
   sudo chmod 600 /var/www/html/ips-seatview/.env
   ```

The container listens on port 80 internally. By default it binds to
`127.0.0.1:8080` on the server, so an existing reverse proxy should forward to
that address. Set the GitHub variable `APP_BIND` to `0.0.0.0` only if the
container should be directly reachable through the server firewall.

### Apache HTTPS virtual host

Seatview is served at the domain root, for example
`https://c047.ameyoj.com/`; `/ips-seatview` is only the host directory for its
environment file and persistent data. On a RHEL/CentOS server, create a
domain-specific config such as `/etc/httpd/conf.d/ips_seatviewer-ssl.conf`.
Use the existing certificate paths for the domain:

```apache
<VirtualHost *:443>
    ServerName c047.ameyoj.com

    SSLEngine on
    SSLCertificateFile /dacx/SSL/wildcard_ameyoj_com.crt
    SSLCertificateKeyFile /dacx/SSL/wildcard_ameyoj_com.key
    SSLCertificateChainFile /dacx/SSL/DigiCertCA.crt

    ProxyRequests Off
    ProxyPreserveHost On
    RequestHeader set X-Forwarded-Proto "https"
    RequestHeader set X-Forwarded-Port "443"

    ProxyPass        / http://127.0.0.1:8080/ retry=0
    ProxyPassReverse / http://127.0.0.1:8080/
</VirtualHost>

<Directory "/var/www/html/ips-seatview">
    Require all denied
</Directory>
```

The `<Directory>` rule prevents Apache from serving Seatview's host-side
environment file or persistent data over HTTP. Check `sudo apachectl -S`
before adding the virtual host: if another config already claims this domain
or is a catch-all on port 443, resolve that conflict rather than adding a
duplicate host blindly. Confirm `ssl`, `proxy`, `proxy_http`, and `headers`
modules are enabled, then run `sudo apachectl configtest`; reload `httpd` only
if it reports `Syntax OK`.

If another project must share this domain later, give it a URL prefix such as
`/other/` and a different localhost port such as `8081`. Add its `ProxyPass`
and `ProxyPassReverse` rules **before** Seatview's `/` rules:

```apache
ProxyPass        /other/ http://127.0.0.1:8081/
ProxyPassReverse /other/ http://127.0.0.1:8081/
```

The other application must support being hosted under `/other/`; Apache
proxying alone may not rewrite its generated links or asset paths. Do not add
these optional rules until that container is running and configured for the
subpath.

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
| `APP_ENV_FILE` | `/var/www/html/ips-seatview/.env` | Environment file path on the server |
| `APP_PORT` | `8080` | Server-side port mapped to container port 80 |
| `APP_BIND` | `127.0.0.1` | Server-side bind address |

After the server and GitHub settings are in place, push to `main` or run the
workflow manually from the Actions tab. A health-check failure leaves the
workflow failed and attempts to restart the previously deployed image.

Useful server commands:

```bash
docker logs -f ips_seatviewer
docker image ls ips_seatviewer
ls -ld /var/www/html/ips-seatview/{logs,uploads}
```
