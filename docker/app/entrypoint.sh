#!/bin/bash

# Laravel Docker Entrypoint Script
# This script ensures proper permissions for Laravel storage and cache directories

echo "🚀 Starting Laravel Docker container..."

# Laravel storage and cache directories permissions setup
echo "🔧 Setting up Laravel permissions..."

if [ -d "/app/storage" ]; then
    echo "📁 Setting permissions for storage directory..."
    chown -R www-data:www-data /app/storage
    chmod -R 775 /app/storage
    echo "✅ Storage permissions set successfully"
fi

if [ -d "/app/bootstrap/cache" ]; then
    echo "📁 Setting permissions for bootstrap/cache directory..."
    chown -R www-data:www-data /app/bootstrap/cache
    chmod -R 775 /app/bootstrap/cache
    echo "✅ Bootstrap cache permissions set successfully"
fi

# Additional Laravel optimizations
if [ -f "/app/artisan" ]; then
    echo "🎯 Running Laravel optimizations..."

    # Ensure Laravel can write to necessary directories
    if [ ! -d "/app/storage/logs" ]; then
        mkdir -p /app/storage/logs
        chown -R www-data:www-data /app/storage/logs
        chmod -R 775 /app/storage/logs
    fi

    if [ ! -d "/app/storage/framework/sessions" ]; then
        mkdir -p /app/storage/framework/sessions
        chown -R www-data:www-data /app/storage/framework/sessions
        chmod -R 775 /app/storage/framework/sessions
    fi

    if [ ! -d "/app/storage/framework/views" ]; then
        mkdir -p /app/storage/framework/views
        chown -R www-data:www-data /app/storage/framework/views
        chmod -R 775 /app/storage/framework/views
    fi

    if [ ! -d "/app/storage/framework/cache" ]; then
        mkdir -p /app/storage/framework/cache
        chown -R www-data:www-data /app/storage/framework/cache
        chmod -R 775 /app/storage/framework/cache
    fi

    echo "✅ Laravel directory structure verified"
fi

# Node.js and Vite setup
if [ -f "/app/package.json" ]; then
    echo "📦 Setting up Node.js dependencies..."

    # Install npm dependencies if node_modules doesn't exist
    if [ ! -d "/app/node_modules" ]; then
        echo "📥 Installing npm dependencies..."
        npm install
        echo "✅ NPM dependencies installed successfully"
    fi

    # Build assets if build directory doesn't exist
    if [ ! -d "/app/public/build" ]; then
        echo "🔨 Building Vite assets..."
        npm run build
        echo "✅ Vite assets built successfully"
    fi

    echo "✅ Node.js setup completed"
fi

echo "🎉 Laravel container initialization completed successfully!"

# Execute the original command
exec "$@"
