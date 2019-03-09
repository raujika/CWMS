<?php

include "sqlConnection.php";

$yesnotestId=$_GET['yesnotestId'];
$npcId=$_GET['npcId'];
$question=$_GET['question'];
$yes=$_GET['yes'];


$SQL = "INSERT INTO yesnotest VALUES('$yesnotestId','$npcId','$question','$yes');";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

header('Location: YesNoTest.php');
?>