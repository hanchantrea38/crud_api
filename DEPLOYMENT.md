# Deployment Guide — CRUD_API (Laravel 12)

| Role       | Hostname              | IP              |
|------------|-----------------------|-----------------|
| Database   | —                     | 192.168.108.234 |
| Backend    | backend.trea.global   | 172.16.16.38    |
| Frontend   | frontend.trea.global  | 172.16.16.128   |

---

## 1. Database — Create Database

1. Go to `http://192.168.108.234/phpmyadmin`, login (`phpmyadmin` / `password123`).
2. Click **New** → Database name: `crud_api_db` → Collation: `utf8mb4_unicode_ci` → **Create**.

---

## 2. Backend Server (172.16.16.38)

```bash
# Install PHP + Nginx
sudo apt update
sudo apt install -y nginx php8.2-fpm php8.2-cli php8.2-mysql php8.2-mbstring \
  php8.2-xml php8.2-curl php8.2-zip php8.2-bcmath php8.2-gd unzip curl git

# Install Composer
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs

# Deploy code
cd /var/www
sudo git clone <your-repo-url> crud_api
sudo chown -R $USER:www-data crud_api
cd crud_api

# Install deps & build
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Configure .env
cp .env.example .env
php artisan key:generate
```

Edit `/var/www/crud_api/.env`:
```ini
APP_NAME=CRUD_API
APP_ENV=production
APP_DEBUG=false
APP_URL=http://backend.trea.global

DB_CONNECTION=mysql
DB_HOST=192.168.108.234
DB_PORT=3306
DB_DATABASE=crud_api_db
DB_USERNAME=phpmyadmin
DB_PASSWORD=password123
```

```bash
# Migrate & seed
php artisan migrate --force
php artisan db:seed --force

# Permissions
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache public/build
```

Create `/etc/nginx/sites-available/crud_api`:
```nginx
server {
    listen 80;
    server_name backend.trea.global 172.16.16.38;
    root /var/www/crud_api/public;
    index index.php;
    charset utf-8;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
    location ~ /\.(?!well-known).* { deny all; }
}
```

```bash
sudo ln -sf /etc/nginx/sites-available/crud_api /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
```

Verify: `curl http://172.16.16.38/api/categories`

---

## 3. Frontend Server (172.16.16.128)

```bash
sudo apt update
sudo apt install -y nginx
```

Create `/etc/nginx/sites-available/frontend`:
```nginx
server {
    listen 80;
    server_name frontend.trea.global 172.16.16.128;

    location / {
        proxy_pass http://172.16.16.38:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

```bash
sudo ln -sf /etc/nginx/sites-available/frontend /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default
sudo nginx -t
sudo systemctl reload nginx
```

Verify: Open `http://frontend.trea.global` in a browser.

---

## Done
- Backend: `http://backend.trea.global` or `http://172.16.16.38`
- Frontend: `http://frontend.trea.global` or `http://172.16.16.128`
- API: `http://172.16.16.38/api/{categories|products|customers|movies}`
