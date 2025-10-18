FROM php:8.2-cli-alpine

RUN apk add --no-cache postgresql-dev && docker-php-ext-install pdo_pgsql

COPY src/ /app

WORKDIR /app

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80"]
