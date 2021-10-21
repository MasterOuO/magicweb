<?php
header('Content-type: text/html; charset=utf-8');
require_once("include/gpsvars.php");
require ("include/configure2.php");
require ("include/db_func.php");
session_start();
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

if (!isset($ID)) $ID = "";
$retcode = 0;
$ID = $_SESSION['LoginID'];
$sqlcmd = "SELECT * FROM user WHERE loginid='$ID' AND valid='Y'";
$rs = querydb($sqlcmd, $db_conn);
if (count($rs) > 0) {
	$retcode = 1;		
}

?>