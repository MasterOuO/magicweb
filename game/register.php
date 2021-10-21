<?php
session_start();
// 使用者點選放棄新增按鈕
if (isset($_POST['Abort'])) header("Location: index.php");
// Authentication 認證
//require_once("../include/auth.php");
// 變數及函式處理，請注意其順序
//require_once("../account/account.php");
require_once("../include/gpsvars.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
// echo 'I am here';
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

// echo 'I am here point 2';
if (!isset($username)) $username = '';
if (!isset($name)) $name = '';
if (!isset($account)) $account = '';
if (!isset($passwd)) $passwd = '';
if (!isset($email)) $email = '';
if (!isset($phone)) $phone = '';
if (!isset($birthday)) $birthday = '';
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
			height: 660px;
			padding: 13px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -200px;
			margin-top: -300px;
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
			padding: 0 60px;
		}
</style>

<div id="login_frame">
<form action="" method="post" name="inputform">
	<img src="logo.png"></img>
	<a id="a2">玩家註冊</a>
  <p><label class="label_input">姓名:</label>
  <input type="text" name="username" value="<?php echo $username ?>" size="20"><br><br>
  <p><label class="label_input">帳號:</label>
  <input type="text" name="account" value="<?php echo $account ?>" size="20"><br><br>
  <p><label class="label_input">密碼:</label>
  <input type="password" name="passwd" value="" size="20"><br><br>
  <p><label class="label_input">遊戲名稱:</label>
  <input type="text" name="name" value="<?php echo $name ?>" size="20"><br><br>
  <p><label class="label_input">信箱:</label>
  <input type="email" name="email" value="<?php echo $email ?>" size="20"><br><br>
  <p><label class="label_input">電話:</label>
  <input type="text" name="phone" value="<?php echo $phone ?>" size="20"><br><br>
  <p><label class="label_input">生日:</label>
  <input type="date" name="birthday" value="" size="20"><br><br>
  <p><label class="label_input">性別:</label>
  <input type="radio" name="gender" value="male" checked> 男
  <input type="radio" name="gender" value="female">女<br><br>
  <div id="login_control">
	<input type="submit" name="Confirm" id="btn_login" value="立即註冊">
	<a href="login.php">回登入介面</a>
	</div>
</form>
</div>
<br>


<?php


if (isset($Confirm)) {   // 確認按鈕
	if (empty($username)) $ErrMsg = '本人姓名不可為空白\n';
    if (empty($name)) $ErrMsg = '玩家姓名不可為空白\n';
	if (empty($account)) $ErrMsg = '帳號不可為空白\n';
	if (empty($passwd)) $ErrMsg = '密碼不可為空白\n';
	if (empty($email)) $ErrMsg = '信箱不可為空白\n';
    if (empty($phone)) $ErrMsg = '電話不可為空白\n';
	if (empty($birthday)) $ErrMsg = '生日不可為空白\n';
	
    $sqlcmd="SELECT * FROM game_user WHERE account='$account'";
	$rs = querydb($sqlcmd, $db_conn);
	if(count($rs)>0) $ErrMsg = '此帳號已被註冊過\n';
    
    if (empty($ErrMsg)) {
        // 確定此用戶可設定所選定群組的聯絡人資料
		//+到game_user表格
		/*$sqlcmd='INSERT INTO test (name) VALUES ('
            . "'$name')";*/
		$password=sha1($passwd);
			
		/*$sqlcmd = "SELECT * FROM game_user";
		$rs = querydb($sqlcmd, $db_conn);
		$id = count($rs)+1;
		echo "<center>$id<br>";*/
        $sqlcmd='INSERT INTO game_user (username,name,account,passwd,mail,phone,birthday,gender) VALUES ('
            . "'$username','$name','$account','$password','$email','$phone','$birthday','$gender')";
        $result = updatedb($sqlcmd, $db_conn);
		//尋找最新註冊玩家的id
		$sqlcmd = "SELECT count(*) AS idccount FROM game_user WHERE username='$username'";
        $rs = querydb($sqlcmd, $db_conn);
        $cidCount = $rs[0]['idccount']-1;
		$sqlcmd = "SELECT * FROM game_user WHERE username='$username'";
		$rs = querydb($sqlcmd, $db_conn);
		$id=$rs[$cidCount]['id'];
		//+到game_characters表格
		$sqlcmd='INSERT INTO game_characters (id,name) VALUES ('
            . "'$id','$name')";
        $result = updatedb($sqlcmd, $db_conn);
	
	//if ($result === TRUE) {
		echo "<center><label class='label_input'>註冊成功!</label><br>";
		echo "<label class='label_input'>1秒後跳轉回首頁!</label><br></center>";
		$_SESSION['gameaccount']=$account;
		?>
		<meta http-equiv="refresh" content="1; url=index.php" />
		<?php
	//} 
	/*else {
		echo "註冊失敗: " . $sqlcmd . "<br>" . $db_conn->error;
		//echo "3秒後跳轉回註冊頁面!<br>"
	    //?>
	    <!--<meta http-equiv="refresh" content="3; url=register.php" />-->
	    <?php
	}
        //header("Location: index.php");*/
    }
}
$PageTitle = '玩家註冊';
//require_once("../include/header.php");
//require_once ('../include/footer.php');
?>
