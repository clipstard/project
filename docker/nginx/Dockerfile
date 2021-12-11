FROM ubuntu:14.04

ARG APP_ENV
ENV DEBIAN_FRONTEND noninteractive

ARG UID
ARG GID
RUN groupadd -g ${GID} app
RUN useradd -d /home/app -s /bin/bash -u ${UID} -g ${GID} app
RUN mkdir /home/app
RUN chown -R app:app /home/app

RUN echo "deb http://archive.ubuntu.com/ubuntu trusty main restricted universe\ndeb-src http://archive.ubuntu.com/ubuntu trusty main restricted universe\ndeb http://archive.ubuntu.com/ubuntu trusty-updates main restricted universe\ndeb-src http://archive.ubuntu.com/ubuntu trusty-updates main restricted universe\n" > /etc/apt/sources.list

# Install build tools for nginx
RUN apt-get update && \
	apt-get install git -y && \
    apt-get install build-essential wget -y && \
    apt-get build-dep nginx-full -y && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

ENV NGINX_VERSION 1.9.9

# Nginx
RUN cd /usr/src/ && wget http://nginx.org/download/nginx-${NGINX_VERSION}.tar.gz && tar xf nginx-${NGINX_VERSION}.tar.gz && rm -f nginx-${NGINX_VERSION}.tar.gz

# Compiling nginx
RUN cd /usr/src/nginx-${NGINX_VERSION} && ./configure \
        --prefix=/etc/nginx \
        --conf-path=/etc/nginx/nginx.conf \
        --error-log-path=/var/log/nginx/error.log \
        --sbin-path=/usr/sbin \
        --http-client-body-temp-path=/var/lib/nginx/body \
        --http-fastcgi-temp-path=/var/lib/nginx/fastcgi \
        --http-log-path=/var/log/nginx/access.log \
        --http-proxy-temp-path=/var/lib/nginx/proxy \
        --http-scgi-temp-path=/var/lib/nginx/scgi \
        --http-uwsgi-temp-path=/var/lib/nginx/uwsgi \
        --lock-path=/var/lock/nginx.lock \
        --pid-path=/var/run/nginx.pid \
        --with-http_addition_module \
        --with-http_dav_module \
        --with-http_geoip_module \
        --with-http_gzip_static_module \
        --with-http_image_filter_module \
        --with-http_realip_module \
        --with-http_stub_status_module \
        --with-http_ssl_module \
        --with-http_sub_module \
        --with-http_xslt_module \
        --with-ipv6 \
        --with-debug \
        --with-sha1=/usr/include/openssl \
        --with-md5=/usr/include/openssl

RUN cd /usr/src/nginx-${NGINX_VERSION} && make && make install
# Create the /var/lib/nginx directory (for temp paths)
RUN mkdir -p /var/lib/nginx

RUN chown -R app:app /var/lib/nginx

ADD nginx.conf /etc/nginx/
ADD symfony.conf /etc/nginx/sites-enabled/

RUN mkdir /etc/nginx/conf.d

#RUN echo "upstream php-upstream { server php:9001; }" > /etc/nginx/conf.d/upstream.conf

RUN echo 'alias ls="ls $LS_OPTIONS"' >> ~/.bashrc
RUN echo 'alias ll="ls $LS_OPTIONS -l"' >> ~/.bashrc
RUN echo 'alias l="ls $LS_OPTIONS -lA"' >> ~/.bashrc

RUN echo 'export TERM=xterm' >> ~/.bashrc

RUN echo "starting nginx +"

EXPOSE 80
EXPOSE 443

CMD ["nginx", "-g", "daemon off;"]
