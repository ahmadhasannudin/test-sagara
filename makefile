init:
	@cp .env.example .env
	@docker-compose down
	@docker-compose build
	@docker-compose up -d
	@docker-compose exec -it app php artisan key:generate
	@docker-compose exec -it app php artisan migrate:refresh
	@docker-compose exec -it app php artisan db:seed 
.PHONY: init
