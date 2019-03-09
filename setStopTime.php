<?php
include "sqlConnection.php";

$npcId=$_GET['npcId'];
$characterName=$_GET['characterName'];

$SQL="SELECT * FROM record WHERE npcId='$npcId' AND characterName='$characterName' AND status='start'";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
if ($rc = mysqli_fetch_assoc($rs)) {
	$questionId = $rc['questionId'];
	$isDoing=$rc['isDoing'];
	$timeCount=$rc['timeCount'];
	$lastStartTime=$rc['lastStartTime'];
}
else
{
	echo "Cannot find record";
	mysqli_close($conn);
	die();
}

if($isDoing=="0")
{
	echo "Done";
	mysqli_close($conn);
	die();
}

$strnow = date('Y-m-d H:i:s');
$now=strtotime($strnow);
$lastStartTime=strtotime($lastStartTime);
$timediff=$now-$lastStartTime;
$time=$timeCount+$timediff;

$SQL = "UPDATE record SET timeCount = $time,lastStartTime='$strnow',isDoing=0 WHERE npcId='$npcId' AND characterName='$characterName' AND status='start';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

echo "Done";

mysqli_close($conn);

?>