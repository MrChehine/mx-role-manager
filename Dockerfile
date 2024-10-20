FROM php:8.2-cli-alpine
RUN docker-php-ext-install mysqli pdo pdo_mysql