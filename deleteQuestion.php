<?php

include "sqlConnection.php";


$SQL = "DELETE FROM questions WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM code WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM answer WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM currentoutput WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM expectedoutput WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM rewarditem WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM hints WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

mysqli_close($conn);

echo "Done<br><a href='quest.php'>Go back</a>";
header("location: quest.php");
?>