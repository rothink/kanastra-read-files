CONTAINER_NAME=kanastra.app

# Instala a aplicação e sobe o sistema
install:
	make build
	make up
	make clear
	make migration

build:
	docker compose build
# Sobe o sistema
up:
	docker compose up -d

# Roda os testes unitário.
test:
ifdef group
	docker exec -t $(CONTAINER_NAME) ./vendor/bin/phpunit --group="$(group)" --stop-on-failure
else
	docker exec -t $(CONTAINER_NAME) ./vendor/bin/phpunit --stop-on-failure
endif

test-filter:
ifdef filter
	docker exec -t $(CONTAINER_NAME) ./vendor/bin/phpunit --filter="$(filter)" --stop-on-failure
endif


# Rodas as migrations e limpa o banco
migration:
	docker exec -it $(CONTAINER_NAME) php artisan migrate:fresh

# Roda os as migrations, limpa o banco e popula
migration-seed:
	docker exec -it $(CONTAINER_NAME) php artisan migrate:fresh --seed

# Entra no bash do container
bash:
	docker exec -it $(CONTAINER_NAME) bash

# Limpa os caches, gera as entities e os proxies
clear:
	docker exec $(CONTAINER_NAME) bash  -c "php artisan optimize:clear"

worker:
	docker exec -it $(CONTAINER_NAME) php artisan schedule:work
