FROM wyveo/nginx-php-fpm:latest

COPY . /usr/share/nginx/
COPY nginx.conf /etc/nginx/conf.d/default.conf

WORKDIR /usr/share/nginx/

RUN chown nginx -R storage


