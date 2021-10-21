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
	if (empty($_SESSION['account']))
		echo '<meta http-equiv="refresh" content="0; url=error.php?Type=1" />';	
	$comment=$_POST['talk'];
	$id=$_POST['productid'];
	if(empty($comment)){
		?>
		<meta http-equiv="refresh" content="0; url=error.php?Type=5&productid=<?php echo $id;?>" />
		<?php
	}
	else{
		$sq="SELECT * FROM user WHERE account='$account'";
		$result = $conn->query($sq);
		$row = $result->fetch_assoc();
		$buyid=$row['id'];
		echo $comment;
		$d=strtotime("+6 hours");
		$TWtime=date("Y-m-d H:i:s",$d); 
		$sql="INSERT INTO comment(product_id, user_id, message, date) 
		VALUES ('$id','$buyid' , '$comment', '$TWtime')";
		
		if ($conn->query($sql) === TRUE) {
			echo "留言!";
		} 
		else {
			echo "留言失敗: " . $sql . "<br>" . $conn->error;
			echo '<meta http-equiv="refresh" content="0; url=error.php?Type=11" />';
		}
		?>
		<meta http-equiv="refresh" content="0; url=product.php?productid=<?php echo $id;?>" />
		<?php	
	}
	
?>