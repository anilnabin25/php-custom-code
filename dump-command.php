<?php
$host = "172.16.238.10";
$user = "wwwaap";
$pw = 'Wwwaap@123';
$db_name = "mysql";
$dsn = "mysql:host=$host;dbname=$db_name";
//$command = "mysqldump --hex-blob --routines --skip-lock-tables --log-error=mysqldump_error.log  -u $user –p $pw -h $host $db_name > dumpfilename.sql";
//$command = "mysqldump --log-error=mysqldump_error.log  -u $user --password=$pw -h $host $db_name > dumpfilename.sql";
//$command = "mysqldump -u $user --password=$pw -h $host $db_name > dumpfilename.sql";
//$command = "mysql -u $user --password=$pw -h $host";

$command = "(mysqldump --log-error=mysqldump_error.log  -u $user --password=$pw -h $host $db_name > dumpfilename.sql)  2>&1";
exec($command, $output, $return);
//print_r($output);
//print_r($return);
if ($return !== 0) {
  echo "mysqldump for {$host} : {$db_name} failed with a return code of {$return}\n\n";
  echo "Error message was:\n";
  $file = escapeshellarg("mysqldump_error.log");
  echo "<br>";
  print_r($file);
  echo "<br>";
  die;
  $message = `tail -n 1 $file`;
  echo "- $message\n\n";
}else{
  echo " dumped all the the data please check it ";
}
