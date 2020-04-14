FROM lorisleiva/laravel-docker:7.4
COPY . /usr/src/webapp
WORKDIR /usr/src/webapp
CMD ["sh", "start.sh"]
