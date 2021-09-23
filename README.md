# project_back

# Installation

1. Run `docker-compose up --build`
2. Edit hosts file and add `host.docker.internal localhost`
3. Run `docker exec -it project-php /bin/bash`
    3.1 Inside container run `composer install`
   


### For each database changes (Entity modification)
1. Run `docker exec -it project-php /bin/bash`
2. Inside container run `bin/console d:s:u --force`
