<?PHP
include "sqlConnection.php";

$npcId=$_GET['npcId'];

$SQL = "SELECT * FROM yesnotest WHERE npcId='$npcId'";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$rows = array();
while ($rc = mysqli_fetch_assoc($rs)) {
	$rows[] = array("question"=>$rc['question'],"yes"=>$rc['yes']);
}
print_r(json_encode($rows));

mysqli_close($conn);
?>