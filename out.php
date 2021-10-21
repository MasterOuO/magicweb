<?php session_start(); ?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
//將session清空
unset($_SESSION['account']);
echo '登出中......';
echo '<meta http-equiv="refresh" content="0; url=index.php" />';
?>