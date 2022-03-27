up:
	docker-compose up --build

serve:
	docker exec -it centra_php_1 php -S 0.0.0.0:8000 -t public

composer-install:
	docker exec -it centra_php_1 composer install --optimize-autoloader

test:
	docker exec -it centra_php_1 composer test

check:
	docker exec -it centra_php_1 composer check
