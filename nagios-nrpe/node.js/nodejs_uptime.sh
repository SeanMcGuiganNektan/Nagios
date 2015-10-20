#!/bin/bash

PID="/var/nektan/app/nektan-lobby/bin/www.pid"
MARK="/tmp/node_timestamp"

if [ "$PID" -nt "$MARK" ]; then
   echo "$(cat /tmp/node_uptime)"
   exit 2
else
   echo "$(cat /tmp/node_uptime)"
   exit 0
fi 
