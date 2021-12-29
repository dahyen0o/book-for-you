<!-- 인터넷 프로그래밍 term project -->
<html>
<head>
    <style>
        @import url(Desktop.css) screen and (min-width: 992px);
        @import url(Mobile.css) screen and (max-width: 992px);
        body{ 
            background-color: #ffb266;
            color: white;
        }
        div.resultTitle{
            margin: 5% 0;
            text-align: center;
            font-weight: bold;
            font-size: 2em;
        }
        div.resultWrap{
            width: 80%;
            margin:0 auto;
            font-size: 1.5em;
        }
        div#title{
            font-size: 1.2em;
            border: white solid;
            padding: 0.4em;
            margin-bottom: 0.5em;
        }
        .box{
            float: center;
        }
        img{
            float: left;
            margin-right: 1em;
        }
    </style>
</head>
<body>
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

    $sql = "SELECT * FROM books WHERE tags LIKE '%" . $_POST['keyword'] . "%';";
    $result = $connect->query($sql);
    if($result === FALSE) die($connect->error); 

    // 결과 있음
    if($row = $result->fetch_assoc()){
        $title = $row["title"];
        $author = $row["author"];
        $price = $row["price"];
        $tags = explode(";", $row["tags"]);
        $img = $row["img"];
    }
    // 결과 없음
    else{
        $sql = "SELECT * FROM books WHERE booknum = 0;";
        $result = $connect->query($sql);
        if($result === FALSE) die($connect->error); 

        if($row = $result->fetch_assoc()){
            $title = $row["title"];
            $author = $row["author"];
            $price = $row["price"];
            $tags = explode(";", $row["tags"]);
            $img = $row["img"];
        }
        else die("no result");
    }
    ?>
    
    <div class="resultTitle">당신을 위한 책은 ...</div>
    <div class="resultWrap">
        <div id="title"><?php echo $title; ?></div>
        <div style="">
            <?php echo $img; ?> 
            <div style=""> 저자: <?php echo $author; ?> <br/> 가격: <?php echo $price; ?> </div>
        </div>  
        <div> 키워드 <?php 
        foreach($tags as $tag) {if($tag != "") echo '#' . $tag . ' ';} 
        ?> </div>
    </div>
    <div style=""><br/>* 해당 키워드로 검색한 결과가 없을 때는 가장 인기있는 책을 가져왔습니다.</div>
    <button type="button" onclick="goReturn()" style="margin-top: 0.5em; font-size: 1em;">이전</button>

    <script>
        function goReturn(){
            location.href = "../Query.html";
        }
    </script>
</body>
</html>