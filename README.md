cp .env.example .env

edit database connection

docker compose up --build -d
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
and it should be running at http://localhost:8000