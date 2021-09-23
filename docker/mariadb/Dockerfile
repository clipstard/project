FROM mariadb:10.4
RUN mkdir -p /etc/mysql/conf.d
RUN touch /etc/mysql/conf.d/docker.cnf

RUN sed -i '/skip-name-resolve/d' /etc/mysql/my.cnf
