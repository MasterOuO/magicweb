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
    margin-left:  500px;
    overflow: hidden;
}
nau {
    float: right;
    width: 160px;
	max-height: 300px;
    margin-right: 180px;
    padding: 1em;
	
}
p.indent{ padding-left: 15em }
p.indent1{ padding-left: 12em }
</style>
</head>
<body>
<div class="container">

<header>
  <a href="index.php" style="text-align:left"><img src="logo.png" border="0" width=300 height=200></a>
  <h1 style="text-align:center">取消訂單確認</h1>
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
		<meta http-equiv="refresh" content="0; url=error.php?Type=1" />
	  <a href="SignIn.php" style="text-decoration:none;color:#00AA55">用戶註冊</a>
	  <a href="login.php" style="text-decoration:none;color:#00AA55">登入</a>
	  <?php
  }
  ?>
  <a href="客服首頁.php" style="text-decoration:none;color:#00AA55">客服中心</a></h4>
</header>
<nav>
	
	<ul>
	<image src="/head/<?php echo $row['image'];?>" width="100" height="100">
	<p>id: <?php echo $row['id'];?></p>
	<p>name: <?php echo $row['name'];?></p>
	<p>餘額: <?php echo $row['wallet'];?></p>
	<a href="sell.php">我的商店</a><br>
	<a href="orders.php">購買中的產品</a><br>
	<a href="shop.php">販售中的產品</a><br>
	<a href="records.php">交易紀錄</a><br>
	<a href="mail.php" style="text-decoration:none;color:#003377">信箱</a><br>
	</ul>
</nav>
<nau>

</nau>
<article>
<?php
	$orderid=$_GET['orderid'];
	$sql="SELECT * FROM orders WHERE orderid='$orderid'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$productid=$row['product_id'];
	
	$sql="SELECT * FROM product WHERE product_id='$productid'";
	$result = $conn->query($sql);
	$row1 = $result->fetch_assoc();
?>
	 <br>
	<h1>訂單資料:</h1><br>
	訂單編號: <?php echo $row['orderid'];?><br><br>
	產品名稱: <?php echo $row1['product_name'];?><br><br>
    數量: <?php echo $row['quantity'];?><br><br>
    總價: <?php echo $row['price'];?><br><br>
	<form action="cancelData.php" method="post">
	<input type="hidden" name="orderid" value="<?php echo $_GET['orderid'];?>">
	<input type="submit" value="取消訂單">
	
  </form>
</article>
<footer style="text-align:center">
	Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>


</body>
</html>