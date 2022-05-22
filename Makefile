default:
	@echo 'Enter command'

# ----------------------------------------------------------------------------------------------------------------------

init: down update
update: git-pull up composer-i yii-migrate

# ----------------------------------------------------------------------------------------------------------------------

down:
	docker compose down -v --remove-orphans

git-pull:
	git pull

up:
	docker compose up -d --build --remove-orphans

composer-i:
	docker compose run --rm php-fpm composer i

yii-migrate:
	docker compose run --rm php-fpm php yii migrate --interactive=0

# ----------------------------------------------------------------------------------------------------------------------

composer-u:
	docker compose run --rm php-fpm composer u
