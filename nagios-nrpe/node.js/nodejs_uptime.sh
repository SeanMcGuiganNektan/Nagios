# crontab
# */15 * * * * /bin/touch /tmp/node_timestamp
# 
# * * * * * /usr/bin/forever list --plain |\ 
# awk -F ' '  '{print $3}' |\ 
# awk -F ':' '{print "DAY",$1,"HOUR",$2,"MIN",$3,"SEC",$4}' |\
# grep -v processes | tail -1 > /tmp/node_uptime

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
