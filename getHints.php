<?PHP

include "sqlConnection.php";

$npcId=$_GET['npcId'];
$characterName=$_GET['characterName'];

$SQL = "SELECT * FROM record WHERE npcId  = '$npcId' AND characterName = '$characterName' AND status='start';";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));

while ($rc = mysqli_fetch_assoc($rs)) {
    $questionId = $rc['questionId'];
    $countHints = $rc['countHints'];
}

$SQL = "SELECT hints FROM hints WHERE questionId='$questionId' ORDER BY num;";
$rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
$num_rows = mysqli_num_rows($rs);
if ($countHints < $num_rows) {
    $rows = array();
    while ($rc = mysqli_fetch_assoc($rs)) {
        $rows[] = $rc['hints'];
    }
    $SQL = "UPDATE record SET countHints  = '" . ($countHints+1) . "' WHERE npcId='$npcId' AND characterName = '$characterName';";
    $rs = mysqli_query($conn, $SQL) or die(mysqli_error($conn));
    $hints= array("hints" => $rows[$countHints]);
    
    print_r(json_encode($hints));
} else {
    echo "";
}
mysqli_close($conn);
?>