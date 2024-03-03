#!/bin/bash
service nginx start &
/usr/local/sbin/php-fpm -c /usr/local/etc/php
