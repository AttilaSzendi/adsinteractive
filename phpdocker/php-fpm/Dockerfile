FROM php:8.4-fpm

WORKDIR /application

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY ./entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

ENTRYPOINT ["entrypoint.sh"]
CMD ["php-fpm"]
