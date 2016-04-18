<?php
//header('Location: http://www.geeftable.com/maintenance.php');
include("config.php");
include("functions.php");
$link = mysql_connect(SERVER_DB, USER_DB, PASS_DB);
if (!$link) {
    die(connection_error());
}
session_start();
if (!isset($_SESSION['lid']) ) {
 session_defaults();
}
?>
