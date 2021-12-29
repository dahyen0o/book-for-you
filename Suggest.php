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
if($result === FALSE) die($connect->error); 

$input = $_GET['q'];
$flag = 0;

while($row = $result->fetch_assoc()){
    $tags = explode(";", $row["tags_arr"]);
    foreach($tags as $tag){
        if(strpos($tag, $input) !== false){
            echo $tag; $flag = 1; break;
        }
    }

}
if($flag == 0) echo "일치하는 키워드가 없습니다";

$connect->close();

?>