<?php
header("Content-type:text/html;charset=utf-8"); //字符编码设置
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
$conn = mysqli_connect("localhost", "root", "root", "fyp", "3307") or die(mysqli_connect_error());
function query($sql)
{
    $rs = mysqli_query($GLOBALS['conn'], $sql) or die(mysqli_error($GLOBALS['conn']));

    return $rs;
}
?>