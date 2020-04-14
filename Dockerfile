FROM bitnami/laravel:6
COPY . /usr/src/webapp
WORKDIR /usr/src/webapp
CMD ["sh", "start.sh"]
