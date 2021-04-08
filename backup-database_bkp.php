
<?php

//$servername = "sddb0040315208.cgidb";
//$username = "sddbMTcyMDgz";
//$password = 'NOyt$X9s';
//$dbname = "sddb0040315208";

//$servername = "172.16.238.10";
//$username = "wwwaap";
//$password = 'Wwwaap@123';
//$dbname = "wwwaap";
//
//// Create connection
//$conn = mysqli_connect($servername, $username, $password, $dbname);
//// Check connection
//if (!$conn) {
//    die("Connection failed: " . mysqli_connect_error());
//}
//echo "Connected Successfully.<br/><br/>";
?>

<?php
// start process 1

//$DB_HOST = "172.16.238.10";
//$DB_USER = "wwwaap";
//$DB_PASS = 'Wwwaap@123';
//$DB_NAME = "wwwaap";
//$con = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
//if($con->connect_errno > 0) {
//    die('Connection failed [' . $con->connect_error . ']');
//}
//
//$tableName  = 'yourtable';
//$backupFile = 'backup/yourtable.sql';
//$query      = "SELECT * INTO OUTFILE '$backupFile' FROM $tableName";
//$result = mysqli_query($con,$query);

// end process 2

?>

<?php
//// start method 2
////ENTER THE RELEVANT INFO BELOW

$mysqlHostName = "172.16.238.10";
$mysqlUserName = "wwwaap";
$mysqlPassword = 'Wwwaap@123';
$DbName = "wwwaap";
$backup_name = "mybackup.sql";

//$mysqlUserName      = "Your Username";
//$mysqlPassword      = "Your Password";
//$mysqlHostName      = "Your Host";
//$DbName             = "Your Database Name here";
//$backup_name        = "mybackup.sql";
//$tables             = "Your tables";

////or add 5th parameter(array) of specific tables:    array("mytable1","mytable2","mytable3") for multiple tables

//export_database($mysqlHostName, $mysqlUserName, $mysqlPassword, $DbName, $tables = false, $backup_name = false);
//
//function export_database($host, $user, $pass, $name, $tables = false, $backup_name = false)
//{
//    $mysqli = new mysqli($host, $user, $pass, $name);
//    $mysqli->select_db($name);
//    $mysqli->query("SET NAMES 'utf8'");
//
//    $queryTables = $mysqli->query('SHOW TABLES');
//
//    while ($row = $queryTables->fetch_row()) {
//        $target_tables[] = $row[0];
//    }
//
//    if ($tables !== false) {
//        $target_tables = array_intersect($target_tables, $tables);
//    }
////    print_b($target_tables);
//    foreach ($target_tables as $table) {
//        $result = $mysqli->query('SELECT * FROM ' . $table);
//        $fields_amount = $result->field_count;
//        $rows_num = $mysqli->affected_rows;
//        $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
//        $TableMLine = $res->fetch_row();
//        $content = (!isset($content) ? '' : $content) . "\n\n" . $TableMLine[1] . ";\n\n";
//
//        for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {
//            while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
//                if ($st_counter % 100 == 0 || $st_counter == 0) {
//                    $content .= "\nINSERT INTO " . $table . " VALUES";
//                }
//                $content .= "\n(";
//                for ($j = 0; $j < $fields_amount; $j++) {
//                    $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
//                    if (isset($row[$j])) {
//                        $content .= '"' . $row[$j] . '"';
//                    } else {
//                        $content .= '""';
//                    }
//                    if ($j < ($fields_amount - 1)) {
//                        $content .= ',';
//                    }
//                }
//                $content .= ")";
//                //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
//                if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
//                    $content .= ";";
//                } else {
//                    $content .= ",";
//                }
//                $st_counter = $st_counter + 1;
//            }
//        }
//        $content .= "\n\n\n";
//    }
//    //$backup_name = $backup_name ? $backup_name : $name."___(".date('H-i-s')."_".date('d-m-Y').")__rand".rand(1,11111111).".sql";
//    $backup_name = $backup_name ? $backup_name : $name . ".sql";
//    header('Content-Type: application/octet-stream');
//    header("Content-Transfer-Encoding: Binary");
//    header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
////    echo $content;
////    exit;
//    print_b($content);
//}


