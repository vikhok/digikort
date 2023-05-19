#Ubuntu image
FROM ubuntu:latest
RUN apt-get -y update

#PHP image
FROM php:8.0-apache
COPY . /var/www/html
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli