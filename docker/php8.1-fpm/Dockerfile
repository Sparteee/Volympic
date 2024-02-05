# lp2022 --> php8.1
FROM nicolasunivlr/php:lp2022
ARG UID

LABEL maintainer="Nicolas TRUGEON <nicolas.trugeon@univ-lr.fr>"

# Update composer
RUN composer self-update

# Add user
RUN useradd -mu ${UID} monuser

COPY completion.sh /etc/bash_completion.d/console

RUN echo 'alias sf="php bin/console"' >> /home/monuser/.bashrc
RUN echo 'source /etc/bash_completion.d/console' >> /home/monuser/.bashrc

WORKDIR /var/www/docker/