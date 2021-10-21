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

<html>
 <meta charset="UTF-8">
<!meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	background-image: url(bgImg5-1.png);
    background-repeat:repeat;
	background-size: 100%;
    float: left;
	width: 250px;
	padding: 1em;
}

nav ul {
	text-align:center;
    list-style-type: none;
    padding: 0;
}

nav ul a{
    text-decoration: none;
}
nau {
    float: right;
    width: 160px;
	max-height: 300px;
    margin-right: 100px;
    padding: 1em;
	
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

<nav class="menu">
  <ul>
    <li><h3 class="indent">商品分類</h3></li>
	<li><h4 class="indent"><a href="productlist.php?productType=CPU" style="text-decoration:none;color:#003377">CPU</h4></a></li>
    <li><h4 class="indent"><a href="productlist.php?productType=顯示卡" style="text-decoration:none;color:#003377">顯示卡</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=手機" style="text-decoration:none;color:#003377">手機</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=公仔/PVC" style="text-decoration:none;color:#003377">公仔/PVC</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=家用主機" style="text-decoration:none;color:#003377">家用主機</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=耳機/喇叭" style="text-decoration:none;color:#003377">耳機/喇叭</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=電視" style="text-decoration:none;color:#003377">電視</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=筆電" style="text-decoration:none;color:#003377">筆電</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=遊戲點數" style="text-decoration:none;color:#003377">遊戲點數</h4></a></li>
	<li><h4 class="indent"><a href="productlist.php?productType=其他" style="text-decoration:none;color:#003377">其他</h4></a></li>
  </ul>
</nav>
<nau>
	<a href="game/index.php"><img src="/game/title.png" border="0" width="250px"></a>
</nau>
<article>
  <form action="productlist.php" method="get">
	<input type="hidden" name="productType" value="搜索">
  <input type="text" name="reaserch" style="width:500px;height:30px;margin-left:50px" placeholder="請輸入想要搜尋的商品">
  <input type="submit" style="width:50px;height:30px" value="搜尋"><br><br>
  </form>
  
  
  <?php
	$typeid=$_GET['productType'];
	if($typeid=="搜索"){
		$reaserch=$_GET['reaserch'];
		$sql="SELECT * FROM product WHERE product_name LIKE '%$reaserch%'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
	}
	else{
		$sql="SELECT * FROM product WHERE type='$typeid'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
	}
	$data_nums = mysqli_num_rows($result);
	$bigper=12;
	
	$data_nums = mysqli_num_rows($result);
	$pages = ceil($data_nums/$bigper);
	if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
	$bigstart = ($page-1)*$bigper;
	$per=4;
	$start =($page-1)*$bigper;
	$num=$data_nums-$bigstart;
	$j=$num/4;
	?><table style="width:100%"><?php
	if($num<4)?><table style="width:<?php echo 25*$num;?>%"><?php
	for($i=0;$i<$j;$i++){
		$result = $conn->query($sql.' LIMIT '.$start.', '.$per);
		
		echo"<tr>";
		while($row=mysqli_fetch_array($result)){
			
			$image=$row['image'];
			?><td style="width:25%"><image src="/picture/<?php echo $row['image'];?>" width='100' height='100'></td><?php
		}
		echo"</tr>";
		
		$result = $conn->query($sql.' LIMIT '.$start.', '.$per);
		echo"<tr>";
		while($row=mysqli_fetch_array($result)){
			echo "<td style='width:25%'>名稱:",$row['product_name'],"</td>";
		}
		echo"</tr>";
		
		$result = $conn->query($sql.' LIMIT '.$start.', '.$per);
		echo"<tr>";
		while($row=mysqli_fetch_array($result)){
			echo "<td style='width:25%'>價格:",$row['one_price'],"</td>";
		}
		echo"</tr>";
		
		$result = $conn->query($sql.' LIMIT '.$start.', '.$per);
		echo"<tr>";
		while($row=mysqli_fetch_array($result)){
			?>
			<td style="width:25%"><a href="product.php?productid=<?php echo $row['product_id']; ?>" style="text-decoration:none;color:#003377">購買</a></td>
			<?php
		}
		echo"</tr>";
		$start+=$per;
		if($i==2) break;
	}
	?>
	</table>
	<br>
	<?php
    //分頁頁碼
	echo '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
    echo '共 '.$data_nums.' 筆-在 '.$page.' 頁-共 '.$pages.' 頁';
	echo '<br />&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;';
    echo "<a href=?productType=$typeid&page=1>首頁</a> ";
    echo "第 ";
    for( $i=1 ; $i<=$pages ; $i++ ) {
        if ( $page-3 < $i && $i < $page+3 ) {
            echo "<a href=?productType=$typeid&page=".$i.">".$i."</a> ";
        }
    } 
    echo " 頁 <a href=?productType=$typeid&page=".$pages.">末頁</a><br /><br />";
	?>
	<br>
</article>

<footer style="text-align:center">
    Copyright &copy; I2A01 I2A51<br>
	客服中心電話：0800-123-456<br>
	客服中心服務時間：9:00到20:00
</footer>

</div>
</body>
</html>
