FROM node:12.16.2-alpine3.11
COPY . /usr/src/webapp
WORKDIR /usr/src/webapp
CMD ["sh", "start.sh"]
