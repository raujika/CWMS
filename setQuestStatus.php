<?php


include "sqlConnection.php";

$npcId=$_GET['npcId'];
$characterName=$_GET['characterName'];
$status=$_GET['status'];

$SQL = "UPDATE record SET status='$status' WHERE npcId='$npcId' AND characterName='$characterName';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
mysqli_close($conn);

echo "Done";
?>