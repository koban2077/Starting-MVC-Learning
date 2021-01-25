FROM php:7.4-fpm

COPY . /var/www/hillel.loc

WORKDIR /var/www/hillel.loc/public

RUN apt-get update && apt-get install -y \

                   && docker-php-ext-install pdo_mysql

CMD ["php", "-S", "0.0.0.0:8080"]
EXPOSE 0000