function print_b($data)
{
    echo "<pre>";
    print_r($data);
    die;
}

// end method 2
?>

<?php

////ENTER THE RELEVANT INFO BELOW
//$mysqlHostName = "172.16.238.10";
//$mysqlUserName = "wwwaap";
//$mysqlPassword = 'Wwwaap@123';
//$mysqlDatabaseName = "wwwaap";
//$mysqlExportPath = 'chooseFilenameForBackup.sql';
//
////DO NOT EDIT BELOW THIS LINE
////Export the database and output the status to the page
//$command = 'mysqldump -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $mysqlDatabaseName . ' > ' . $mysqlExportPath;
//$result = exec($command);
//print_r($result);
//echo "Done is here"

?>

<?php


$host = "172.16.238.10";
$user = "wwwaap";
$mysqlPassword = 'Wwwaap@123';
$pw = "wwwaap";
$dsn = "mysql:host=$host;dbname=$dbname";

$connect = new PDO($dsn, $user, $pw);
$get_all_table_query = "SHOW TABLES";
$statement = $connect->prepare($get_all_table_query);
$statement->execute();
$result = $statement->fetchAll();

if(isset($_GET['table'])) {

    $output = '';
    foreach($_GET['table'] as $table) {

        $show_table_query = "SHOW CREATE TABLE ".$table. "";
        $statement = $connect->prepare($show_table_query);
        $statement->execute();
        $show_table_result = $statement->fetchAll();

        foreach ($show_table_result as $show_table_row) {
            $output .= "\n\n".$show_table_row["Create Table"]. ";\n\n";
        }
        $select_query =  "SELECT * FROM ".$table."";
        $statement = $connect->prepare($select_query);
        $statement->execute();
        $table_row = $statement->rowCount();

        for ($i=0; $i<$table_row; $i++) {
            $single_result = $statement->fetch(PDO::FETCH_ASSOC);
            $table_column_array = array_keys($single_result);
            $table_value_array = array_values($single_result);
            $output .= "\nINSERT INTO $table(";
            $output .= "".implode(", ", $table_column_array).") VALUES (";
            $output .= "'".implode("','", $table_value_array)."');\n";
        }

    }

    $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
    $file_handle = fopen($file_name, 'w+');
    fwrite($file_handle, $output);
    fclose($file_handle);
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file_name));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file_name));
    ob_clean();
    flush();
    readfile($file_name);
    unlink($file_name);

}




////$mysqlHostName = "172.16.238.10";
//$mysqlHostName = "localhost";
//
//$mysqlUserName = "wwwaap";
//$mysqlPassword = 'Wwwaap@123';
//$mysqlDatabaseName = "wwwaap";
//$mysqlExportPath = 'chooseFilenameForBackup' . date("y-m-d h:i:sa") . '.sql';
////print_b($mysqlExportPath);
////DO NOT EDIT BELOW THIS LINE
////Export the database and output the status to the page
//$command = 'mysqldump -h' . $mysqlHostName . ' -u' . $mysqlUserName . ' -p' . $mysqlPassword . ' ' . $mysqlDatabaseName . ' > ' . $mysqlExportPath;
//$result = exec($command, $output);
//print_r($output);
//print_b($result);
//echo "Done is here";


//$output = null;
//$retval = null;
//$result = exec('whoami', $output, $retval);
//echo "Returned with status $retval and output:\n";
//print_r($output);
//print_b($result);
//die;
//
//$host = "172.16.238.10";
//$user = "wwwaap";
//$pw = 'Wwwaap@123';
//$dbname = "wwwaap";
//$dsn = "mysql:host=$host;dbname=$dbname";
//
////testign dump comand
//$cmd = "mysqldump -h $host -u $user --password=$pwd | gzip --best";
//
//passthru($cmd);