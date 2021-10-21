<?php
// To extract the GET, POST, and $PHP_SELF variables.
// For security reason, this script should be included before other
// self-defined variables. Otherwise, self-defined variables may be
// replaced through parameter passing from GET or POST method.

if (isset($_GET)) {
	extract($_GET, EXTR_OVERWRITE);
}
if (isset($_POST)) {
    extract($_POST, EXTR_OVERWRITE);
} 
if (isset($_SESSION)) extract($_SESSION, EXTR_OVERWRITE);
// Get the IP address of client machine. If the client use proxy, the address
// is stored in server variable: HTTP_X_FORWARDED_FOR
if (isset($_SERVER['HTTP_VIA']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
    $UserIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
else $UserIP = $_SERVER['REMOTE_ADDR'];
?>