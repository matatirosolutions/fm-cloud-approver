FROM php:8.1

RUN apt-get update \
  && apt-get install -y libzip-dev libcurl4-openssl-dev git wget sudo --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install curl zip;

RUN wget https://getcomposer.org/download/2.6.3/composer.phar \
    && mv composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer

RUN wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb \
    && sudo dpkg -i google-chrome*.deb

COPY entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

WORKDIR /var/approve

ENTRYPOINT ["/entrypoint.sh"]
