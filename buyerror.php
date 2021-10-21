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
<style>

table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
    text-align: center;
}
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
	border: 1px solid gray;
	background-color:#FFC8B4;
	background-image: url(bgImg1.png);
	background-attachment:fixed;
    background-repeat:no-repeat;
	background-size: 100%;
	position:relative;
    text-align: left;
    width: 1200px;
	height: 1000px;
    padding:0px 0px 0px 0px;
    margin:10px auto;
}
header, footer {
    padding: 1em;
	clear: left;
	font-family:Microsoft JhengHei;
}
nav {
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
  <a href="index.php" style="text-align:left"><img src="logo.png" border="0" width=300 height=200></a>
  <h1 style="text-align:center">購買中的商品</h1>
  <h4 style="text-align:right">
  <?php
  if (!empty($_SESSION['account'])){
	  $account=$_SESSION['account'];
	  $sql="SELECT * FROM user WHERE account='$account'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$userid=$row['id'];
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
	<li><h3>實體商品</h3></li>
	<li><h4><a href="productlist.php?productType=3" style="text-decoration:none;color:#003377">CPU</h4></a></li>
    <li><h4><a href="productlist.php?productType=1" style="text-decoration:none;color:#003377">顯示卡</h4></a></li>
	<li><h4><a href="productlist.php?productType=5" style="text-decoration:none;color:#003377">手機</h4></a></li>
	<li><h4><a href="productlist.php?productType=2" style="text-decoration:none;color:#003377">公仔/PVC</h4></a></li>
	<li><h3>虛擬商品</h3></li>
	<li><h4><a href="#" target="_blank" style="text-decoration:none;color:#003377">遊戲虛寶</h4></a></li>
	<li><h4><a href="productlist.php?productType=4" style="text-decoration:none;color:#003377">遊戲點數</h4></a></li>
	</ul>
</nav>
<article>
	<center>庫存不夠<br>
	<a href="index.php" style="text-decoration:none">回首頁</a>
</article>
<footer style="text-align:center">
	Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>


</body>
</html>