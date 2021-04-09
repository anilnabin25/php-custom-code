<?php
ini_set('max_execution_time', '0');
ini_set('memory_limit', '-1');

$host = "172.16.238.10";
$user = "wwwaap";
$pw = 'Wwwaap@123';
$db_name = "test";
$dsn = "mysql:host=$host;dbname=$db_name";

$connect = new PDO($dsn, $user, $pw);
$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$get_all_table_query = "SHOW FULL TABLES";
$statement = $connect->prepare($get_all_table_query);
$statement->execute();
$result = $statement->fetchAll();

$output = '';
$data = $_GET['data'];
foreach ($result as $table) {

  $output .= "\n\n--  ==== started " . $table[0] . " ====";
  $show_table_query = "SHOW CREATE TABLE " . $table[0] . "";
  $statement = $connect->prepare($show_table_query);
  $statement->execute();
  $show_table_result = $statement->fetchAll();

  if ($table[1] == "BASE TABLE") {
    // for table export
    foreach ($show_table_result as $show_table_row) {
      $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
    }
    if ($data == 1) {
      $column_names = column_names($connect, $table[0]);
      $select_query = "SELECT " . implode(",", $column_names["column_names_with_quote"]) . " FROM " . $table[0] . "";
      $statement = $connect->prepare($select_query);
      $statement->execute();
      $table_row = $statement->rowCount();

      for ($i = 0; $i < $table_row; $i++) {
        $single_result = $statement->fetch(PDO::FETCH_ASSOC);
        $table_column_array = [];
        $table_value_array = [];
        foreach ($single_result as $key => $value) {
          array_push($table_column_array, $key);
          array_push($table_value_array, json_encode($value));
        }

        $output .= "\nINSERT INTO $table[0](";
        $output .= "" . implode(", ", $column_names["column_names"]) . ") VALUES (";
        $output .= "" . implode(",", $table_value_array) . ");\n";
      }
    }
  } else {
    // for view export
    foreach ($show_table_result as $show_table_row) {
      $output .= "\n\n" . $show_table_row["Create View"] . ";\n\n";
    }

    //    $select_query = "SELECT * FROM " . $table[0] . "";
    //    $statement = $connect->prepare($select_query);
    //    $statement->execute();
    //    $view_row = $statement->rowCount();
    //
    //    for ($i = 0; $i < $view_row; $i++) {
    //      $single_result = $statement->fetch(PDO::FETCH_ASSOC);
    //      $view_column_array = array_keys($single_result);
    //      $view_value_array = array_values($single_result);
    //      $output .= "\nINSERT INTO $table[0](";
    //      $output .= "" . implode(", ", $view_column_array) . ") VALUES (";
    //      $output .= "'" . implode("','", $view_value_array) . "');\n";
    //    }
  }
  $output .= "\n--  ==== end " . $table[0] . " ====\n";
}
//print_b($output);

//$mysqlExportPath = $table[0] . date("y-m-d h:i:sa") . '.sql';
$mysqlExportPath = "backup-file" . date("y-m-d h:i:sa") . '.sql';
print_to_file($mysqlExportPath, $output);
//print_r("$mysqlExportPath     , <br>");


function column_names($connect, $table_name)
{
  $fetch_column_name = "DESCRIBE " . $table_name . "";
  $statement = $connect->prepare($fetch_column_name);
  $statement->execute();
  $table_row = $statement->rowCount();
  $column_names = [];
  $column_names_with_quote = [];
  for ($i = 0; $i < $table_row; $i++) {
    $single_result = $statement->fetch(PDO::FETCH_ASSOC);
    array_push($column_names_with_quote, "QUOTE(" . $single_result["Field"] . ")");
    array_push($column_names, $single_result["Field"]);

  }
  return ["column_names_with_quote" => $column_names_with_quote, "column_names" => $column_names];
}

function print_to_file($filename, $data)
{
  $file_handle = fopen($filename, 'w+');
  fwrite($file_handle, $data);
  fclose($file_handle);
  header('Content-Description: File Transfer');
  header('Content-Type: application/octet-stream');
  header('Content-Disposition: attachment; filename=' . basename($filename));
  header('Content-Transfer-Encoding: binary');
  header('Expires: 0');
  header('Cache-Control: must-revalidate');
  header('Pragma: public');
  header('Content-Length: ' . filesize($filename));
  // ob_clean();
  flush();
  readfile($filename);
  unlink($filename);
}

function print_a($data)
{
  echo "<pre>";
  print_r($data);
}

function print_b($data)
{
  echo "<pre>";
  print_r($data);
  die;
}