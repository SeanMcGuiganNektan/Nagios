<?php

 array_shift($argv);
 $f_notify_type =array_shift($argv);
 $f_host_name =array_shift($argv);
 $f_host_alias =array_shift($argv);
 $f_host_state =array_shift($argv);
 $f_host_address =array_shift($argv);
 $f_host_output =array_shift($argv);
 $f_long_date =array_shift($argv);
 $f_serv_desc  =array_shift($argv);
 $f_serv_state  =array_shift($argv);
 $f_to  =array_shift($argv);
 $f_totalup  =array_shift($argv);
 $f_totaldown=array_shift($argv);

 $subject = "$f_notify_type Service:$f_host_name";

 $from  ="smtpauth@nektan.com";
 $body = "<html><body><b>Notification: </b> <font color=#CC0000>$f_notify_type</font><br/> \r\n";
 $body .= "<b>Host: </b> <font color=#007700>$f_host_alias</font> </br> \r\n";
 $body .= "<b>Address: </b> <font color=#005555>$f_host_address</font><br/> \r\n";
 $body .= "<b>Date/Time: </b><font color=#005555>$f_long_date</font><br/> \r\n";
 $body .= "<b>More Info: </b><a href='http://prodnagios.platform.nektan.com/nagios/cgi-bin/status.cgi?host=$f_host_name'>";
 $body .= "http://prodnagios.platform.nektan.com/nagios/cgi-bin/status.cgi?host=$f_host_name</a><br/> \r\n";
 $body .= "<b>Additional Info: </b>$f_host_output<br/> \r\n";
 $body .= "<b>Total Servers Up: </b>$f_totalup<br/>";
 $body .= "<b>Total Servers Down: </b>$f_totaldown<br/> \r\n";
 $body .= "<b><font color=#CC0000>Actions: </font></b><a href='http://prodnagios.platform.nektan.com/nagios/cgi-bin/cmd.cgi?cmd_typ=100&host=$f_host_name&service=$f_serv_desc'><b>Stop Obsessing</b></a><br/> \r\n";
 $body .= "</body></html> \r\n";

 $headers = "From: $from\r\n";
 $headers = $headers."Content-type: text/html\r\n";

 /* Send eMail Now... */
 mail($f_to, $subject, $body, $headers);

?>

