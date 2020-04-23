<?php
$serverName = "ANDREI\SQLEXPRESS";
$connectionInfo = array( "Database"=>"StackOverflow2010");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

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
?>