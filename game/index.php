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
$account=$_SESSION['gameaccount'];
if(!isset($account))
{
	
	header("location:login.php");
	exit();
	
}
$sqlcmd="UPDATE game_user SET score= 0  WHERE account='$account'";
$result = updatedb($sqlcmd, $db_conn);
?>
<!DOCTYPE HTML PUBLIC>
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
			margin-top:30px;
		}
		.label_input {
			font-size: 25px;
			font-family: 宋體;
			width: 65px;
			height: 28px;
			line-height: 28px;
			text-align: center;
			color: white;
			background-color: white;
			border-top-left-radius: 5px;
			border-bottom-left-radius: 5px;
			border-bottom-right-radius: 5px;
			border-top-right-radius: 5px;
			
		}
		#a2{
			font-family: 宋體;
			font-size: 30px;
			color: blue;
		}
		#userdata
		{
			position:fixed;
			top:0;
			left:5%;
		}
		#lead
		{
			position:fixed;
			top:0;
			right:15%;
			
		}
		#logout
		{
			position:fixed;
			top:0;
			right:0;
			
		}
		#btn {
			font-size: 14px;
			font-family: 宋體;
			width: 120px;
			height: 28px;
			line-height: 28px;
			text-align: center;
			color: white;
			background-color: #3BD9FF;
			border-radius: 6px;
			border: 0;
			float: left;
		}
</style>
<html>
<head>
<title>我是主介面</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
</head>
<body>
<div id="userdata">
	<form method="post" name="yo" action="userdata.php">
	<input type="submit" name="Submit" id="btn" value="個人資料"/>
	</form>
</div>
<div id="login_frame">
<a id="a2">難度選擇</a>
<p><label class="label_input"><a href="game_easy.php" style="text-decoration:none;">簡單</a></label></p>
<br>
<p><label class="label_input"><a href="game_normal.php" style="text-decoration:none;">普通</a></label></p>
<br>
<p><label class="label_input"><a href="game_hard.php" style="text-decoration:none;">困難</a></label></p>
<br>
</div>
<div id="lead">
	<form method="post" name="yo" action="leaderboard.php">
	<input type="submit" name="leadborad" id="btn" value="排行榜"/>
	</form>
</div>
<div id="logout">
<form method="post" name="yo2" action="logout.php">
	<input type="submit" name="logout" id="btn" value="登出"/>
	</form>
</div>
</body>
</html>