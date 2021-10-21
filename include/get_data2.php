<?php
session_start();
require_once("include/configure.php");
require_once("include/db_func.php");
$db_conn = connect2db( $dbhost, $dbuser, $dbpwd, $dbname);

$data = array();
$data2 = array();
$i = 0;
$lefttime = strtotime($_SESSION['time']);
$righttime = strtotime("now");

$c = 0;
while(count($namelist)>$i){
	$total = 0;
	$data[$i]['location'] = $namelist[$i];
	$data[$i]['total'] = 0;
	$building = $namelist[$i];
	$j = 0;
    while($j<count($idAdress[$building])){
		$data2[$c]['location'] = $idAdress[$building][$j];
		$data2[$c]['location'] = $idAdress[$building][$j];
		$locationid = $idAdress[$building][$j];
		$sqlcmd = "SELECT * FROM access_record WHERE locationid = '$locationid' AND accesstime BETWEEN $lefttime AND $righttime";
		echo $sqlcmd;
		$rs = querydb($sqlcmd, $db_conn);
		$data2[$c]['connect'] = count($rs);
		$data[$i]['total'] += $data2[$c]['connect'];
		$c++;
		$j++;
    }
    $i++;
}

?>