<?php
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
?>
<style type="text/css">
		body {
			background-color:black;
			background-image: url("zz.gif");;
			background-size: 100%;
			background-repeat: no-repeat;
		}
		#a2{
			font-family: 宋體;
			font-size: 20px;
			color: white;
			text-decoration: underline;
		}
</style>
<html>

<title>排行榜</title>
<br>
<center>
<h2><font color="white">排行榜</font></h2><br>
<body>
<table width="600" border="1" cellspacing="1" cellpadding="0" align="center">
<?php
	
	echo '<tr>';
	echo "<td width='20%'><center><font color='white'>排名</font></td>";
	echo "<td width='20%'><center><font color='white'>id</font></td>";
	echo "<td width='30%'><center><font color='white'>名字</font></td>";
	echo "<td width='30%'><center><font color='white'>分數</font></td>";
	echo '</tr>';
	/*for($i=1;$i<=10;$i++){
		$sqlcmd="SELECT * FROM `game_leaderboard` ORDER BY `rank` ASC";
		$rs = querydb($sqlcmd,$db_conn);
		echo '<tr>';
		echo '<td><center>'.$rs[0]['rank'].'</td>';
		echo '<td><center>'.$rs[0]['id'].'</td>';
		$id = $rs[0]['id'];
		$sqlcmd="SELECT * FROM game_user WHERE id='$id'";
		$rsa = querydb($sqlcmd,$db_conn);
		$sqlcmd="SELECT * FROM game_characters WHERE id='$id'";
		$rsb = querydb($sqlcmd,$db_conn);
		
		$name = $rsb[0]['name'];
		$score = $rsb[0]['highestscore'];
		echo '<td><center>'.$name.'</td>';
		echo '<td><center>'.$score.'</td>';
		echo '</tr>';
	}*/
	$sqlcmd="SELECT * FROM `game_leaderboard` ORDER BY `rank` ASC";
	$rs = querydb($sqlcmd,$db_conn);
	foreach($rs AS $item){
		echo '<tr>';
		echo '<td><center><font color="white">'.$item['rank'].'</font></td>';
		echo '<td><center><font color="white">'.$item['id'].'</font></td>';
		$id = $item['id'];
		
		$sqlcmd="SELECT * FROM game_user WHERE id='$id'";
		$rsa = querydb($sqlcmd,$db_conn);
		$sqlcmd="SELECT * FROM game_characters WHERE id='$id'";
		$rsb = querydb($sqlcmd,$db_conn);
		
		$name = $rsb[0]['name'];
		$score = $rsb[0]['highestscore'];
		echo '<td><center><font color="white">'.$name.'</font></td>';
		echo '<td><center><font color="white">'.$score.'</font></td>';
		echo '</tr>';
	}
?>
</table>
<a id="a2" href="index.php">回主介面</a>
</center>
</body>
</html>