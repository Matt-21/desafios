composer install
cp .env.example .env
php artisan key:generate
sudo chown $USER -R storage
docker compose up -d --build
docker exec -it laravel-docker-laravel-app-1 bash
cd /usr/share/nginx
