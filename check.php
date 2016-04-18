<?php
include("header.php");

$username = trim(strtolower($_POST['username']));
$username = escaper($username);
$query = "SELECT tiny FROM liste WHERE tiny = '$username' LIMIT 1";
$result = esegui_query($query);
$num = mysql_num_rows($result);
echo $num;
mysql_close();
