ARG PHP_IMAGE=php:7.2-cli

FROM $PHP_IMAGE

WORKDIR /var/composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"; \
    php -r "if (hash_file('SHA384', 'composer-setup.php') === '544e09ee996cdf60ece3804abc52599c22b1f40f4323403c44d44fdfdd586475ca9813a858088ffbc1f233e9b180f061') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"; \
    php composer-setup.php; \
    php -r "unlink('composer-setup.php');"

COPY ./runner /var/lambda
VOLUME ./io /var/io
VOLUME ./task /var/task

ENV PHP_VERSION 7.2 \
    LAMBDA_NAME sample \
    LAMBDA_FILE handler.php \
    LAMBDA_HANDLER hello \
    LAMBDA_WORKSPACE /var/task

WORKDIR /var/lambda

RUN php /var/composer/composer.phar install

ENTRYPOINT php /var/lambda/bin/worker.php