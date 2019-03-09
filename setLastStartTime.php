<?php
include "sqlConnection.php";

$npcId=$_GET['npcId'];
$characterName=$_GET['characterName'];

$now = date('Y-m-d H:i:s');
$SQL="UPDATE record SET lastStartTime='$now' WHERE npcId='$npcId' AND characterName='$characterName' AND status='start';";
echo $SQL;
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$rc = mysqli_fetch_assoc($rs);

echo "Done";

mysqli_close($conn);
?>