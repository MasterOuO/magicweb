<?php session_start();?>
<?php
	
	$servername = "127.0.0.1";
	$username0 = "root";
	$password0 = "";
	$dbname = "special";
	
	// Create connection
	$conn = new mysqli($servername, $username0, $password0, $dbname);
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	mysqli_query ($conn, "SET NAMES 'UTF8' ")
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
<title>MagicWeb 商品上傳</title>
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
    margin-left:  250px;
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
  <h1 style="text-align:center">神奇網站 商品上架</h1>
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
	<a href="sell.php" style="text-decoration:none;color:#003377">我的商店</a><br>
	<a href="orders.php" style="text-decoration:none;color:#003377">購買中的產品</a><br>
	<a href="shop.php" style="text-decoration:none;color:#003377">販售中的產品</a><br>
	<a href="records.php" style="text-decoration:none;color:#003377">交易紀錄</a><br>
	<a href="mail.php" style="text-decoration:none;color:#003377">信箱</a><br>
	</ul>
</nav>

<article>
<?php
	define('_DOC_ROOT_', 'C:\\xampp\\tmp\\');
	if( !isset($_FILES['list']) )
		return false;
	$tmp_name = $_FILES['list']['tmp_name'];
	$name = $_FILES['list']['name'];
	$real_name = 'D:\\xampp\\htdocs\\picture\\' . basename($_FILES['list']['name']);
	move_uploaded_file($tmp_name, $real_name);
	$seller_id = $row['id'];
	$productName = $_POST['productName'];
	$one_price = $_POST['price'];
	$stock = $_POST['quantity'];
	$Introduce = $_POST['description'];
	$type = $_POST['type'];
	if(empty($productName)){
		echo "請輸入產品名稱<br>";
		echo "3秒後回到上架頁面!<br>";
		?>
		<meta http-equiv="refresh" content="3; url=uploadproduct.php" />
		<?php
	}
	else if(empty($one_price)){
		echo "請輸入產品價格<br>";
		echo "3秒後回到上架頁面!<br>";
		?>
		<meta http-equiv="refresh" content="3; url=uploadproduct.php" />
		<?php
	}
	else if(empty($stock)){
		echo "請輸入庫存數量<br>";
		echo "3秒後回到上架頁面!<br>";
		?>
		<meta http-equiv="refresh" content="3; url=uploadproduct.php" />
		<?php
	}
	else if(empty($type)){
		echo "請輸入產品名稱<br>";
		echo "3秒後回到上架頁面!<br>";
		?>
		<meta http-equiv="refresh" content="3; url=uploadproduct.php" />
		<?php
	}
	else if(empty($Introduce)){
		echo "請輸入產品介紹<br>";
		echo "3秒後回到上架頁面!<br>";
		?>
		<meta http-equiv="refresh" content="3; url=uploadproduct.php" />
		<?php
	}
	else{
		$sql = "INSERT INTO product (product_name, one_price, stock, seller_id, Introduce,type,image)
			VALUE ('$productName', '$one_price', '$stock', '$seller_id', '$Introduce','$type','$name')";
		if($conn->query($sql) === TRUE){
			echo "商品上架成功!<br>";
			echo "3秒後回到上架頁面!<br>";
			?>
			<meta http-equiv="refresh" content="3; url=uploadproduct.php" />
			<?php
		}
		else{
			echo "商品上架失敗!<br>";	
			echo "3秒後回到上架頁面!<br>";
			?>
			<meta http-equiv="refresh" content="3; url=uploadproduct.php" />
			<?php
		}
	}
		
?>
</article>

<footer style="text-align:center">
    Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>

</div>
</body>
</html>