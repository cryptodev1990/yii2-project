COMPOSE=docker-compose -f docker.yml
COMPOSE_COMMAND=$(COMPOSE) exec $(CONTAINER) sh
COLOR_HEADER=\e[92m
COLOR=\e[93m
END=\033[0m
CONTAINER=php
PROJECT_NAME := Yii 2 Project

.SILENT: help stop down pre-build build start post-build login test

help:
	printf "$(COLOR_HEADER)$(PROJECT_NAME) management\n\n" && \
	printf "$(COLOR)make build$(END)\t Build and start containers\n" && \
	printf "$(COLOR)make down$(END)\t Remove created containers and networks\n" && \
	printf "$(COLOR)make test$(END)\t Run Codeception tests\n" && \
	printf "$(COLOR)make start$(END)\t Start created containers\n" && \
	printf "$(COLOR)make restart$(END)\t Restart created containers\n" && \
	printf "$(COLOR)make stop$(END)\t Stop containers without removing\n" && \
	printf "$(COLOR)make pre-build$(END)\t Remove old artifacts and containers\n" && \
	printf "$(COLOR)make post-build$(END)\t Run app migrations and build assets\n" && \
	printf "$(COLOR)make login$(END)\t Attach project container session\n" && \
	printf "$(COLOR)make prune$(END)\t Remove all unused containers, networks, images, volumes\n"

stop:
	$(COMPOSE) stop

down:
	$(COMPOSE) down

pre-build: down

build: pre-build
	$(COMPOSE) build
	@make start
	@make post-build

start:
	$(COMPOSE) up -d

restart:
	$(COMPOSE) restart

post-build:
	@echo 'Initializing database...'
	@sleep 20
	$(COMPOSE_COMMAND) -c 'php yii cache/flush-all'
	$(COMPOSE_COMMAND) -c 'php yii app/init'
	@npm i
	@npm run dev

login:
	$(COMPOSE_COMMAND)

test:
	$(COMPOSE_COMMAND) -c './vendor/bin/codecept run -vvv'

prune: down
	@docker system prune -af