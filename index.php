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

	   <title>Geeftable</title>
	   
	   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	   <script src="./js/bootstrap-dropdown.js"></script>
	   <script src="./js/bootstrap-modal.js"></script>
	   <script src="./js/bootstrap-twipsy.js"></script>
	   <script src="./js/bootstrap-popover.js"></script>
	   <script src="./js/jquery.jshowoff.min.js"></script>
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
<script type="text/javascript">var switchTo5x=true;</script><script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script><script type="text/javascript">stLight.options({publisher:'f408e265-fc62-4707-9632-7c7fcc366810'});</script>
    </head>
    <body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1&appId=176026742478555";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
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

      <!-- Main hero unit for a primary marketing message or call to action -->
      <div class="row" style="height: 280px; overflow:hidden">
      <div class="hero-unit">
      <img src="./images/red.png" style="float:left;margin-right: 15px;" />
        <h1>Stop unwanted gifts!</h1>
        
        <p>Geeftable allows you to create your wishlist in a <em>fast</em> and <em>easy</em> way, and share it with your friends.</p>
        <div id="newlist" class="modal hide fade">
        <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <h3>Create your list</h3>
            </div>
<form name="aggiungi" action="./list.php" method="POST">
<div class="modal-body">
      <div class="clearfix"><label for="nome">List Name</label><div class="input"><input type="text" name="nome" id="nome" size="18" /></div></div>
      <div class="clearfix"><label for="descrizione">Description</label><div class="input"><textarea rows="5" name="descrizione" id="descrizione"> </textarea></div></div>
     <div class="clearfix"><label for="password">Password</label><div class="input"><input type="password" name="password" id="password" size="18" /></div></div>
<input type="hidden" name="operazione" value="add-list" />


             
             
</div>
            <div class="modal-footer">
            <input type="submit" value="Create your list &raquo;" class="btn primary" />
         
            </div>
               </form>

                      </div>
            <button data-controls-modal="newlist" data-backdrop="true" data-keyboard="true" class="btn danger large">Write down your wishlist now &raquo;</button>
      </div>
             </div>
<script type="text/javascript">		
	$(document).ready(function(){ $('#features').jshowoff({ controls:false, links:false, speed: 5000, effect: 'fade'}); });
</script>


      <div class="row">
        <div class="span6">
            <h2 class="sidebar-caption">How does it work?</h2>
            <h3>Step 1</h3>
            <p>Name your list, write a short description and choose a password (you'll need it to edit your wishlist).</p>
            <h3>Step 2</h3>
            <p>Write down what you want to receive.</p>
            <h3>Step 3</h3>
            <p>Sorry, no step 3 … that's all!</p>          <p>
            <button data-controls-modal="newlist" data-backdrop="true" data-keyboard="true" class="btn">Create your list &raquo;</button></p>
        </div>
        <div class="span5">
          <h2>Latest wishes</h2>
           <?php latest_objects(); ?>
          <p><a class="btn" href="./all_items.php">View all <?php count_items();?> items &raquo;</a></p>
          <script>
            $(function () {
              $("a[rel=twipsy]").twipsy({
                live: true
              })
            })
          </script>
       </div>
        <div class="span5">
          <h2>Who's on Geeftable</h2>
          <?php latest_lists(); ?>
          <p><a class="btn" href="./all_lists.php">View all <?php count_lists(); ?> lists &raquo;</a></p>
        </div>
      </div>
      <div class="row">
      <div class="span16">
      <div class="fb-like-box" data-href="http://www.facebook.com/ilfamosositodilisteregali" data-width="940" data-show-faces="false" data-border-color="#fff" data-stream="true" data-header="false"></div></div>
      <div class="span16">
       <p><span class='st_facebook_vcount' displayText='Facebook'></span>
<span class='st_twitter_vcount' displayText='Tweet'></span>
<span class='st_delicious_vcount' displayText='Delicious'></span>
<span class='st_pinterest_vcount' displayText='Pinterest'></span>
<span class='st_plusone_vcount' displayText='Google +1'></span>
<span class='st_email_vcount' displayText='Email'></span></p>
      </div>
      </div>

      <footer>
      <p><a href="<?php echo BASE_SITE;?>">Geeftable</a> is made by <a href="http://www.giovannitufo.com">Giovanni Tufo</a>. You're using the beta version! Thank you and send me a <a href="mailto:joevanni99@gmail.com">feedback</a> if something goes wrong. <a href="http://www.iubenda.com/privacy-policy/746061" class="iubenda-white iubenda-embed" title="Privacy Policy">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "http://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>
</p>
      </footer>

    </div> <!-- /container -->
    <script type="text/javascript">
lloogg_clientid = "202002184554b743";
</script>
<script type="text/javascript" src="http://lloogg.com/l.js?c=202002184554b743">
</script>
  </body>
</html>