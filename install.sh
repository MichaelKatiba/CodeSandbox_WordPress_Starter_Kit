#!/bin/bash

# 1. Load variables safely
if [ -f .env ]; then
  export $(cat .env | grep -v '#' | awk '/=/ {print $1}')
fi

# 2. Check if DB is ready
echo "Waiting for Database..."
sleep 10

# 3. Fix Permissions (The Fix for the Warning)
echo "🔧 Fixing file permissions..."
# Create the folder if it doesn't exist
mkdir -p wp-content
# Make it writable by everyone (Docker container + You)
chmod -R 777 wp-content

# 4. Install WordPress
echo "🚀 Installing WordPress..."

docker compose run --rm wpcli wp core install \
  --url="http://localhost:${WP_PORT}" \
  --title="${PROJECT_NAME}" \
  --admin_user="admin" \
  --admin_password="123" \
  --admin_email="admin@example.com" \
  --skip-email

echo "--------------------------------------------------"
echo "✅ Success! Website is ready."
echo "💻 URL: http://localhost:${WP_PORT}"
echo "👤 User: admin"
echo "🔑 Pass: 123"
echo "--------------------------------------------------"