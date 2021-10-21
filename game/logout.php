<?php
// Authentication 認證
// require_once("../include/auth.php");
 session_start();
// 變數及函式處理，請注意其順序
//require_once("../include/gpsvars.php");
//require_once("../account/account.php");
require_once("../include/configure.php");
require_once("../include/db_func.php");
$db_conn = connect2db($dbhost, $dbuser, $dbpwd, $dbname);

$account=$_SESSION['gameaccount'];
unset($_SESSION['gameaccount']);
header("Location: login.php");
?>

</div>
</body>
</html>