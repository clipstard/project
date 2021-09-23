#!/bin/bash

export FPMPORT=${1:-9000}
export SCRIPT_NAME=/status
export SCRIPT_FILENAME=/status
export QUERY_STRING='json&full'
export REQUEST_METHOD=GET

(cgi-fcgi -bind -connect 127.0.0.1:${FPMPORT} | awk 'NR>5') || exit 1
