<?php

include "sqlConnection.php";
$recordId=$_GET['recordId'];
$questionId=$_GET['questionId'];
$characterName=$_GET['characterName'];
$npcId=$_GET['npcId'];
$status=$_GET['status'];
$countHints=$_GET['countHints'];
$lastStartTime=$_GET['lastStartTime'];
$timeCount=$_GET['timeCount'];

$SQL = "INSERT INTO record VALUES('$recordId','$characterName','$npcId','$questionId','$status','$countHints','$lastStartTime',0,'$timeCount');";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

header('Location: record.php');
?>