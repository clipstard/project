# project_back

## Pre-requisites

* clone this repository under C:/Users/`user`/Projects/ folder 
 
    or make sure project directory is in this folder


* open Notepad with `Run as Administrator` rights and then
        
    open file `C:\Windows\System32\drivers\etc\hosts` and att the following line
  
        host.docker.internal localhost

## Installation

1. Run `docker network create --subnet=192.168.0.0/24 --ip-range=192.168.0.0/24 --gateway=192.168.0.1 mynet`
2. Run `docker-compose up --build`
3. Run `docker exec -it project-php /bin/bash`
    4.1 Inside container run `composer install`



### For each database changes (Entity modification)
1. Run `docker exec -it project-php /bin/bash`
2. Inside container run `bin/console d:s:u --force`

