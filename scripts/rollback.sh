#!/bin/bash
#
# Manual rollback script for cPanel deployment
# Run this on the server to rollback to a previous release
#
# Usage: bash rollback.sh [release_name]
#        bash rollback.sh                    # Rollback to previous release
#        bash rollback.sh release_20240101   # Rollback to specific release
#

set -e

# Configuration - Update these paths
HOME_PATH="/home/$(whoami)"
APP_NAME="stream"
DEPLOY_PATH="${HOME_PATH}/deployments/${APP_NAME}"
PUBLIC_PATH="${HOME_PATH}/public_html"
PHP_BIN="php"

echo "🔄 Stream Rollback Script"
echo "========================="

cd "${DEPLOY_PATH}/releases"

# Get current release
CURRENT_RELEASE=$(basename $(readlink -f "${DEPLOY_PATH}/current" 2>/dev/null) 2>/dev/null || echo "none")
echo "Current release: ${CURRENT_RELEASE}"

# List available releases
echo ""
echo "Available releases:"
ls -lt | head -10
echo ""

# Determine target release
if [ -n "$1" ]; then
    TARGET_RELEASE="$1"
else
    # Get previous release (second newest)
    TARGET_RELEASE=$(ls -t | grep -v "^${CURRENT_RELEASE}$" | head -1)
fi

if [ -z "${TARGET_RELEASE}" ]; then
    echo "❌ No release found to rollback to!"
    exit 1
fi

if [ ! -d "${DEPLOY_PATH}/releases/${TARGET_RELEASE}" ]; then
    echo "❌ Release ${TARGET_RELEASE} does not exist!"
    exit 1
fi

if [ "${TARGET_RELEASE}" = "${CURRENT_RELEASE}" ]; then
    echo "⚠️  ${TARGET_RELEASE} is already the current release!"
    exit 0
fi

TARGET_PATH="${DEPLOY_PATH}/releases/${TARGET_RELEASE}"

echo "🎯 Rolling back to: ${TARGET_RELEASE}"
read -p "Continue? (y/n) " -n 1 -r
echo ""

if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "Rollback cancelled."
    exit 0
fi

# Perform rollback
echo "⏳ Performing rollback..."

# Atomic symlink switch
ln -nfs "${TARGET_PATH}" "${DEPLOY_PATH}/current_new"
mv -Tf "${DEPLOY_PATH}/current_new" "${DEPLOY_PATH}/current"

# Sync public directory
echo "📂 Syncing public directory..."
rsync -av --delete "${DEPLOY_PATH}/current/public/" "${PUBLIC_PATH}/" \
    --exclude='.htaccess' \
    --exclude='.well-known' \
    --exclude='cgi-bin'

# Re-run Laravel optimizations
echo "⚙️  Running Laravel optimizations..."
cd "${DEPLOY_PATH}/current"
${PHP_BIN} artisan config:cache
${PHP_BIN} artisan route:cache
${PHP_BIN} artisan view:cache

# Clear caches
${PHP_BIN} artisan cache:clear
${PHP_BIN} artisan opcache:clear 2>/dev/null || true

echo ""
echo "✅ Rollback successful!"
echo "Previous: ${CURRENT_RELEASE}"
echo "Current:  ${TARGET_RELEASE}"
