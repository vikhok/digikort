# Use an official Ubuntu base image
FROM ubuntu:20.04

# Set environment variables
ENV DEBIAN_FRONTEND=noninteractive

# Update package list and install necessary packages
RUN apt-get update -y && apt-get install -y libmariadb-dev
RUN docker-php-ext-install mysqli

# Expose ports for HTTP, HTTPS, and MySQL
EXPOSE 80 443 3306

# Create a supervisord configuration file
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start XAMPP services using supervisord
CMD ["/usr/bin/supervisord"]

#PHP image
FROM php:8.0-apache
WORKDIR /var/www/html
