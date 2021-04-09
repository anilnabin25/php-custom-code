<?php
//max_allowed_packet
ini_set('max_allowed_packet', '-1');
ini_set('memory_limit', '-1');
ini_set('max_execution_time', '0');
print_b(phpinfo());

$host = "172.16.238.10";
$user = "wwwaap";
$pw = 'Wwwaap@123';
$db_name = "mysql";
$file_name = "backup_" . date("y-m-d_h:i:sa") . '.sql';
//print_r($file_name);
//die;
$command = "(mysqldump --log-error=mysqldump_error.log  -u $user --password=$pw -h $host $db_name > $file_name)  2>&1";
exec($command, $output, $return);
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
  echo "All the data exported to the root directory please check it";
}
