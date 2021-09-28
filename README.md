# project_back

# Installation

1. Run `docker network create --subnet=192.168.0.0/24 --ip-range=192.168.0.0/24 --gateway=192.168.0.1 mynet`
2. Run `docker-compose up --build`
3. Edit hosts file and add `host.docker.internal localhost`
4. Run `docker exec -it project-php /bin/bash`
    4.1 Inside container run `composer install`



### For each database changes (Entity modification)
1. Run `docker exec -it project-php /bin/bash`
2. Inside container run `bin/console d:s:u --force`

