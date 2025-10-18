FROM nginx:alpine

RUN apk add --no-cache php82 php82-fpm php82-pdo_pgsql supervisor

COPY nginx.conf /etc/nginx/nginx.conf
COPY default.conf /etc/nginx/conf.d/default.conf
COPY src/ /var/www/html/
COPY supervisord.conf /etc/supervisord.conf

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
