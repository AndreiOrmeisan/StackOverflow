<?php
$id = $_SERVER['QUERY_STRING'];
$serverName = "ANDREI\SQLEXPRESS";
$connectionInfo = array( "Database"=>"StackOverflow2010");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
include "infoMessage.php";

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
?>