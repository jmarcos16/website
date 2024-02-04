FROM nginx:alpine 

COPY nginx.conf /etc/nginx/nginx.conf

RUN apk add --no-cache certbot openssl bash

RUN rm -rf /etc/nginx/conf.d/default.conf

RUN adduser -D -H -u 1000 -s /bin/bash www-data -G www-data

RUN mkdir -p /var/www && \
    chown -R www-data:www-data /var/www && \
    chmod 755 -R /var/www

WORKDIR /etc/nginx

RUN apk del --no-cache