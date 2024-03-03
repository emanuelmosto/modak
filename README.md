# Modak Project #

Implementation of Rate-Limited Notification Service

This Api has several endpoints:

POST http://localhost:8030/api/v1/messages

payload:

```json
{
  "id": "7875be4b-917d-4aff-8cc4-5606c36bf418",
  "type": "Status",
  "description": "Info message",
  "recipient_id": "7875be4b-917d-4aff-8cc4-5606c36bf418",
  "clean_text": "Text body of the email",
  "rate_limit": {
    "rate": 2,
    "unit": "minute"
  }
}
```
As you can see in this example, the message encapsulates all the information necessary for the system to know what to do with it. 
In this case, a message of type "Status" has a rate limit of 2 request per minute and could be for example:

```json

{
    {
      "rate_limit": {
        "rate": 4,
        "unit": "second"    // 4 request per second
      }
    },
    {
      "rate_limit": {
        "rate": 2,
        "unit": "hour"      // 2 request per hour
      }
    },
    {
      "rate_limit": {
        "rate": 2,          // 2 request per day
        "unit": "day"
      }
    }
}
```


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