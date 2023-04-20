FROM ubuntu:20.04

# Install required packages
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
        apache2 \
        php \
        php-mysql \
        mysql-server \
        mysql-client && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Copy the Apache config file
COPY apache2.conf /etc/apache2/apache2.conf

# Copy the PHP app files
COPY . /var/www/html/

# Set up the MySQL database
RUN service mysql start && \
    mysql -e "CREATE DATABASE tenfe;" && \
    mysql -e "GRANT ALL PRIVILEGES ON tenfe.* TO 'root'@'localhost' IDENTIFIED BY '123321';"

# Expose port 80
EXPOSE 80

# Start Apache and MySQL
CMD service mysql start && /usr/sbin/apache2ctl -D FOREGROUND
