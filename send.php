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
<title>Mail</title>
<style>
table, th, td {
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
  <h1 style="text-align:center">客戶介面</h1>
  <h4 style="text-align:right">
  <?php
  if (!empty($_SESSION['account'])){
	  $account=$_SESSION['account'];
	  $sql="SELECT * FROM user WHERE account='$account'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$id=$row['id'];
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
	<img src="/head/<?php echo $row['image'];?>" width="100" height="100">
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
<nau>
</nau>
<article>
	<table style="width:100%">
	<tr>
		<td style="width:50%"><a href="mail.php" style="text-decoration:none;color:#003377"><center>信箱</a><br></td>
		<td style="width:50%"><a href="send.php" style="text-decoration:none;color:#003377"><center>寄信備份</a><br></td>
	</tr>
	</table>
	<center><a href="sendmail.php" style="text-decoration:none;color:#003377">寄信</a><br>
	<br><table style="width:100%">
	<tr>
		<td style="width:20%">收信人編號<br></td>
		<td style="width:50%">內容<br></td>
		<td style="width:30%">時間<br></td>
	</tr>
	<?php
		$sql="SELECT * FROM mail WHERE sender_id='$id'";
		$result = $conn->query($sql);
		foreach($result as $value){
			?>
			<tr>
			<td style="width:20%">No.<?php echo $value['receiver_id'];?><br></td>
			<td style="width:50%"><a href="mailcontent.php?mailid=<?php echo $value['mail_id'];?>" style="text-decoration:none;color:#003377">內容</a><br></td>
			<td style="width:50%"><?php echo $value['date'];?><br></td>
			</tr>
			<?php
		}
	?>
	
	</table>
</article>
<footer style="text-align:center">
	Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>


</body>
</html>