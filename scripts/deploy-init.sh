#!/bin/bash
#
# Initial deployment setup script for cPanel
# Run this once on the server to set up the deployment structure
#
# Usage: bash deploy-init.sh /home/username stream
#

set -e

# Configuration
HOME_PATH=${1:-"/home/$(whoami)"}
APP_NAME=${2:-"stream"}
DEPLOY_PATH="${HOME_PATH}/deployments/${APP_NAME}"
PUBLIC_PATH="${HOME_PATH}/public_html"

echo "🚀 Stream Deployment Setup"
echo "=========================="
echo "Home Path: ${HOME_PATH}"
echo "App Name: ${APP_NAME}"
echo "Deploy Path: ${DEPLOY_PATH}"
echo "Public Path: ${PUBLIC_PATH}"
echo ""

# Create deployment directory structure
echo "📁 Creating deployment directory structure..."
mkdir -p "${DEPLOY_PATH}/releases"
mkdir -p "${DEPLOY_PATH}/shared/storage/app/public"
mkdir -p "${DEPLOY_PATH}/shared/storage/framework/cache/data"
mkdir -p "${DEPLOY_PATH}/shared/storage/framework/sessions"
mkdir -p "${DEPLOY_PATH}/shared/storage/framework/views"
mkdir -p "${DEPLOY_PATH}/shared/storage/logs"

# Set permissions
echo "🔒 Setting permissions..."
chmod -R 755 "${DEPLOY_PATH}"
chmod -R 775 "${DEPLOY_PATH}/shared/storage"

# Create .env file if it doesn't exist
if [ ! -f "${DEPLOY_PATH}/shared/.env" ]; then
    echo "📝 Creating .env file..."
    cat > "${DEPLOY_PATH}/shared/.env" << 'ENVFILE'
APP_NAME=Stream
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL=https://yourdomain.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

CACHE_DRIVER=file
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120

MAIL_MAILER=smtp
MAIL_HOST=localhost
MAIL_PORT=587
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourdomain.com"
MAIL_FROM_NAME="${APP_NAME}"
ENVFILE
    echo "⚠️  Please edit ${DEPLOY_PATH}/shared/.env with your production settings!"
fi

# Create .htaccess for public_html if it doesn't exist
if [ ! -f "${PUBLIC_PATH}/.htaccess" ]; then
    echo "📝 Creating .htaccess..."
    cat > "${PUBLIC_PATH}/.htaccess" << 'HTACCESS'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
HTACCESS
fi

# Create gitignore for storage
echo "📝 Creating .gitignore for storage..."
cat > "${DEPLOY_PATH}/shared/storage/.gitignore" << 'GITIGNORE'
*
!.gitignore
GITIGNORE

echo ""
echo "✅ Deployment structure created successfully!"
echo ""
echo "📋 Next Steps:"
echo "1. Edit ${DEPLOY_PATH}/shared/.env with your production settings"
echo "2. Generate APP_KEY: php artisan key:generate --show"
echo "3. Add the following secrets to your GitHub repository:"
echo "   - SSH_HOST: Your server hostname/IP"
echo "   - SSH_PORT: SSH port (usually 22)"
echo "   - SSH_PRIVATE_KEY: Your SSH private key"
echo "   - CPANEL_USER: Your cPanel username"
echo ""
echo "4. Add SSH public key to ~/.ssh/authorized_keys on this server"
echo ""
echo "Directory structure:"
echo "${DEPLOY_PATH}/"
echo "├── releases/          # All deployment releases"
echo "├── shared/"
echo "│   ├── .env           # Shared environment file"
echo "│   └── storage/       # Shared storage directory"
echo "└── current -> releases/xxx  # Symlink to current release"
