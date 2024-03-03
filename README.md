# Project  API #

API for managing Api Request

## Install

Install using composer

``` bash
$ composer install
```

## Config

Create .env file with your local settings

``` bash
$ cp .env.example .env
```

## Tests

Run unit tests

``` bash
./vendor/bin/codecept run
```

## Run with Docker

#### Local environment

* Nginx
* PHP 8.0 (FPM)

If you use Linux a *Makefile* is included, so you can run these commands to start and stop all containers at once.
Go to project root and run:

To start containers
```
make up
```

To stop containers
```
make down
```

#### First time instructions:

###### Linux
1) Install Docker and Docker compose
2) Create .env file using .env.example info
3) Create the shared network if not exist ```docker network create testingnetwork```
4) In project root execute ``` make up ``` 
5) In project root execute ``` make server ``` and go inside php + nginx docker.

#### Endpoints

Base url: ``` http://localhost:8030 ```

#### Docker ports
```
server port: 8030
```

#### Available docker commands
```
make up: Start containers
make down: Stop containers   
make server: Go inside php container
make serverlog: Display php container logs
```