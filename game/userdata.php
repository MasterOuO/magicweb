<?php
// Authentication 認證
// require_once("../include/auth.php");
 session_start();
// 變數及函式處理，請注意其順序
//require_once("../include/gpsvars.php");
//require_once("../account/account.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
?>
<div style="text-align:right;">
<?php
$account=$_SESSION['gameaccount'];
if (!isset($_SESSION['gameaccount']) || empty($_SESSION['account'])) {
    ?>
		<meta http-equiv="refresh" content="3; url=index.php" />
	<?php
}
	$sqlcmd="SELECT * FROM game_user WHERE account='$account'";
	$rs = querydb($sqlcmd,$db_conn);
	$name=$rs[0]['name'];
	$id=$rs[0]['id'];
	$sqlcmd="SELECT * FROM game_characters WHERE id='$id'";
	$rs = querydb($sqlcmd,$db_conn);
	$highestscore=$rs[0]['highestscore'];
	$first=$rs[0]['first'];
?>
</div>
<style type="text/css">
		body {
			background-color:black;
			background-image: url("zz.gif");;
			background-size: 100%;
			background-repeat: no-repeat;
		}
		#login_frame {
			width: 400px;
			height: 260px;
			padding: 13px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -200px;
			margin-top: -200px;
			background-color: rgba(240, 255, 255, 0.5);
			border-radius: 10px;
			text-align: center;
		}
		form p > * {
			display: inline-block;
			vertical-align: middle;
		}
		.label_input {
			font-size: 20px;
			font-family: 宋體;
			width: 65px;
			height: 28px;
			line-height: 28px;
			text-align: center;
			color: white;
			border-top-left-radius: 5px;
			border-bottom-left-radius: 5px;
		}
		.label_input2 {
			font-size: 20px;
			font-family: 微軟正黑體;
			width: 65px;
			height: 28px;
			line-height: 28px;
			text-align: center;
			color: red;
			border-top-left-radius: 5px;
			border-bottom-left-radius: 5px;
		}
</style>
<html>
<title>玩家資料</title>
<br>
<body>
<center>
<h2>玩家資料</h2><br>
<div id="login_frame">

<!--<p><label class="label_input">玩家id:<?php //echo $account ?></label></p>--!>
<p><label class="label_input">玩家id:<?php echo $id ?></label></p>
<p><label class="label_input">玩家名字:<?php echo $name ?></label></p>
<p><label class="label_input">最高分數:<?php echo $highestscore ?></label></p>
<?php if($first=='Y'){
	$sqlcmd="SELECT * FROM game_leaderboard WHERE id='$id'";
	$rs = querydb($sqlcmd,$db_conn);
	$rank=$rs[0]['rank'];?>
	<p><label class="label_input">目前排行:第<?php echo $rank ?>名</label></p>
<?php } ?>
<?php if($first=='N'){?>
	<p><label class="label_input">尚未上榜</label></p>
<?php } ?>
<a href="index.php" style="text-decoration:none;" ><label class="label_input2">回主介面</label></a>
</div>

<br>

</center>
</div>
</body>
</html>