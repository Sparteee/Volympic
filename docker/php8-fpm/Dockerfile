# lp2021 --> php8.0
FROM nicolasunivlr/php:lp2021
ARG UID

LABEL maintainer="Nicolas TRUGEON <nicolas.trugeon@univ-lr.fr>"

RUN touch /usr/local/etc/php/conf.d/max.ini && echo "max_execution_time = 120;" >> /usr/local/etc/php/conf.d/max.ini

# Update composer
RUN composer self-update

# Update symfony bin
RUN symfony self:update

# Add user
RUN useradd -mu ${UID} monuser

RUN echo 'alias sf="php bin/console"' >> /home/monuser/.bashrc

WORKDIR /var/www/docker/
