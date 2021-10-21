<?php session_start();?>
<?php
	$servername = "127.0.0.1";
	$username0 = "root";
	$password0 = "";
	$dbname = "special";
	// Create connection
	$conn = mysqli_connect($servername, $username0, $password0, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	mysqli_query ($conn, "SET NAMES 'UTF8' ")
?>
<html>
<meta charset="UTF-8">
<head>
<title>MagicWeb 註冊</title>
<style>
body{
    font-family:Microsoft JhengHei;
    margin:0px 0px 0px 0px;
    text-align: center;
    background-image: url(bgImg2.png);
	background-attachment:fixed;
    background-repeat:no-repeat;
	background-size: 100%;
}
div.container {
	background-color:WHITE;
	border: 1px solid gray;
	position:relative;
    text-align: left;
    width: 1200px;
	height: 1000px;
    padding:0px 0px 0px 0px;
    margin:10px auto;
}
header {
	background-image: url(bgImg1.png);
    background-repeat:no-repeat;
	background-size: 100%;
    padding: 1em;
	clear: left;
	font-family:Microsoft JhengHei;
}
footer {
	color:WHITE;
	background-color:BLACK;
	padding: 1em;
	clear: left;
	font-family:Microsoft JhengHei;
}

article {
    margin-left:  500px;
    overflow: hidden;
}

h3.indent{
	margin-left:  10px;
}

h4.indent{
	margin-left:  10px;
}
</style>
</head>

<body>
<div class="container">

<header>
  <a href="index.php" style="text-align:left"><img src="logo.png" border="0" width=300 height=200></a>
  <div  style="margin-left:  450px;">
  <img src="ing.gif">
  </div>
  <h4 style="text-align:right">
  <a href="SignIn.php" style="text-decoration:none;color:#00AA55">用戶註冊</a>
  <a href="LogIn.php" style="text-decoration:none;color:#00AA55">登入</a>
  <a href="#" style="text-decoration:none;color:#00AA55">客服中心</a></h4>
</header>
<article>
<?php

$user = $_POST['user'];
$account = $_POST['account'];
$password = $_POST['password'];
$mail = $_POST['email'];
$sex = $_POST['sex'];
$phonenumber = $_POST['phonenumber'];
$birthday = $_POST['birthday'];
$address = $_POST['address'];
$sql = "SELECT * FROM user WHERE account='$account'";
$result = $conn->query($sql);
if ($result->num_rows > 0 ) {
	echo "註冊失敗: " . "帳號重複";
	echo "3秒後跳轉回註冊頁面!<br>"
	?>
	<meta http-equiv="refresh" content="3; url=SignIn.php" />
	<?php
}
else{
	$sql = "INSERT INTO user (name, account, password, email, sex,  birthday, address, image,phonenumber)
	VALUES ('$user', '$account', '$password', '$mail', '$sex', '$birthday', '$address','head.jpg',$phonenumber)";
	if ($conn->query($sql) === TRUE) {
		echo "註冊成功!<br>";
		echo "3秒後跳轉回首頁!<br>";
		$_SESSION['account']=$account;
		?>
		<meta http-equiv="refresh" content="3; url=SignIn.php" />
		<?php
	} 
	else {
		echo "註冊失敗: " . $sql . "<br>" . $conn->error;
		echo "3秒後跳轉回註冊頁面!<br>"
	    ?>
	    <meta http-equiv="refresh" content="3; url=SignIn.php" />
	    <?php
	}
}


$conn->close();
?>
<article>
</body>
</html>