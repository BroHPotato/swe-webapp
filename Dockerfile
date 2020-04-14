FROM lorisleiva/laravel-docker:7.4
COPY . /usr/src/webapp
WORKDIR /usr/src/webapp
EXPOSE 9000
CMD ["sh", "start.sh"]
