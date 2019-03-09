<?php

include "sqlConnection.php";

$npcId = $_GET['npcId'];
$characterName = $_GET['characterName'];
$questType = $_GET['questType'];

$SQL = "SELECT * FROM record WHERE npcId='$npcId' AND characterName = '$characterName' AND status = 'start';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
if (mysqli_num_rows($rs) == 0) {//get new quest
	//get random quest and its reward
	$SQL = "SELECT * FROM questions q LEFT JOIN record r ON q.questionId=r.questionId WHERE r.questionId IS NULL AND q.type='$questType' AND q.npcId='$npcId' ORDER BY RAND() LIMIT 1;";
	$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
	if(mysqli_num_rows($rs)==0)
	{
		echo "";
		die();
	}
    if($rc = mysqli_fetch_array($rs)) {
        $questionId = $rc[0];
		$reward = array("experience" => $rc['experience'],"karma" => $rc['karma'],"money" => $rc['money']);
    }
	$reward=array("reward"=>$reward);
	
	//add record
    $now = date('Y-m-d H:i:s');
    $SQL = "INSERT INTO record VALUES (NULL,'$characterName','$npcId','$questionId','start',0,'$now',1,0);";
    $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

}else{//get previous quest
	//get question id and record info
	while ($rc = mysqli_fetch_assoc($rs)) {
		$questionId = $rc['questionId'];
		$isDoing = $rc['isDoing'];
	}
	//get reward
	$SQL = "SELECT * FROM questions WHERE questionId='$questionId';";
	$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
	while ($rc = mysqli_fetch_assoc($rs)) {
		$reward = array("experience" => $rc['experience'],"karma" => $rc['karma'],"money" => $rc['money']);
	}
	$reward=array("reward"=>$reward);
	
	//update record
	if($isDoing==0)
	{
		$now = date('Y-m-d H:i:s');
		$SQL = "UPDATE record SET isDoing=1,lastStartTime='$now' WHERE questionId='$questionId' AND status='start';";
		$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
	}
	
}

$SQL = "SELECT * FROM code WHERE questionId = " . $questionId . " ORDER BY row;";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$rows = array();
while ($rc = mysqli_fetch_assoc($rs)) {
	$rows[] = $rc['code'];
}
$code = array("code" => $rows);

$SQL = "SELECT * FROM answer WHERE questionId = " . $questionId . " ORDER BY row;";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$rows = array();
while ($rc = mysqli_fetch_assoc($rs)) {
	$rows[] = $rc['answer'];
}
$answer = array("answer" => $rows);

$SQL = "SELECT * FROM currentoutput WHERE questionId = " . $questionId . " ORDER BY row;";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$rows = array();
while ($rc = mysqli_fetch_assoc($rs)) {
	$rows[] = $rc['output'];
}
$currentOutput = array("curout" => $rows);

$SQL = "SELECT * FROM expectedoutput WHERE questionId = " . $questionId . " ORDER BY row;";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$rows = array();
while ($rc = mysqli_fetch_assoc($rs)) {
	$rows[] = $rc['output'];
}
$expectOutput = array("expout" => $rows);

$SQL = "SELECT * FROM rewarditem WHERE questionId = " . $questionId;
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$rows = array();
while ($rc = mysqli_fetch_assoc($rs)) {
	$rows[] = array("itemname"=>$rc['itemName'],"qty"=>$rc['itemCount']);
}
$reward["reward"]["item"]=$rows;

//output
$result = array_merge($code, $answer, $expectOutput, $currentOutput, $reward);
print_r(json_encode($result));

mysqli_close($conn);
?>