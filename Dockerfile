# Use an official Ubuntu base image
FROM ubuntu:20.04

# Set environment variables
ENV DEBIAN_FRONTEND=noninteractive

# Update package list and install necessary packages
RUN apt-get update && apt-get install -y \
  wget \
  unzip \
  supervisor

# Download and install XAMPP

RUN wget https://sourceforge.net/projects/xampp/files/XAMPP%20Linux/8.2.0/xampp-linux-x64-8.2.0-0-installer.run -P /tmp
RUN chmod +x /tmp/xampp-linux-x64-8.2.0-0-installer.run
RUN /tmp/xampp-linux-x64-8.2.0-0-installer.run --mode unattended

# Expose ports for HTTP, HTTPS, and MySQL
EXPOSE 80 443 3306

# Create a supervisord configuration file
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Start XAMPP services using supervisord
CMD ["/usr/bin/supervisord"]