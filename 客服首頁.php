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
<title>MagicWeb 客服中心</title>
<head>
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
nau {
    float: right;
    width: 160px;
	max-height: 300px;
    margin-right: 140px;
    padding: 1em;
	
}
nav {
	background-color:#DDDDDD;
    float: left;
	max-width: 160px;
	margin-left:  100px;
	padding: 1em;
}

nav ul {
    list-style-type: none;
    padding: 0;
}

nav ul a{
    text-decoration: none;
}

article {
    margin-left:  300px;
    overflow: hidden;
}

</style>
</head>
<body>
<div class="container">

<header>
  <a href="index.php style="text-align:left"><img src="logo.png" border="0" width=300 height=200></a>
  <h1 style="text-align:center">客服中心</h1>
  <h4 style="text-align:right">
  <?php
  if (!empty($_SESSION['account'])){
	  $account=$_SESSION['account'];
	  $sql="SELECT * FROM user WHERE account='$account'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
	  ?>
	  <a href="user.php" style="text-decoration:none;color:#00AA55"><?php echo $row['name'],"你好";?></a>
	  <a href="out.php" style="text-decoration:none;color:#00AA55">登出</a>
	  <?php
  }
  else{?>
	  <a href="SignIn.php" style="text-decoration:none;color:#00AA55">用戶註冊</a>
	  <a href="login.php" style="text-decoration:none;color:#00AA55">登入</a>
	  <?php
  }
  ?>
  <a href="客服首頁.php" style="text-decoration:none;color:#00AA55">客服中心</a></h4>
 </header>

<nav>
	<ul>
	<?php
	 if (!empty($_SESSION['account'])){
		?>
		<image src="/head/<?php echo $row['image'];?>" width="100" height="100">
		<p>id: <?php echo $row['id'];?></p>
		<p>name: <?php echo $row['name'];?></p>
		<p>餘額: <?php echo $row['wallet'];?></p>
		<a href="sell.php" style="text-decoration:none;color:#003377">我的商店</a><br>
		<a href="orders.php" style="text-decoration:none;color:#003377">購買中的產品</a><br>
		<a href="shop.php" style="text-decoration:none;color:#003377">販售中的產品</a><br>
		<a href="records.php" style="text-decoration:none;color:#003377">交易紀錄</a><br>
		<a href="mail.php" style="text-decoration:none;color:#003377">信箱</a><br>
		<?php
	 }
	 else{
		?>
		<a href="login.php" style="text-decoration:none" style="text-decoration:none;color:#003377">請登入</a>
		<?php
	 }
	 ?>
	</ul>
</nav>
<article>
	<h1>客服中心</h1>
	<a href="forgot.php" style="text-decoration:none;color:#00AA88">忘記帳密</a><br>
	<p>服務時間</p>
	<p>週一到週五 10:00am～10:00pm</p>
	<p>週六,週日 9:00am～11:00pm</p>
	<p>客服專線:0800-000-000</p>
	<p>客服e-mail:u10506101@ms.ttu.edu.tw</p>
	<p>客服e-mail:u10506151@ms.ttu.edu.tw</p>
</article>
<footer style="text-align:center">
	Copyright &copy; I2A01 I2A51<br>
</footer>


</body>
</html>