FROM alpine:3.8

RUN apk update && \
apk add nginx php5-cli php5-fpm php5-mcrypt php5-openssl php5-pdo php5-pcntl php5-curl \
php5-posix php5-pdo_mysql php5-ctype php5-json php5-phar git

# Copied from https://getcomposer.org/doc/faqs/how-to-install-composer-programmatically.md
# and then modified to run via PHP 5 and 
RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php5 -- --install-dir=/usr/bin/ --quiet

WORKDIR /app
RUN git clone https://github.com/Skepmeister/BFACP.git . && php5 /usr/bin/composer.phar install
COPY .env.php ./

COPY nginx.conf /etc/nginx/
RUN sed -ie 's/127\.0\.0\.1:9000/\/var\/run\/php5-fpm\.sock/g' \
/etc/php5/php-fpm.conf
RUN sed -ie 's/;clear_env/clear_env/g' /etc/php5/php-fpm.conf

EXPOSE 80
CMD php-fpm && nginx
