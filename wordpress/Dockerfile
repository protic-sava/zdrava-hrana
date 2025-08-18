FROM wordpress:latest

RUN a2enmod headers rewrite

COPY wp-content /var/www/html/wp-content

RUN chown -R www-data:www-data /var/www/html/wp-content \
    && find /var/www/html/wp-content -type d -exec chmod 755 {} \; \
    && find /var/www/html/wp-content -type f -exec chmod 644 {} \;



EXPOSE 80
