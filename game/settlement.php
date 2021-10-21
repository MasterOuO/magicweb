<?php
session_start();
if(!isset($_GET['value'])) $score2 = 0;
else $score2 = $_GET['value'];
$account=$_SESSION['gameaccount'];
$udscore = $score2;
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$sqlcmd="UPDATE game_user SET score= 0  WHERE account='$account'";
$result = updatedb($sqlcmd, $db_conn);



?>
<?php
	
	
	$sqlcmd="SELECT * FROM game_user WHERE account='$account'";
	$rs = querydb($sqlcmd,$db_conn);
	$name=$rs[0]['name'];
	$id=$rs[0]['id'];
	$sqlcmd="SELECT * FROM game_characters WHERE id='$id'";
	$rs1 = querydb($sqlcmd,$db_conn);
	$first=$rs1[0]['first'];
	$score=$rs1[0]['highestscore'];
	
	if (!isset($udscore)) $udscore = 0;
		if($udscore>$score){
			$sqlcmd="UPDATE game_characters SET highestscore='$udscore' WHERE id='$id'";
			$result = updatedb($sqlcmd,$db_conn);
		}
		//排名更換
		if($first=='Y'){
			//本人名次
			$sqlcmd="SELECT * FROM game_leaderboard WHERE id='$id'";
			$ru = querydb($sqlcmd,$db_conn);
			$rank = $ru[0]['rank'];
			//echo '<br>本人幾名:'.$rank;
			//尋找比誰高分
			$sqlcmd="SELECT * FROM game_leaderboard ORDER BY `rank` ASC";
			$rs = querydb($sqlcmd,$db_conn);
			foreach($rs AS $item){
				$rrank=$item['rank'];
				$rid=$item['id'];
				//沒比誰高分
				//echo '<br>'.$id.$rid;
				if($id==$rid) break;
				$sqlcmd="SELECT * FROM game_characters WHERE id='$rid'";
				$ru = querydb($sqlcmd,$db_conn);
				$rscore=$ru[0]['highestscore'];
				//遇到同分的人
				if($udscore==$rscore){
					//echo "<br>".$rrank.$rank;
					//名次往後
					/*for($i=$rrank+1;$i<=$rank;$i++){
						//$nrank=$i+1;
						$sqlcmd="UPDATE game_leaderboard SET rank='$i'+1 WHERE rank='$i'";
						$result = updatedb($sqlcmd,$db_conn);
					}*/
					for($i=$rank;$i>$rrank;$i--){
						$nrank=$i+1;
						//echo "<br>for:<br>".$i.$nrank;
						$sqlcmd="UPDATE game_leaderboard SET rank='$nrank' WHERE rank='$i'";
						$result = updatedb($sqlcmd,$db_conn);
					}
					$sqlcmd="UPDATE game_leaderboard SET rank='$rrank' WHERE id='$id'";
					$result = updatedb($sqlcmd,$db_conn);
					break;
				}
				//遇到比較低分的人
				if($udscore>$rscore){
					//echo "<br>分數<br>".$udscore."<br>".$rscore;
					//echo "<br>".$rrank;
					//名次往後
					/*for($i=$rrank;$i<$rank;$i++){
						$nrank=$i+1;
						//echo "<br>for:<br>".$i.$nrank;
						$sqlcmd="UPDATE game_leaderboard SET rank='$nrank' WHERE rank='$i'";
						$result = updatedb($sqlcmd,$db_conn);
					}*/
					for($i=$rank;$i>=$rrank;$i--){
						$nrank=$i+1;
						//echo "<br>for:<br>".$i.$nrank;
						$sqlcmd="UPDATE game_leaderboard SET rank='$nrank' WHERE rank='$i'";
						$result = updatedb($sqlcmd,$db_conn);
					}
					$sqlcmd="UPDATE game_leaderboard SET rank='$rrank' WHERE id='$id'";
					$result = updatedb($sqlcmd,$db_conn);
					break;
				}
				
			}
		}
		else{
			
			$sqlcmd="SELECT MAX(rank) FROM game_leaderboard";
			$rs = querydb($sqlcmd,$db_conn);
			$lowrank=$rs[0]['MAX(rank)'];
			//第十名id 分數
			$sqlcmd="SELECT * FROM game_leaderboard WHERE rank='$lowrank'";
			$rs = querydb($sqlcmd,$db_conn);
			$rscount=count($rs)-1;
			$lowid=$rs[$rscount]['id'];
			//echo '<br>總數:'.$rscount.'最後一人:'.$lowid;
			$sqlcmd="SELECT * FROM game_characters WHERE id='$lowid'";
			$rsa = querydb($sqlcmd,$db_conn);
			$lowscore=$rsa[0]['highestscore'];
			//大於第十名
			//echo '最大名次'.$lowrank;
			if($udscore>$lowscore){
				//第十名退出排行榜
				//沒前十
				$sqlcmd="UPDATE game_characters SET first='N' WHERE id='$lowid'";
				$result = updatedb($sqlcmd,$db_conn);
				//刪除排行榜
				$sqlcmd="DELETE FROM game_leaderboard WHERE id='$lowid'";
				$result = updatedb($sqlcmd,$db_conn);
				//尋找比誰高分
				$sqlcmd="SELECT * FROM game_leaderboard ORDER BY `rank` ASC";
				$rs = querydb($sqlcmd,$db_conn);
				foreach($rs AS $item){
					$rrank=$item['rank'];
					$rid=$item['id'];
					//沒比誰高分
					//echo '<br>'.$id.$rid;
					if($id==$rid) break;
					$sqlcmd="SELECT * FROM game_characters WHERE id='$rid'";
					$ru = querydb($sqlcmd,$db_conn);
					$rscore=$ru[0]['highestscore'];
					//遇到同分的人
					if($udscore==$rscore){
						//echo "<br>".$rrank.$rank;
						//名次往後
						/*for($i=$rrank+1;$i<=$rank;$i++){
							//$nrank=$i+1;
							$sqlcmd="UPDATE game_leaderboard SET rank='$i'+1 WHERE rank='$i'";
							$result = updatedb($sqlcmd,$db_conn);
						}*/
						for($i=$lowrank;$i>$rrank;$i--){
							$nrank=$i+1;
							//echo "<br>for:<br>".$i.$nrank;
							$sqlcmd="UPDATE game_leaderboard SET rank='$nrank' WHERE rank='$i'";
							$result = updatedb($sqlcmd,$db_conn);
						}
						$sqlcmd="INSERT INTO game_leaderboard (id,rank) VALUES ('$id','$rrank')";
						$result = updatedb($sqlcmd,$db_conn);
						break;
					}
					//遇到比較低分的人
					if($udscore>$rscore){
						//echo "<br>分數<br>".$udscore."<br>".$rscore;
						//echo "<br>".$rrank;
						//名次往後
						/*for($i=$rrank;$i<$rank;$i++){
							$nrank=$i+1;
							//echo "<br>for:<br>".$i.$nrank;
							$sqlcmd="UPDATE game_leaderboard SET rank='$nrank' WHERE rank='$i'";
							$result = updatedb($sqlcmd,$db_conn);
						}*/
						for($i=$rank;$i>=$rrank;$i--){
							$nrank=$i+1;
							//echo "<br>for:<br>".$i.$nrank;
							$sqlcmd="UPDATE game_leaderboard SET rank='$nrank' WHERE rank='$i'";
							$result = updatedb($sqlcmd,$db_conn);
						}
						$sqlcmd="INSERT INTO game_leaderboard (id,rank) VALUES ('$id','$rrank')";
						$result = updatedb($sqlcmd,$db_conn);
						/*$sqlcmd="UPDATE game_leaderboard SET rank='$rrank' WHERE id='$id'";
						$result = updatedb($sqlcmd,$db_conn);*/
						break;
					}
				
				}
				$sqlcmd="UPDATE game_characters SET first='Y' WHERE id='$id'";
				$result = updatedb($sqlcmd,$db_conn);
			}
		}
?>
<html>
<head>
<meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<meta HTTP-EQUIV="Pragma" CONTECT="no-cache">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<title>結算畫面</title>
<style>
body{
    font-family:monospace;
    text-align: center;
	background-image: url(background_jungle.jpg);
	background-attachment:fixed;
    background-repeat:no-repeat;
	background-size: cover;
}
</style>
</head>
<body>
<div style="text-align:center; margin-top:100px; font-size:50pt;font-weight:bold;">
結束
</div>
<div style="text-align:center; margin-top:20px;">
<img src="line.png" border="0" width="700px" height="100px">
</div>
<div style="text-align:center; margin-top:30px;display:inline-block">
<img src="pen.png" border="0" width="150px" height="100px">
</div>
<div style="text-align:center; margin-top:30px;font-size:60pt;font-weight:bold;display:inline-block">
得分 : <?php echo $score2; ?>
</div>
<div style="text-align:center; margin-top:20px;">
<img src="line.png" border="0" width="700px" height="100px">
</div>
<div style="text-align:center; margin-top:30px; font-size:40pt;">
<img src="title.png" border="0" width="100px" height="100px">
<a href="index.php" style="text-decoration:none;">回首頁</a>
</div>
</body>
</html>