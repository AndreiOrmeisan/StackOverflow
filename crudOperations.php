<?php
$id = $_SERVER['QUERY_STRING'];
$serverName = "ANDREI\SQLEXPRESS";
$connectionInfo = array( "Database"=>"StackOverflow2010");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
$method = $_SERVER['REQUEST_METHOD'];
include "infoMessage.php";

if($method == "GET"){
$query = $_SERVER['QUERY_STRING'];
GLOBAL $page;
GLOBAL $count;
$count = intval(explode('/',$query)[3]);
$page = (intval(explode('/',$query)[1])-1) * $count;

$sqlPost = "SELECT
Posts.Title,
Posts.Body,
Posts.Tags,
Posts.ViewCount,
Posts.AnswerCount,
Posts.Score,
Posts.CreationDate,
Posts.PostTypeId,
Posts.Tags,
Posts.CreationDate,
Users.DisplayName,
Posts.Id
FROM Posts, Users
WHERE Posts.OwnerUserId = Users.Id
    AND Posts.PostTypeId = 1 
ORDER BY Posts.CreationDate DESC
OFFSET $page ROWS
FETCH NEXT $count ROWS ONLY";

$stmt = sqlsrv_query( $conn, $sqlPost);
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$posts= array();
Global $index;
$index = 0;
include "post.php";

while($row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC)) {
    $layout = new post();
    $layout->Title = $row['Title'];
    $layout->DisplayName = $row['DisplayName'];
    $layout->CreationDate = $row['CreationDate'];
    $layout->Tags = $row['Tags'];
    $layout->ViewCount = $row['ViewCount'];
    $layout->AnswerCount = $row['AnswerCount'];
    $layout->Score = $row['Score'];
    $layout->PostTypeId = $row['PostTypeId'];
    $layout->Body = $row['Body'];
    $layout->Id = $row['Id'];
    
    $posts[$index]= $layout;
    $index++;
}

header("Content-Type: application/json");
echo json_encode($posts);
}

if ($method == "POST"){
    $json_str = file_get_contents('php://input');
    $json = json_decode($json_str, true);
if ($json['title'] != "" && $json['body'] != "" && $json['tags'] !=""){

    $title = $json['title'];
    $body = $json['body'];
    $tags = $json['tag'];
    $succesMessage = new InfoMessage();
    $succesMessage->Status=200;
    $succesMessage->Message="Succes";
    $sql = "INSERT INTO posts 
    (CreationDate,Body, Title, ViewCount, PostTypeId, LastActivityDate, Score, OwnerUserId, Tags, AnswerCount) 
    VALUES (GETDATE(),'<p>$body</p>','$title','0','1',GETDATE(),'0', '10251168','$tags', '0');";
    sqlsrv_query($conn,$sql);
    header("Content-Type: application/json");
    echo json_encode($succesMessage);
}
else{
    $failMessage = new InfoMessage();
    $failMessage->Status=400;
    $failMessage->Message="All fields is required";
    header("Content-Type: application/json");
    echo json_encode($failMessage);
}  
}

if ($method == "DELETE"){
    if ($id != ""){
        $succesMessage = new InfoMessage();
        $succesMessage->Status=200;
        $succesMessage->Message="Succes";
        $sql = "DELETE FROM Posts WHERE Posts.id = $id";
        sqlsrv_query($conn,$sql);
        header("Content-Type: application/json");
        echo json_encode($succesMessage);
    }
    else{
        $failMessage = new InfoMessage();
        $failMessage->Status=400;
        $failMessage->Message="All fields is required";
        header("Content-Type: application/json");
        echo json_encode($failMessage);
    } 
}

if ($method =="PUT"){
    $json_str = file_get_contents('php://input');
$json = json_decode($json_str, true);

$title = strval($json['title']);
$body = strval($json['body']);
$tags = strval($json['tags']);
$id = intval($json['id']);

$sql = "UPDATE posts
SET Title = '$title',
Body = '<p>$body<p>',
Tags = '$tags'
WHERE posts.id = $id";

sqlsrv_query($conn,$sql);
}
?>