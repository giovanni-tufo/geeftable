<?php
include("header.php");
?>
<!DOCTYPE html>
<html dir="ltr" lang="it-IT">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    	<!--[if lt IE 9]>
      	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    	<![endif]-->

    	<link href="./css/bootstrap.min.css" rel="stylesheet">
		<link href="./css/style.css" rel="stylesheet">
        <link rel="shortcut icon" href="favicon.ico" >

	   <title>Tutte le liste - Geeftable</title>
	   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	   <script src="./js/bootstrap-dropdown.js"></script>
	   <script src="./js/bootstrap-modal.js"></script>
	   <script src="./js/bootstrap-twipsy.js"></script>
	   <script src="./js/bootstrap-popover.js"></script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1970556-9']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
  var uvOptions = {};
  (function() {
    var uv = document.createElement('script'); uv.type = 'text/javascript'; uv.async = true;
    uv.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'widget.uservoice.com/9DJWjFjrfNQwGfhR5b3Hsw.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(uv, s);
  })();
</script>
    </head>
    <body>

    <div class="topbar">
      <div class="fill">
        <div class="container">
          <a class="brand" href="<?php echo BASE_SITE;?>">Geeftable</a>
           <ul class="login nav secondary-nav">
          <?php login_bar(); ?></ul>
 </div>
      </div>
    </div>

    <div class="container">
<div class="row">
        <div class="span13">
<h1>Tutte le liste</h1>
<?php all_lists(); ?>
</div>
<div class="span3 clearfix" id="sidebar">
    <h2>Cos'è?</h2>
    <p>Geeftable è un servizio che ti permette di creare le tue wishlist in modo semplice e veloce e di condividerle con i tuoi amici</p>
<p>In questo momento ci sono <strong><a href="./all_items.php"><?php count_items();?></a></strong> oggetti e <strong><a href="./all_lists.php"><?php count_lists(); ?></a></strong> liste.</p>
            <h2 class="sidebar-caption">Come funziona?</h2>
            <h3>Step 1</h3>
            <p>Dai un nome alla tua lista, scrivi una breve descrizione e scegli una password (ti servirà se vorrai modificare la lista in seguito).</p>
            <h3>Step 2</h3>
            <p>Comincia a inserire gli oggetti che vorresti ricevere.</p>
            <h3>Step 3</h3>
            <p>Nessuno step 3...è tutto qui, davvero!</p>

 </div>
</div>
              <footer>
      <p><a href="<?php echo BASE_SITE;?>">Geeftable</a> is made by <a href="http://www.giovannitufo.com">Giovanni Tufo</a>. You're using the beta version! Thank you and send me a <a href="mailto:joevanni99@gmail.com">feedback</a> if something goes wrong.</p>
      </footer>

    </div> <!-- /container -->
    <script type="text/javascript">
lloogg_clientid = "202002184554b743";
</script>
<script type="text/javascript" src="http://lloogg.com/l.js?c=202002184554b743">
</script>
  </body>
</html>