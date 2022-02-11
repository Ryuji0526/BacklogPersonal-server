FROM nginx:1.15.7-alpine
# timezone
ARG TZ
COPY ./nginx/conf.d/ /etc/nginx/conf.d/
COPY ./nginx/logs/ /etc/nginx/logs/
COPY ./ /var/www/
RUN apk update && apk --update add tzdata && \
  cp /usr/share/zoneinfo/${TZ} /etc/localtime && \
  apk del tzdata && \
  rm -rf /var/cache/apk/*