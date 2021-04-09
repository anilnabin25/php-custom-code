<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$host = "172.16.238.10";
$user = "wwwaap";
$pass = 'Wwwaap@123';
$db_name = "wwwaap";
$file_name = "/backup_" . date("y-m-d_h:i:sa") . '.sql';

$dir = dirname(__FILE__) . $file_name;

echo "<h3>Backing up database to `<code>{$dir}</code>`</h3>";

exec("mysqldump --user={$user} --password={$pass} --host={$host} {$db_name} --result-file={$dir} 2>&1", $output, $return);
//exec("mysqldump --user={$user} --password={$pass} --host={$host} {$db_name} > {$dir} 2>&1", $output, $return);

print_r($output);

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
