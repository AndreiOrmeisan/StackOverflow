<?php
$serverName = "ANDREI\SQLEXPRESS";
$connectionInfo = array( "Database"=>"StackOverflow2010");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

include "query.php";

sqlsrv_free_stmt( $stmt);
?>