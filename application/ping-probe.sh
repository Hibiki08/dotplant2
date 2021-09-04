#!/bin/bash
set -e

pong_cnt=`SCRIPT_NAME=/_tech/php-ping SCRIPT_FILENAME=/_tech/php-ping QUERY_STRING= REQUEST_METHOD=GET cgi-fcgi -bind -connect 127.0.0.1:9000 | grep pong | wc -l`

if [ "x${pong_cnt}" = 'x1' ]; then
  exit 0;
fi

exit 1