<?php session_start();?>
</head>
<body>
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
	mysqli_query ($conn, "SET NAMES 'UTF8' ");

	
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
    margin-left:  500px;
    overflow: hidden;
}
</style>
</head>
<body>
<div class="container">

<header>
  <a href="index.php" style="text-align:left"><img src="logo.png" border="0" width=300 height=200></a>
  <h1 style="text-align:center">修改使用者資料</h1>
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
		<a href="sell.php">我的商店</a><br>
		<a href="orders.php">購買中的產品</a><br>
		<a href="shop.php">販售中的產品</a><br>
		<a href="records.php">交易紀錄</a><br>
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
	<br>
	<?php
	$changeType=$_POST['changetype'];
	if($changeType==1){
		define('_DOC_ROOT_', 'C:\\xampp\\tmp\\');
		if( !isset($_FILES['list']) )
			return false;
		$tmp_name = $_FILES['list']['tmp_name'];
		$image = $_FILES['list']['name'];
		$real_name = 'D:\\xampp\\htdocs\\head\\' . basename($_FILES['list']['name']);
		move_uploaded_file($tmp_name, $real_name);
		
		$name=$_POST['username'];
		$password=$_POST['password'];
		$email=$_POST['email'];
		$phone=$_POST['phonenumber'];
		$address=$_POST['address'];
		if( !empty($_FILES['list'])){
			$sql="UPDATE user SET image='$image' WHERE account='$account'";
			if($conn->query($sql)===TRUE){
				echo "成功更改大頭貼 <br><br>";
			}
		}
		if(!empty($name)){
			$sql="UPDATE user SET name='$name' WHERE account='$account'";
			if($conn->query($sql)===TRUE){
				echo "名稱已更改為: ",$name,"<br><br>";
			}
		}
		if(!empty($password)){
			$sql="UPDATE user SET password='$password' WHERE account='$account'";
			if($conn->query($sql)===TRUE){
				echo "密碼已更改為: ",$password,"<br><br>";
			}
		}
		if(!empty($phone)){
			$sql="UPDATE user SET phonenumber='$phone' WHERE account='$account'";
			if($conn->query($sql)===TRUE){
				echo "手機號碼已更改為: ",$phone,"<br><br>";
			}
		}
		if(!empty($email)){
			$sql="UPDATE user SET email='$email' WHERE account='$account'";
			if($conn->query($sql)===TRUE){
				echo "E-mail已更改為: ",$email,"<br><br>";
			}
		}
		if(!empty($address)){
			$sql="UPDATE user SET address='$address' WHERE account='$account'";
			if($conn->query($sql)===TRUE){
				echo "地址已更改為: ",$address,"<br><br>";
			}
		}
	}
	else if($changeType==2){
		$account2=$_POST['account'];
		$password2=$_POST['password'];
		$sql="UPDATE user SET password='$password2' WHERE account='$account2'";
		if($conn->query($sql)===TRUE){
			echo "密碼已更改為: ",$password2,"<br><br><br><br><br><br><br><br><br><br><br><br>";
		}
	}
	?>
</article>
<footer style="text-align:center">
	Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>
</body>
</html>