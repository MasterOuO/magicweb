<?php
// Authentication 認證
// require_once("../include/auth.php");
 session_start();
// 變數及函式處理，請注意其順序
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
?>
<div style="text-align:right;">
<?php
	$account=$_SESSION['gameaccount'];
	if (!isset($_SESSION['gameaccount']) || empty($_SESSION['account'])) {
		//echo '您尚未未登入';
		die('您尚未未登入');
		//header ("Location: index.php");
		//exit();
		?>
		&nbsp;
		<a href="login.php">登入</a>
		<a href="register.php">註冊</a>
		<?php
	}
	else{
		$sqlcmd="SELECT * FROM game_user WHERE account='$account'";
		$rs = querydb($sqlcmd,$db_conn);
		$name=$rs[0]['name'];
		$id=$rs[0]['id'];
		echo "<a href='userdata.php'>".$name."</a>";
		?>
		<a href="logout.php">登出</a>
		<?
	}	
	$sqlcmd="SELECT * FROM game_characters WHERE id='$id'";
	$rs1 = querydb($sqlcmd,$db_conn);
	$first=$rs1[0]['first'];
	$score=$rs1[0]['highestscore'];
	
	if (!isset($udscore)) $udscore = 0;
	if (isset($Submit)) {
		//最高分數
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
	}
?>
</div>
<title>遊戲</title>
<br>
<center>
<h2>遊戲分數</h2><br>
<?php
	$sqlcmd="SELECT * FROM game_characters WHERE id='$id'";
	$rsa = querydb($sqlcmd,$db_conn);
	$first=$rsa[0]['first'];
	$score=$rsa[0]['highestscore'];
	echo '角色id:'.$id.'<br>';
	echo '角色名子:'.$name.'<br>';
	echo '角色最高分:'.$score.'<br>';
	$sqlcmd="SELECT * FROM game_leaderboard WHERE id='$id'";
	$rsb = querydb($sqlcmd,$db_conn);
	if($first=='Y')
		echo '角色名次:'.$rsb[0]['rank'];
	else
		echo '沒上榜';
?>
<form method="POST" name="scoreForm" action="">
	<center><br><br>
		本次分數:
      <input type="number" name="udscore" size="16" maxlength="16">
      <input type="submit" name="Submit" value="確定">
	</center>
  </form>
<br>
<a href="leaderboard.php">排行榜</a>
<br>
<a href="index.php">回首頁</a>
</center>
</div>
</body>
</html>