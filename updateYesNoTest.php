<?php

include "sqlConnection.php";

$SQL = "SELECT yesnotestId FROM yesnotest WHERE yesnotestId = ".$_GET['yesnotestId'].";";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
if (mysqli_num_rows($rs) == 0) {
    echo 'no question id';
} else {
    $SQL = "UPDATE yesnotest SET npcId  = '" . $_GET['npcId'] . "',question  = '" . $_GET['question'] . "',". "yes  = " . $_GET['yes']. " WHERE yesnotestId = ".$_GET['yesnotestId'].";";
	$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    mysqli_close($conn);
}
header('Location: YesNoTest.php');
?>