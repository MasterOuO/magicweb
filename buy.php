<?php session_start();?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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
	$account=$_SESSION['account'];
	$id=$_GET['productid'];
	$quantity=$_GET['quantity'];
	$destination=$_GET['destination'];
	$stock=$_GET['stock'];
	if (empty($_SESSION['account'])){
		echo '<meta http-equiv="refresh" content="0; url=error.php?Type=1" />';	
	}
	if($stock<$quantity){
		?>
		<meta http-equiv="refresh" content="0; url=error.php?Type=2&productid=<?php echo $id;?>" />
		<?php
	}
	else if(empty($quantity)||$quantity<=0){
		?>
		<meta http-equiv="refresh" content="0; url=error.php?Type=3&productid=<?php echo $id;?>" />
		<?php
	}
	else if(empty($destination)){
		?>
		<meta http-equiv="refresh" content="0; url=error.php?Type=4&productid=<?php echo $id;?>" />
		<?php
	}
	else{
		$sql="SELECT * FROM user,product WHERE user.account='$account' AND product.product_id='$id'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		$sellerid=$row['seller_id'];
		$buyer=$row['id'];
		$stock=$row['stock']-$quantity;
		$sqll="UPDATE product SET stock='$stock' WHERE product_id='$id'";
		$price=($row['one_price']*$quantity);
		$sq="INSERT INTO orders(product_id, buyer_id, quantity, destination, price, status,payment,seller_id) 
		VALUES ('$id','$buyer' , '$quantity', '$destination', '$price', '未出貨','n','$sellerid')";
		if ($conn->query($sq) === TRUE&&$conn->query($sqll) === TRUE) {
			echo "購買成功!";
		} 
		else {
			echo "購買失敗: " . $sql . "<br>" . $conn->error;
		}
		echo '<meta http-equiv="refresh" content="0; url=orders.php" />';	
	}
?>