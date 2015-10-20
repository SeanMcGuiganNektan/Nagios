#!/usr/bin/php -c /etc/php.ini

<?php
# Replace the domain "kdog.cmsnagios.com" with your
# Own Nagios Server Domain... If you have a /cms/ server
# like simplecms, replace the img src path accordingly.

 array_shift($argv);
 $f_notify_type =array_shift($argv);  /*1*/
 $f_host_name =array_shift($argv);    /*2*/
 $f_host_alias =array_shift($argv);   /*3*/
 $f_host_state =array_shift($argv);    /*4*/
 $f_host_address =array_shift($argv);   /*5*/
 $f_serv_output =array_shift($argv);   /*6*/
 $f_long_date =array_shift($argv);     /*7*/
 $f_serv_desc  =array_shift($argv);    /*8*/
 $f_serv_state  =array_shift($argv);   /*9*/
 $f_to  =array_shift($argv);           /*10*/
 $f_duration = round((array_shift($argv))/60,2);   /*11*/
 $f_exectime =array_shift($argv);       /*12*/
 $f_totwarnings =array_shift($argv);     /*13*/
 $f_totcritical =array_shift($argv);      /*14*/
 $f_totunknowns =array_shift($argv);     /*15*/
 $f_lastserviceok = array_shift($argv);    /*16*/
 $f_lastwarning = array_shift($argv);     /*17*/
 $f_attempts= array_shift($argv);     /*18*/

 $f_downwarn = $f_duration;
 $f_color="#dddddd";
 if($f_serv_state=="WARNING") {$f_color="#f48400";}
 if($f_serv_state=="CRITICAL") {$f_color="#f40000";}
 if($f_serv_state=="OK") {$f_color="#00b71a";}
 if($f_serv_state=="UNKNOWN") {$f_color="#cc00de";}

 // Check If File Exists ###########
 if($f_notify_type=="PROBLEM")
 {
  $currenttime = time();
  $file_name = "/tmp/$f_host_name.$f_serv_desc.txt";
  if ($f_attempts==1)
   {
     if(file_exists($file_name)==true) {unlink($file_name);}
     $currenttime = $currenttime+round(($f_duration * 60),0);
     file_put_contents($file_name, "$currenttime");
   }
 }

 if($f_notify_type=="RECOVERY")
 {
  $currenttime = time();
  $oldtime = time();
  $file_name = "/tmp/$f_host_name.$f_serv_desc.txt";
  if (file_exists($file_name)==true)
   {
     $oldtime = intval(file_get_contents($file_name));
   }
   $f_downwarn = round(($currenttime - $oldtime)/60,2);
 }


 $f_serv_output = str_replace("(","/",$f_serv_output);
 $f_serv_output = str_replace(")","/",$f_serv_output);
 $f_serv_output = str_replace("[","/",$f_serv_output);
 $f_serv_output = str_replace("]","/",$f_serv_output);


 $subject = "$f_notify_type Service:$f_host_name/$f_serv_desc [$f_serv_state]";

 $from  ="smtpauth@nektan.com";
 $body = "<html><body><table border=0 width='98%' cellpadding=0 cellspacing=0><tr><td valign='top'>\r\n";
 $body .= "<table border=0 cellpadding=0 cellspacing=0 width='97%'>";
 $body .= "<tr bgcolor=$f_color><td width='140'><b><font color=#ffffff>Notification:</font></b></td><td><font ";
 $body .= "color=#ffffff><b>$f_notify_type [$f_serv_state]</b></font></td></tr>\r\n";
 $body .= "<tr bgcolor=#eeeeee><td><b>Service:</b></td><td><font color=#0000CC><b>$f_serv_desc</b></font></td></tr>\r\n";
 $body .= "<tr bgcolor=#fefefe><td><b>Server:</b></td><td><font color=#005500><b>$f_host_alias</b></font></td></tr>\r\n";
 $body .= "<tr bgcolor=#eeeeee><td><b>Address:</b></td><td><font color=#005555><b>$f_host_address</b></font></td></tr>\r\n";
 $body .= "<tr bgcolor=#fefefe><td><b>Date/Time:</b></td><td><font color=#005555>$f_long_date</font></td></tr>\r\n";
 $body .= "<tr bgcolor=#eeeeee><td><b>More Info:</b></td><td><a href='https://prodnagios.platform.nektan.com/nagios/cgi-bin/status.cgi?host=$f_host_name'>\r\n";
 $body .= "http://prodnagios.platform.nektan.com/nagios/cgi-bin/status.cgi?host=$f_host_name</a></td></tr>\r\n";
 $body .= "<tr bgcolor=#fefefe><td><b>Additional Info:</b></td><td>$f_serv_output</td></tr>\r\n";
 $body .= "<tr bgcolor=#eeeeee><td><b>State Duration:</b></td><td><font color=#CC0000><b>$f_duration</b> mins.</font></td></tr> \r\n";
 $body .= "<tr bgcolor=#fefefe><td><b>Service ExecTime:</b></td><td><font color=#CC0000><b>$f_exectime</b></font></td></tr></table>\r\n";
 $body .= "<b><font color=#CC0000>Actions: </font></b><a href='https://prodnagios.platform.nektan.com/nagios/";
 $body .= "cgi-bin/cmd.cgi?cmd_typ=100&host=$f_host_name&service=$f_serv_desc'><b>Stop Obsessing</b></a><br/><br/> \r\n";
 $body .= "</td><td valign='top'><table border=0 cellpadding=0 cellspacing=0 width=250><tr bgcolor=#000055><td><b> \r\n";
 $body .= "<font color=#FFFFFF>Summery</font></b></td><td>.</td></tr> \r\n";
 $body .= "<tr bgcolor=#f6f6ff><td>Total Service Warnings: </td><td> $f_totwarnings</td></tr>\r\n";
 $body .= "<tr bgcolor=#fffef6><td>Total Service Critical: </td><td> $f_totcritical</td></tr>\r\n";
 $body .= "<tr bgcolor=#f6f6ff><td>Total Service Unknowns: </td><td> $f_totunknowns</td></tr>\r\n";
 $body .= "<tr bgcolor=#fffef6><td>Service <i>DOWN</i> For: </td><td> $f_downwarn<i>m</i></td></tr>\r\n";
 $body .= "</table><br/><img src='http://s30.postimg.org/dj2sxfg1d/a_11.png'></td></tr></table><br/>\r\n";
 $body .= "</body></html> \r\n";

 $headers  = "From: $from\r\n";
 $headers .= "Content-type: text/html\r\n";

 /* Send eMail Now... */
 $m_true = mail($f_to, $subject, $body, $headers);
 echo $m_true;

?>
