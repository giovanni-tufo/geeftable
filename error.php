<?php
include("config.php");
include("functions.php");
$link = mysql_connect(SERVER_DB, USER_DB, PASS_DB);
if (!$link) {
	$error = mysql_error($link);
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Connection Error</title>
    <meta name="description" content="">
    <meta name="author" content="">

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

 
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/style.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/favicon.ico">

  </head>

  <body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="#">Geeftable</a>
 </div>
      </div>
    </div>

    <div class="container">

      <img src="./images/mistery.png" style="float:left;margin-right: 15px;" />
 	<h1>Mistery Box</h1>
	<p>Sorry! Something strange happened. Totally Giovanni's fault.</p>
	<p><strong>Error:</strong> <?php echo $error; ?></p>
	

    </div>

  </body>
</html>