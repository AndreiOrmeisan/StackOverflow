<?php
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
Badges.Name
FROM Posts, Users, Badges
WHERE Posts.PostTypeId = 1 
    AND Users.Id = Posts.OwnerUserId
    AND Badges.Id = Users.Reputation
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
    $layout->Name = $row['Name'];
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

