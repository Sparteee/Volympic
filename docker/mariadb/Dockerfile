FROM mariadb:10.6

LABEL maintainer="Nicolas TRUGEON <nicolas.trugeon@univ-lr.fr>"

ARG UID

RUN usermod -u ${UID} mysql; groupmod -g ${UID} mysql;

RUN chown -R mysql:mysql /var/lib/mysql /var/run/mysqld
