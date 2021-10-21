<?php
$i = 0;
while(count($namelist)>$i){
	$lefttime =strtotime('-1 hour');
	$righttime =strtotime("now");
	$sqlcmd = "SELECT * FROM access_record WHERE locationid = '$namelist[$i]' AND accesstime BETWEEN $lefttime AND $righttime";
	$rs = querydb($sqlcmd, $db_conn);
	echo $sqlcmd;
	$data[$i]['location'] = $namelist[$i];
	$data[$i]['connect'] = count($rs);
	$data[$i]['accesstime'] = $righttime;
	$data[$i]['recorddate'] = date('Y-m-d', strtotime('+8 hours'));
	$data[$i]['recordtime'] = date('H:i:s', strtotime('+8 hours'));
	$i++;
}
?>