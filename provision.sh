#!/bin/bash

set -e

echo "Starting server provisioning..."

# Update system
export DEBIAN_FRONTEND=noninteractive
apt-get update -qq

# Install dependencies
apt-get install -y -qq curl wget git unzip software-properties-common ca-certificates apt-transport-https lsb-release > /dev/null

# Install PHP and extensions
add-apt-repository -y ppa:ondrej/php > /dev/null
apt-get update -qq
apt-get install -y -qq php8.4 php8.4-fpm php8.4-mysql php8.4-xml php8.4-mbstring php8.4-curl php8.4-zip php8.4-bcmath php8.4-redis > /dev/null

# Install MySQL
DEBIAN_FRONTEND=noninteractive apt-get install -y -qq mysql-server > /dev/null
systemctl start mysql
systemctl enable mysql

# Install Redis
apt-get install -y -qq redis-server > /dev/null
systemctl start redis || true
systemctl enable redis || true

# Install Nginx
apt-get install -y -qq nginx > /dev/null
systemctl start nginx
systemctl enable nginx

# Configure Nginx for Laravel
cat > /etc/nginx/sites-available/laravel <<EOF
server {
    listen 80;
    server_name _;
    root /var/www/laravel/public;
    index index.php;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
    }

    location ~ /\.ht {
        deny all;
    }
}
EOF

ln -sf /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default

nginx -t
systemctl reload nginx

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_20.x | bash - > /dev/null
apt-get install -y -qq nodejs > /dev/null

# Install Composer
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer > /dev/null

# Configure MySQL
mysql -u root <<EOF
CREATE DATABASE IF NOT EXISTS laravel;
CREATE USER IF NOT EXISTS 'laravel'@'localhost' IDENTIFIED BY 'password';
GRANT ALL PRIVILEGES ON laravel.* TO 'laravel'@'localhost';
FLUSH PRIVILEGES;
EOF

# Setup SSH for GitHub (pass key via GITHUB_SSH_KEY env var)
mkdir -p ~/.ssh
chmod 700 ~/.ssh

if [ -n "$GITHUB_SSH_KEY" ]; then
    echo "$GITHUB_SSH_KEY" > ~/.ssh/id_rsa
    chmod 600 ~/.ssh/id_rsa
    ssh-keyscan github.com >> ~/.ssh/known_hosts 2>/dev/null
fi

# Clone private repository
git clone git@github.com:novislap/stream.git /var/www/laravel
cd /var/www/laravel

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies
npm install

# Build frontend
npm run build

# Copy environment file
cp .env.example .env

# Fill .env with database and Redis details
sed -i "s|DB_HOST=.*|DB_HOST=127.0.0.1|" .env
sed -i "s|DB_PORT=.*|DB_PORT=3306|" .env
sed -i "s|DB_DATABASE=.*|DB_DATABASE=laravel|" .env
sed -i "s|DB_USERNAME=.*|DB_USERNAME=laravel|" .env
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=password|" .env

sed -i "s|REDIS_HOST=.*|REDIS_HOST=127.0.0.1|" .env
sed -i "s|REDIS_PORT=.*|REDIS_PORT=6379|" .env

sed -i "s|APP_URL=.*|APP_URL=http://localhost|" .env

php artisan key:generate

# Run migrations and seeders
php artisan migrate --seed

# Set permissions
chown -R www-data:www-data /var/www/laravel
chmod -R 755 /var/www/laravel/storage /var/www/laravel/bootstrap/cache

echo "Provisioning completed successfully!"
