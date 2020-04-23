<?php
$sqlCount = "SELECT COUNT(Posts.Id) FROM Posts WHERE PostTypeId = 1";

$stmtCount = sqlsrv_query( $conn, $sqlCount);
if( $stmstCount === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$count = sqlsrv_fetch_array( $stmtCount, SQLSRV_FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode(utf8_decode($count));
?>