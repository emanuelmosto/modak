#####################################################
### This dockerfile is used on local machines only ##
#####################################################

FROM project-api_server

RUN cd /var/www/html/ && composer install -n
EXPOSE 80
CMD ["/var/www/init.sh"]