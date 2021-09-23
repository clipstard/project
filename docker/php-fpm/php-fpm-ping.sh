#!/bin/bash

export FPMPORT=${1:-9000}
export SCRIPT_NAME=/ping
export SCRIPT_FILENAME=/ping
export QUERY_STRING=
export REQUEST_METHOD=GET

cgi-fcgi -bind -connect 127.0.0.1:${FPMPORT} || exit 1
