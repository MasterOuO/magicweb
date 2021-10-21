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
  <a href="index.php" style="text-align:left"><img src="logo.png" border="0" width=300 height=200></a>
  <h1 style="text-align:center">我的商店</h1>
  <h4 style="text-align:right">
  <?php
  if (!empty($_SESSION['account'])){
	  $account=$_SESSION['account'];
	  $sql="SELECT * FROM user WHERE account='$account'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$userid=$row['id'];
	  ?>
	  <a href="user.php" style="text-decoration:none;color:#00AA55"><?php echo $row['name']," 你好";?></a>
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
		<a href="login.php" style="text-decoration:none">請登入</a>
		<?php
	 }
	 ?>
	</ul>
</nav>
<article>
	<br>
	<a href="uploadproduct.php" style="text-decoration:none;color:#FF8800">上架新產品</a><br><br>
  <table style="width:80%">
	
  <tr>
    <th width="5%">商品編號</th>
	<th width="10%">商品</th>
	<th width="5%">庫存</th>
	<th width="5%">單價</th>
	<th width="5%">種類</th>
	<th width="5%"></th>
	<th width="5%"></th>
  </tr>
	<?php
		$sql="SELECT * FROM product WHERE seller_id='$userid'";
		$result = $conn->query($sql);
		foreach($result as $value){
			$productid=$value['product_id'];
			?>
			<tr>
			<td width="5%"><?php echo $value['product_id']; ?></td>
			<td width="10%"><a href="product.php?productid=<?php echo $value['product_id']; ?>" style="text-decoration:none;color:#0000FF"><?php echo $value['product_name']; ?></td>
			<td width="5%"><?php echo $value['stock']; ?></td>
			<td width="5%"><?php echo $value['one_price']; ?></td>
			<td width="5%"><?php echo $value['type']; ?></td>
			<td width="5%"><a href="changeproduct.php?productid=<?php echo $value['product_id']; ?>" style="text-decoration:none;color:RED">修改</a></td>
			<td width="5%"><a href="deproduct.php?productid=<?php echo $value['product_id']; ?>" style="text-decoration:none;color:RED">刪除</a></td>
			</tr>
			<?php
		}
	?>
	
  </tr>
</table>
</article>
<footer style="text-align:center">
	Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>


</body>
</html>