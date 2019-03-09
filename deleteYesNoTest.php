<?php

include "sqlConnection.php";

$yesnotestId=$_GET['yesnotestId'];

$SQL = "DELETE FROM yesnotest WHERE yesnotestId = '$yesnotestId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
mysqli_close($conn);
header('Location: YesNoTest.php');
?>