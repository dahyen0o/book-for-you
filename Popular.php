<!-- 인터넷 프로그래밍 term project -->

<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$hostname = "localhost";
$username = "cse20151537";
$password = "cse20151537";
$dbname = "db_cse20151537";

$connect = new mysqli($hostname, $username, $password, $dbname) or die("DB Connection Failed");

if($connect);
else die("MySQL Server Connect Failed!<br>");

$sql = "SELECT GROUP_CONCAT(tags SEPARATOR '') as tags_arr FROM books";
$result = $connect->query($sql);
if($result === FALSE) echo $connect->error;

while($row = $result->fetch_assoc()){
    $tags = explode(";", $row["tags_arr"]);
    echo '<script>console.log($row["tags_arr"])</script>';
    $tags_arr = array_count_values($tags); 
    arsort($tags_arr); // key: tag, value: tag count
    break;
}

$connect->close();

$tags_keys = array_keys($tags_arr);
echo "#" . $tags_keys[0] . " #" . $tags_keys[1] . " #" . $tags_keys[2];
?>

