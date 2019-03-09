<?php

include "sqlConnection.php";

$SQL = "SELECT questionId FROM record WHERE questionId = ".$_GET['questionId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
if (mysqli_num_rows($rs) == 0) {
    echo 'no question id';
} else {
    $SQL = "UPDATE record SET questionId  = '" . $_GET['questionId'] . "',characterName = '" . $_GET['characterName'] . "',npcId = '" . $_GET['npcId'] . "',". "status = '" . $_GET['status'] . "',countHints = '" . $_GET['countHints']. "',lastStartTime = '" . $_GET['lastStartTime']."',timeCount = " . $_GET['timeCount']. " WHERE recordId = " . $_GET['recordId'] . ";";
	$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    mysqli_close($conn);
}
header('Location: record.php');
?>