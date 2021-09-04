#!/bin/bash
set -e

proc_cnt=$(SCRIPT_NAME=/_tech/php-status SCRIPT_FILENAME=/_tech/php-status REQUEST_METHOD=GET cgi-fcgi -bind -connect 127.0.0.1:9000 | grep 'total processes' | awk '{print $3}')

if [ $proc_cnt -gt 0 ]; then
  exit 0
fi

exit 1