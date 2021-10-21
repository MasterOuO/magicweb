<?php
function userauth($ID, $PWD, $db_conn) {
    $sqlcmd = "SELECT * FROM game_user WHERE account='$ID'";
    $rs = querydb($sqlcmd, $db_conn);
    $retcode = 0;
    if (count($rs) > 0) {
        $Password = sha1($PWD);
        if ($Password == $rs[0]['passwd']) $retcode = 1;
    }
    return $retcode;
}
session_start();
session_unset();
require_once("../include/gpsvars.php");
require ("../include/configure.php");
require ("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);
$ErrMsg = "";
if (!isset($ID)) $ID = "";
if (isset($Submit)) {
    if (strlen($ID) > 0 && strlen($ID)<=16 && $ID==addslashes($ID)) {
        $Authorized = userauth($ID,$PWD,$db_conn);
		if ($Authorized) {
		    $sqlcmd = "SELECT * FROM game_user WHERE account='$ID'";
		    $rs = querydb($sqlcmd, $db_conn);
			$account = $rs[0]['account'];
			$_SESSION['gameaccount']=$account;
            header ("Location: index.php");
            exit();
		}
		$ErrMsg = '<font color="Red">'
			. '帳號或密碼錯誤</font>';
    } else {
		$ErrMsg = '<font color="Red">'
			. '帳號或密碼錯誤</font>';
	}
  if (empty($ErrMsg)) $ErrMsg = '<font color="Red">登入錯誤</font>';
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
		#image_logo {
			margin-top: 22px;
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
		#image_logo {
			margin-top: 22px;
		}
		#a2{
			font-family: 宋體;
			font-size: 20px;
			color: white;
		}
		.label_input {
			font-size: 14px;
			font-family: 宋體;
			width: 65px;
			height: 28px;
			line-height: 28px;
			text-align: center;
			color: white;
			background-color: #3CD8FF;
			border-top-left-radius: 5px;
			border-bottom-left-radius: 5px;
		}
		.text_field {
			width: 278px;
			height: 28px;
			border-top-right-radius: 5px;
			border-bottom-right-radius: 5px;
			border: 0;
		}
		#btn_login {
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
		#forget_pwd {
			font-size: 12px;
			color: white;
			text-decoration: none;
			position: relative;
			float: right;
			top: 5px;
		}
		#forget_pwd:hover {
			color: blue;
			text-decoration: underline;
		}
		#login_control {
			padding: 0 28px;
		}
</style>
<html>
<head>
<meta charset="UTF-8">
<title>登入頁面</title>
</head>
<script type="text/javascript">
function setFocus()
{
<?php if (empty($ID)) { ?>
    document.LoginForm.ID.focus();
<?php } else { ?>
    document.LoginForm.PWD.focus();
<?php } ?>
<?php if (!empty($ErrMsg)) {?>
	alert("帳號或密碼錯誤");
	
<?php $ErrMsg = "";} ?>

}
</script>
<body onload="setFocus()">
<div id="login_frame">
<img src="logo.png"></img>
<a id="a2">登入系統</a>
<form method="post" name="LoginForm" action="">
<p><label class="label_input">帳號</label><input type="text" name="ID"  value="<?php echo $ID; ?>" class="text_field"/></p>
<p><label class="label_input">密碼</label><input type="password" name="PWD" class="text_field"/></p>
<div id="login_control">
<input type="submit" name="Submit" id="btn_login" value="登入"/>
<a id="forget_pwd" href="register.php">沒有帳號嗎?註冊</a>
</div>
</form>
</div>

</body>
</html>