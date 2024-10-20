#!/bin/bash

# CONFIGURATION
server_port=8000
temp_php_file=temp-phpinfo.php
result_file=result-phpinfo.html

# EXECUTION

if [ -z "$1" ]
then
    php -S localhost:${server_port} &
    pid=$!
else
    php -c ${1} -S localhost:${server_port} &
    pid=$!
fi
sleep 1
echo $(curl -L http://localhost:${server_port}/${temp_php_file}) > $result_file
kill $pid
