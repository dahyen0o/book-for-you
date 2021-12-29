<!-- 인터넷 프로그래밍 term project -->
<html>
<body onload="location.replace('../Query.html')">

<?php
include('simplehtmldom_1_9_1/simple_html_dom.php');
include 'simple_html_dom.php';

$image = array();
$title = array();
$author = array();
$price = array();
$tag = array();
$i = 0;

// page 1
for($n = 1;$n <= 3;$n += 1){
	$url = "https://www.aladin.co.kr/shop/common/wbest.aspx?BestType=Bestseller&BranchType=1&CID=0&page=" . $n . "&cnt=1000&SortOrder=1";
	$html = file_get_html($url);

	$bestlist = $html->find('div[id=newbg_wrap2]', 0)->find('table tr td', 0)->find('div[id=newbg_body]', 0)
				->find('form[id=Myform]', 0);
	foreach($bestlist->find('div.ss_book_box') as $book){
		$temp = $book->find('table tr', 0)->find('div.ss_book_list', 0)->find('a.bo3', 0);
		$title[$i] = $temp->plaintext;
		$author[$i] = $temp->parent()->next_sibling()->find('a', 0)->plaintext;
		$price[$i] = $temp->parent()->next_sibling()->next_sibling()->find('span', 0)->plaintext;
		$image[$i] = $book->find('img.i_cover', 0);
		$tag[$i] = "";

		$html_ = file_get_html($temp->href);
		foreach($html_->find('ul[id=ulCategory]', 0)->find('li') as $tags){
			//echo $tags->last_child()->prev_sibling()->plaintext . "<br/>";
			$tag[$i] = $tag[$i] . $tags->last_child()->prev_sibling()->plaintext . ";";
			for($t = $tags->last_child()->prev_sibling()->prev_sibling();$t;$t = $t->prev_sibling()){
				if(strpos($tag[$i], $t->plaintext) === false)
					$tag[$i] = $tag[$i] . $t->plaintext . ";";
			}
		}
		//echo $tag[$i] . "<br/>";
		
		$i += 1;
	}
}

error_reporting(E_ALL);
ini_set("display_errors", 1);

$hostname = "localhost";
$username = "cse20151537"; //20151537
$password = "cse20151537";
$dbname = "db_cse20151537";

$connect = new mysqli($hostname, $username, $password, $dbname) or die("DB Connection Failed");

if($connect === false) die("MySQL Server Connect Failed!<br>");

$sql = "DROP TABLE books;";
if($connect->query($sql) === false) die(mysqli_error($connect)); 

$sql = "CREATE TABLE books (
		booknum INT(3) NOT NULL PRIMARY KEY,
		title VARCHAR(200) NOT NULL,
		author VARCHAR(100) NOT NULL,
		price VARCHAR(20) NOT NULL,
		tags VARCHAR(300) NOT NULL,
		img VARCHAR(200) NOT NULL
		);";

if($connect->query($sql) === false) die(mysqli_error($connect)); 

for($j = 0;$j < $i;$j += 1){
	//echo $title[$j] . "<br/>";
	$sql = "INSERT INTO books (booknum, title, author, price, tags, img)
	VALUES ($j, '$title[$j]', '$author[$j]', '$price[$j]', '$tag[$j]', '$image[$j]')";

	if ($connect->query($sql) === FALSE) {
		die(mysqli_error($connect));
	}
}

$connect->close();

?>

<!-- <div onload="location.replace('http:/cspro.sogang.ac.kr/~cse20191657/Query.html')"/> -->

</body>
</html>


