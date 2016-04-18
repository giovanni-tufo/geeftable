<?php
include("header.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Page not found</title>
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
          <a class="brand" href="/">Geeftable</a>
 </div>
      </div>
    </div>

    <div class="container">
	<div class="hero-unit">
      <img src="./images/404.png" style="float:left;margin-right: 15px;" />
 	<h1>Page not found</h1>
	<p>Sorry! Nothing here. Just a strange box with a 404 label on it.</p>
	<p><a class="btn danger large" href="<?php echo BASE_SITE;?>">&larr; Bring me back to the Homepage!</a></p>
	</div>
 <footer>
      <p><a href="<?php echo BASE_SITE;?>">Geeftable</a> is made by <a href="http://www.giovannitufo.com">Giovanni Tufo</a>. You're using the beta version! Thank you and send me a <a href="mailto:joevanni99@gmail.com">feedback</a> if something goes wrong. <a href="http://www.iubenda.com/privacy-policy/746061" class="iubenda-white iubenda-embed" title="Privacy Policy">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "http://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>
</p>
      </footer>
    </div>

  </body>
</html>