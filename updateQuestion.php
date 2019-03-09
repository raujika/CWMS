<?php


include "sqlConnection.php";

$questionId=$_POST['questionId'];

$SQL = "DELETE FROM questions WHERE questionId = '$questionId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM code WHERE questionId = '$questionId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM answer WHERE questionId = '$questionId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM currentoutput WHERE questionId = '$questionId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM expectedoutput WHERE questionId = '$questionId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM rewarditem WHERE questionId = '$questionId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$SQL = "DELETE FROM hints WHERE questionId = '$questionId';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

	//echo "<pre>"; var_dump($_POST); echo "</pre>";
    $QuestionCode = $_POST['QuestionCode'];
    $answer = $_POST['answer'];
    $type = $_POST['questionType'];
	$npcId = $_POST['npcid'];
	$rating=$_POST['rating'];
    $currentOutput = $_POST['currentOutput'];
    $expectOutput = $_POST['expectOutput'];
	$item = $_POST['item'];
    $hints = $_POST['hints'];
	$questionId=$_POST['questionId'];
	
	$codeArr = strlen($QuestionCode)==0?array():preg_split('/[\n\r]+/', $QuestionCode);
    $answerArr = strlen($answer)==0?array():preg_split('/[\n\r]+/', $answer);
	$curOutArr = strlen($currentOutput)==0?array():preg_split('/[\n\r]+/', $currentOutput);
	$expOutArr = strlen($expectOutput)==0?array():preg_split('/[\n\r]+/', $expectOutput);
	$itemArr = strlen($item)==0?array():preg_split('/[\n\r]+/', $item);
    $hintsArr = strlen($hints)==0?array():preg_split('/[\n\r]+/', $hints);
	
	$exp=$_POST['experience'];
	$karma=$_POST['karma'];
	$money=$_POST['money'];
	
	
	//checking
	if($type!="Tracing program" && count($codeArr)!=count($answerArr))
	{
		echo "Line count of code and answer must be matched";
		mysqli_close($conn);
		die();
	}
	if(strlen($QuestionCode)==0)
	{
		echo "Please input valid code";
		mysqli_close($conn);
		die();
	}
	if(strlen($answer)==0)
	{
		echo "Please input valid answer";
		mysqli_close($conn);
		die();
	}
	if($type!="Reorder" && strlen($currentOutput)==0)
	{
		echo "Please input valid current output";
		mysqli_close($conn);
		die();
	}
	if($type!="Reorder" && $type!="Tracing program" && strlen($expectOutput)==0)
	{
		echo "Please input valid expected output";
		mysqli_close($conn);
		die();
	}
	for($i=0;$i<count(itemArr);$i++)
	{
		if(count(preg_split('/,/', $itemArr[$i]))!=2)
		{
			echo "Please input valid item reward";
			mysqli_close($conn);
			die();
		}
	}

	//start insert data
    $SQL = "INSERT INTO questions VALUES ('$questionId','$npcId','$type','$rating','$exp','$karma','$money');";
    $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

    for ($i = 0; $i < count($codeArr); $i++) {
        $SQL = "INSERT INTO code VALUES ('$questionId','$i','$codeArr[$i]');";
        $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    }
    for ($i = 0; $i < count($answerArr); $i++) {
        $SQL = "INSERT INTO answer VALUES ('$questionId','$i','$answerArr[$i]');";
        $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    }
	for ($i = 0; $i < count($curOutArr); $i++) {
        $SQL = "INSERT INTO currentoutput VALUES ('$questionId','$i','$curOutArr[$i]');";
        $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    }
	for ($i = 0; $i < count($expOutArr); $i++) {
        $SQL = "INSERT INTO expectedoutput VALUES ('$questionId','$i','$expOutArr[$i]');";
        $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    }
	for ($i = 0; $i < count($itemArr); $i++) {
		$itemRow = preg_split('/,/', $itemArr[$i]);
        $SQL = "INSERT INTO rewarditem VALUES ('$questionId','$itemRow[0]','$itemRow[1]');";
        $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    }
    for ($i = 0; $i < count($hintsArr); $i++) {
        $SQL = "INSERT INTO hints VALUES ('$questionId',$i,'$hintsArr[$i]');";
        $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    }
    
    mysqli_close($conn);
	
	echo "Done<br><a href='quest.php'>Go back</a>";

?>