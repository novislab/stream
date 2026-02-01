#!/bin/bash
#
# Deployment status script
# Shows current deployment status and available releases
#
# Usage: bash deploy-status.sh
#

# Configuration - Update these paths
HOME_PATH="/home/$(whoami)"
APP_NAME="stream"
DEPLOY_PATH="${HOME_PATH}/deployments/${APP_NAME}"
PHP_BIN="php"

echo "📊 Stream Deployment Status"
echo "============================"
echo ""

# Check if deployment exists
if [ ! -d "${DEPLOY_PATH}" ]; then
    echo "❌ Deployment directory not found: ${DEPLOY_PATH}"
    echo "Run deploy-init.sh first to set up the deployment structure."
    exit 1
fi

# Current release
if [ -L "${DEPLOY_PATH}/current" ]; then
    CURRENT_RELEASE=$(basename $(readlink -f "${DEPLOY_PATH}/current"))
    echo "🟢 Current Release: ${CURRENT_RELEASE}"
else
    echo "🔴 No active release (current symlink missing)"
fi

# Last successful deployment
if [ -f "${DEPLOY_PATH}/last_successful_release.txt" ]; then
    echo "📝 Last Successful: $(cat ${DEPLOY_PATH}/last_successful_release.txt)"
fi

echo ""

# List releases
echo "📦 Available Releases:"
echo "----------------------"
if [ -d "${DEPLOY_PATH}/releases" ]; then
    cd "${DEPLOY_PATH}/releases"
    RELEASE_COUNT=$(ls -1 | wc -l)
    echo "Total: ${RELEASE_COUNT} releases"
    echo ""
    ls -lht | head -10
else
    echo "No releases found."
fi

echo ""

# Disk usage
echo "💾 Disk Usage:"
echo "--------------"
du -sh "${DEPLOY_PATH}/releases" 2>/dev/null || echo "Cannot calculate"
du -sh "${DEPLOY_PATH}/shared/storage" 2>/dev/null || echo "Cannot calculate"

echo ""

# Laravel status
if [ -L "${DEPLOY_PATH}/current" ]; then
    echo "🔧 Laravel Status:"
    echo "------------------"
    cd "${DEPLOY_PATH}/current"

    # Check .env
    if [ -f ".env" ]; then
        APP_ENV=$(grep "^APP_ENV=" .env | cut -d'=' -f2)
        APP_DEBUG=$(grep "^APP_DEBUG=" .env | cut -d'=' -f2)
        echo "Environment: ${APP_ENV}"
        echo "Debug Mode: ${APP_DEBUG}"
    else
        echo "⚠️  .env file not found!"
    fi

    echo ""

    # Show Laravel version
    ${PHP_BIN} artisan --version 2>/dev/null || echo "Cannot get Laravel version"
fi

echo ""
echo "============================"
