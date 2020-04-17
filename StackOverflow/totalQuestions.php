<?php
$sqlCount = "SELECT COUNT(Posts.Id) FROM Posts WHERE PostTypeId = 1";

$stmtCount = sqlsrv_query( $conn, $sqlCount);
if( $stmstCount === false) {
    die( print_r( sqlsrv_errors(), true) );
}

$count = sqlsrv_fetch_array( $stmtCount, SQLSRV_FETCH_ASSOC);
echo "<strong>Total Questions: </strong>";
print_r(array_values($count)[0]);
echo "<br/>";
?>