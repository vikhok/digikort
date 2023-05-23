#PHP image
# FROM php:8.0-apache
# COPY . /var/www/html
# WORKDIR /var/www/html
# RUN docker-php-ext-install pdo pdo_mysql gd
# EXPOSE 80

#PHP image
# FROM php:8.0-apache
# RUN apt-get update && apt-get install -y \
#     libfreetype6-dev \
#     libjpeg62-turbo-dev \
#     libpng-dev
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg
# RUN docker-php-ext-install pdo pdo_mysql gd
# COPY . /var/www/html
# WORKDIR /var/www/html
# EXPOSE 80


FROM php:8.0-apache
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo pdo_mysql gd
RUN a2enmod ssl
COPY . /var/www/html
WORKDIR /var/www/html
COPY ssl/apache_ssl.conf /etc/apache2/conf-available/ssl.conf
COPY ssl/certificate.crt /etc/apache2/certificate.crt
COPY ssl/private.key /etc/apache2/private.key
RUN a2enconf ssl
EXPOSE 80
EXPOSE 443
CMD ["apache2-foreground"]
