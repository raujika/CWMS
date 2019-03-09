<?php

include "sqlConnection.php";

$recordId=$_GET['recordId'];

$SQL = "DELETE FROM record WHERE recordId = '$recordId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
mysqli_close($conn);
header('Location: record.php');
?>