FROM yiisoftware/yii2-php:7.4-apache

RUN apt-get update && apt-get -y install cron
ADD cron-evrms /etc/cron.d/cron-evrms
RUN chmod 0644 /etc/cron.d/cron-evrms
RUN crontab -u root /etc/cron.d/cron-evrms
