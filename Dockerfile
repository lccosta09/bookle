FROM debian:10-slim

RUN apt-get update && apt-get install curl -y

RUN curl -sL https://deb.nodesource.com/setup_12.x | bash -
RUN apt-get install -y nodejs

WORKDIR /var/www/html/bookle

ENTRYPOINT ["tail", "-f", "/dev/null"]