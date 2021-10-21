<?php session_start();?>
<!meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
<title>
</title>
<head>
<style>
table, th ,td{
    border: 1px solid black;
    border-collapse: collapse;
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
	background-color:WHITE;
	position:relative;
    text-align: left;
    width: 1200px;
	height: 1000px;
    padding:0px 0px 0px 0px;
    margin:10px auto;
}
header{
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
nav {
	border-top: 1px solid gray;
	border-left: 1px solid gray;
	border-right: 1px solid gray;
	border-bottom: 1px solid gray;
    float: left;
	max-width: 300px;
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
    margin-left:  450px;
    overflow: hidden;
}
nau {
    float: right;
    width: 160px;
	max-height: 300px;
    margin-right: 180px;
	border-top: 1px solid gray;
	border-left: 1px solid gray;
	border-right: 1px solid gray;
	border-bottom: 1px solid gray;
    padding: 1em;
	
}
</style>
</head>
<body>
<div class="container">

<header>
  <a href="index.php" style="text-align:left"><img src="logo.png" border="0" width=300 height=200></a>
  <h1 style="text-align:center">神奇網站 商品</h1>
  <h4 style="text-align:right">
  <?php
  if (!empty($_SESSION['account'])){
	  $account=$_SESSION['account'];
	  $sql="SELECT * FROM user WHERE account='$account'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
	  ?>
	  <a href="user.php" style="text-decoration:none;color:#00AA55"><?php echo $row['name']," 你好";?></a>
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
	<?php
	$id=$_GET['productid'];
	$sql="SELECT * FROM product WHERE product_id ='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
  ?>
	<image src="/picture/<?php echo $row['image'];?>"" width="300" height="300">
</nav>
<nau>
	<ul>
	<p>賣家資料:<p>
	<?php
	$sql="SELECT * FROM product WHERE product_id ='$id'" ;
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$seller_id=$row['seller_id'];
	?>
	<?php
		$sql="SELECT * FROM user WHERE id ='$seller_id'" ;
		$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	?>
	<image src="/head/<?php echo $row['image'];?>" width="100" height="100">
	<p>賣家編號: <?php echo $row['id'];?></p>
	<p>賣家姓名: <?php echo $row['name'];?></p>
	</ul>
</nau>
<article>
	<?php
	$sql="SELECT * FROM product WHERE product_id ='$id'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo "<br><center>商品名稱:",$row['product_name'] ,"<br><center>單價:",$row['one_price'],"<br><center>產品介紹:",$row["Introduce"];
  ?>
	<br>選擇數量:<br>
	<form action="buy.php">
	<input type="hidden"name="productid" value="<?php echo $row['product_id'];?>">
	<input type="hidden"name="stock" value="<?php echo $row['stock'];?>">
	<input type="text" name="quantity" value="1">
	<br>(剩餘庫存: <?php echo $row['stock'];?>)
	<br>送貨地址:<br>
	<input type="text" name="destination" value=""><br>
	<input type="submit" value="確認">
	</form> 
			  <body bgcolor="white">
			<hr size=1>
			<center>
			<!--以下是您的站台名稱-->
			<font size=5 color=red>產品留言板</font>
			<br>
			<table style="width:90%">
			<tr>
				<th width="10%">名稱</th>
				<th width="30%">留言</th>
				<th width="20%">留言時間</th>
			</tr>
			<?php
				$sql="SELECT * FROM comment WHERE product_id='$id'";
				$result = $conn->query($sql);
				foreach($result as $value){
					?>
					<tr>
					<?php
					$messager=$value["user_id"];
					$sqll="SELECT * FROM user WHERE id='$messager'";
					$resultt = $conn->query($sqll);
					$rowl = $resultt->fetch_assoc();
					?>
					<td width="10%"><?php echo $rowl["name"]," ";?></td>
					<td width="30%"><?php echo $value["message"]," ";?></td>
					<td width="20%"><?php echo $value["date"],"<br>";?></td>
					</tr>
					<?php
				}
			?>
			</table>
			<?php
		if (!empty($_SESSION['account'])){
			$sql="SELECT * FROM user WHERE account='$account'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
			?>
			<hr size=1>
			<table align=center border=0><tr>
			<form  action="comment.php" method="post">
			姓名: <?php echo $row['name']; ?><br>
			留言內容:<br>
			<textarea name="talk" rows="5" cols="45"></textarea>
			<input type="hidden"name="productid" value="<?php echo $id?>">
			<input type="submit" value="確定"> 
			<input type="reset" value="清除"><br><br>
			<!input type="button" value="回上一頁" onClick="history.back()">
			</form>
			</tr></table></center>
		  <?php
	  }
	  else{
		  ?>
			<center>尚未登入無法使用此功能<br>
			<center><a href="login.php" style="text-decoration:none">登入</a>
		  <?php
	  }
	  ?>
	
	
</body>
</article>
<footer style="text-align:center">
    Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>


</body>
</html>