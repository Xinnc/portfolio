#!/bin/bash

set -e

echo "============================================"
echo "		Updating project"
echo "============================================"

git pull

echo ""
echo "============================================"
echo "		Docker compose"
echo "============================================"

cd .deploy

docker compose up -d --build

echo ""
echo "============================================"
echo "		Laravel"
echo "============================================"

docker compose exec backend php artisan migrate:fresh --seed
docker compose exec backend php artisan optimize
docker compose exec backend php artisan storage:link || true
docker compose exec backend composer install --no-dev --optimize-autoloader

echo ""
echo "============================================"
echo "		Done!"
echo "============================================"
