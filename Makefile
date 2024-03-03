.PHONY: up down stop remove

MAKEPATH := $(abspath $(lastword $(MAKEFILE_LIST)))
PWD := $(dir $(MAKEPATH))
CONTAINERS := $(shell docker ps -a -q -f "name=project-api*")


up:
	docker build -t project-api_server . &&  docker-compose up -d --build

down:
	docker-compose down

server:
	docker exec -it project-api-server-container bash

serverlog:
	docker logs project-api-server-container
