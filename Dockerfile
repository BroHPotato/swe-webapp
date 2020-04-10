# docker run --run -d -p 9999:9999 rrr/api
FROM node:12.16.2-alpine3.11
COPY . /usr/src/webapp
EXPOSE 9999
WORKDIR /usr/src/webapp
CMD ["sh", "start.sh"]
