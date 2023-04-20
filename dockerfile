FROM php:8.0-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y mysql-client mysql-server
RUN echo "mysql-server mysql-server/root_password password 123321" | debconf-set-selections
RUN echo "mysql-server mysql-server/root_password_again password 123321" | debconf-set-selections

RUN docker-php-ext-install mysqli pdo pdo_mysql

COPY . ./

EXPOSE 80

RUN chown -R www-data:www-data /var/www/html/
RUN a2enmod rewrite

COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf
CMD service mysql start && apache2-foreground
