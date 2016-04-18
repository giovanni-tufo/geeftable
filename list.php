<?php
include("header.php");
$operazione = $_POST['operazione'];
$password = $_POST['password'];
$safepass = escaper($password);
$oggetto = $_POST['oggetto'];
$safeoggetto = escaper($oggetto);
$lista = $_GET['id'];
$list_id = escaper($lista);
$action = $_GET['action'];
switch ($operazione){
    case "login":
        $list_id = escaper($_POST['list_id']);
        $password = $_POST['password'];
        $login = login($list_id,$password);
        $url = $login['url'];
        $status = $login['status'];        
        header("location: " . $url);
        break;
   	case "prenota":
    $list_id = $_POST['id'];
	$passmd5 = md5($safepass);
	$query = "UPDATE oggetti SET password = '$passmd5' WHERE ID = $oggetto";
	esegui_query($query);
        $message = '<div class="alert-message success fade in" data-alert="alert">
  	<a class="close" href="#">×</a>
  <p>Hai scelto di regalare un oggetto!</p>
</div>';
	notifica_prenotazione($oggetto);
	break;
	case "modifica":
 	$list_id = $_POST['id'];
 	$oggetto = $_POST['oggetto'];
 	$nome = $_POST['name'];
	$descrizione = $_POST['descrizione'];
	$prezzo = $_POST['prezzo'];
	$url = $_POST['url'];
    $fileTempName = $_FILES['image']['tmp_name'];
    if (is_logged_in($list_id)){
    $safenome = escaper($nome);
	$safedesc = escaper($descrizione);
	$safeprezzo = escaper($prezzo);
	$safeurl = escaper($url);
    $verifica = getimagesize($fileTempName);
    if ($verifica == FALSE){
 	$query= "UPDATE oggetti SET nome = '$safenome', descrizione = '$safedesc', prezzo = '$safeprezzo', url = '$safeurl' WHERE id = $oggetto";
	esegui_query($query) or die('Problem running query! Error number: error '. mysql_errno() . ": " . mysql_error() );
    }else{
	$query= "UPDATE oggetti SET nome = '$safenome', descrizione = '$safedesc', prezzo = '$safeprezzo', url = '$safeurl', noimg = 0  WHERE id = $oggetto";
	esegui_query($query) or die('Problem running query! Error number: error '. mysql_errno() . ": " . mysql_error() );
	$s3 = new S3(awsAccessKey, awsSecretKey, false);
    $s3->deleteObject(S3_BUCKET, 'images/'. $oggetto . '.jpg' );
	$image = new SimpleImage();
    $image->load($fileTempName);
    $image->resizeToWidth(80);
    $image->save($fileTempName);
    $s3_nuovo = new S3(awsAccessKey, awsSecretKey, false);
 	if ($s3_nuovo->putObjectFile($fileTempName, S3_BUCKET, 'images/'. $oggetto . '.jpg' , S3::ACL_PUBLIC_READ)) {
 	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		}else{
	}

	}
	$message = "<div class=\"alert-message success fade in\" data-alert=\"alert\"><a class=\"close\" href=\"#\">×</a><p>Oggetto modificato! (Se hai caricato una nuova immagine, potrebbe volerci qualche minuto prima che si visualizzi)</p></div>";
    };
 	break; 
	case "lascia":
        $list_id = $_POST['id'];
	$passmd5 = md5($safepass);
	$query_password = "SELECT password FROM oggetti WHERE ID = $safeoggetto";
	$result = esegui_query($query_password);
	$riga = mysql_fetch_row($result);
	if ($passmd5 == $riga[0]){
	$query = "UPDATE oggetti SET password = '' WHERE ID = $safeoggetto";
	esegui_query($query);
	$message = '<div class="alert-message warning fade in" data-alert="alert">
  	<a class="close" href="#">×</a>
  <p>Ora qualcun altro potr&agrave; scegliere di regalare l\'oggetto.</a></p>
</div>';
	notifica_rilascio($safeoggetto);
	}else{
	$message = '<div class="alert-message error fade in" data-alert="alert">
  	<a class="close" href="#">×</a>
  <p>La password che hai inserito non &egrave; corretta.</p>
</div>';
	};
	break;
     case "add-list":
        	$nome = $_POST['nome'];
            $safenome = escaper($nome);
            $descrizione = $_POST['descrizione'];
            $safedesc = escaper($descrizione);
            $password = $_POST['password'];
            $safepassword = escaper($password);
            $passmd5 = md5($safepass);
            $tiny = $_POST['tiny'];
            $safetiny = escaper($tiny);
            $query= "INSERT INTO liste (nome,descrizione,password,status,tiny,spam) VALUES ('$safenome','$safedesc','$passmd5','open', '$safetiny',1)";
            esegui_query($query) or die('Problem running query! Error number: error '. mysql_errno() . ": " . mysql_error() );
            $list_id = mysql_insert_id();
            $link = BASE_SITE . "list.php?id=$list_id";
			$akismet = new Akismet(BASE_SITE,AkismetAPIKey);
			$akismet->setCommentAuthor($safenome);
			$akismet->setCommentAuthorEmail($email);
			$akismet->setCommentAuthorURL($url);
			$akismet->setCommentContent($safedesc);
			$akismet->setPermalink($link);
			if($akismet->isCommentSpam()) {
			die;
			}else{
			$query_nospam = "UPDATE liste SET spam = 0 WHERE id = $list_id";
			esegui_query($query_nospam);
			$session = uniqid();
			$lid = $list_id;
			$ip = $_SERVER['REMOTE_ADDR'];
			set_session($lid,$session,$ip);
			notify_new_list($lid);
            header("location: " . BASE_SITE . "list.php?id=$list_id");
			}      	
	break;
	case "aggiungi":
	$list_id = $_POST['list_id'];
	if (is_logged_in($list_id)){
	$nome = $_POST['nome'];
	$safenome = escaper($nome);
	$descrizione = $_POST['descrizione'];
	$safedesc = escaper($descrizione);
	$prezzo = $_POST['prezzo'];
	$safeprezzo = escaper($prezzo);
	$url = $_POST['url'];
	$safeurl = escaper($url);
    $fileTempName = $_FILES['image']['tmp_name'];
    $verifica = getimagesize($fileTempName);
    if ($verifica == FALSE){
 	$query= "INSERT INTO oggetti (nome,id_lista,descrizione,prezzo,url,noimg) VALUES ('$safenome',$list_id,'$safedesc','$safeprezzo','$safeurl',1)";
	esegui_query($query) or die('Problem running query! Error number: error '. mysql_errno() . ": " . mysql_error() );
    }else{
	$query= "INSERT INTO oggetti (nome,id_lista,descrizione,prezzo,url) VALUES ('$safenome',$list_id,'$safedesc','$safeprezzo','$safeurl')";
	esegui_query($query) or die('Problem running query! Error number: error '. mysql_errno() . ": " . mysql_error() );
	$numero = mysql_insert_id();
	$image = new SimpleImage();
    $image->load($fileTempName);
    $image->resizeToWidth(80);
    $image->save($fileTempName);
    $s3 = new S3(awsAccessKey, awsSecretKey, false);
 	if ($s3->putObjectFile($fileTempName, S3_BUCKET, 'images/'. $numero . '.jpg' , S3::ACL_PUBLIC_READ)) {
		}else{
	}

	}
        $message = "<div class=\"alert-message success fade in\" data-alert=\"alert\"><a class=\"close\" href=\"#\">×</a><p>Oggetto aggiunto!</p></div>";
        };
    break;
       case "shorturl":
        $list_id=escaper($_POST['id']);
        $username=escaper($_POST['username']);
        $message = add_shorturl($list_id,$username);
        break;
      case "edit-list":
      	$list_id = $_POST['list_id'];
      	$nome = $_POST['nome'];
      	$descrizione = $_POST['descrizione'];
      	$email = $_POST['email'];
      	if(is_logged_in($list_id)){
      	edit_list($list_id,$nome,$descrizione,$email);
      	}
      break;
    }
 switch($action){
       case "delete-item":
        $item_id = $_GET['item_id'];
        $message = delete_item($item_id);
        break;
       case "logout":
            session_defaults();
           header("location: " . BASE_SITE);
           break;
    case "short":
    $short = $_GET['short'];
    $safe_short = escaper($short);
    $list_id = short_to_id($short);
    break;
   };
if($list_id == "" || $list_id == "0"){
	header("location: " . BASE_SITE . "404.php");
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="it-IT">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		  <link href="<?php echo BASE_SITE;?>css/bootstrap.min.css" rel="stylesheet">
   		  <link href="<?php echo BASE_SITE;?>css/style.css" rel="stylesheet">

                 <link rel="shortcut icon" href="favicon.ico" >

	   <title><?php titolo_pagina($list_id);?> - Geeftable</title>
<!--[if lte IE 8]>
<script src="./js/html5.js" type="text/javascript"></script>
<![endif]-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js"></script>
	<script src="<?php echo BASE_SITE;?>js/bootstrap-dropdown.js"></script>
	<script src="<?php echo BASE_SITE;?>js/bootstrap-modal.js"></script>
	<script src="<?php echo BASE_SITE;?>js/bootstrap-alerts.js"></script>
	<script src="<?php echo BASE_SITE;?>js/bootstrap-twipsy.js"></script>
	<script src="<?php echo BASE_SITE;?>js/bootstrap-popover.js"></script>
	<script type="text/javascript" src="<?php echo BASE_SITE;?>js/urlcheck.js"></script>
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
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
<script type="text/javascript">stLight.options({publisher: "f408e265-fc62-4707-9632-7c7fcc366810"}); </script>
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
       <?php
   if(is_logged_in($list_id)){
       if (tiny_isset($list_id) == false){
           ?>
           <div id="shorturl" class="modal hide fade">
            <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <h3>Imposta URL</h3>
            </div>

<div class="modal-body">
<p>Scegli l'URL personalizzata usando solo lettere e numeri (niente spazi e caratteri speciali).</p>
<form name="shorturl" action="./list.php" method="POST">
<div class="clearfix"><label for="username">http://www.geeftable.com/</label><div class="input"><input name="username" id="username" type="text" />
<span id="tick">URL disponibile!</span> <span id="cross">URL non disponibile</span></div></div>
<input type="hidden" name="operazione" value="shorturl" />
<input type="hidden" name="id" value="<?php echo $list_id;?>" />
</div>
            <div class="modal-footer">
            <input type="submit" value="Invia" class="add-button" />
</form>
            </div>

                      </div>

     <div class="alert-message warning fade in" data-alert="alert">
  	<a class="close" href="#">×</a>
  <p>Non hai ancora impostato l'URL personalizzata. Se vuoi, <a data-controls-modal="shorturl" data-backdrop="true" data-keyboard="true">puoi farlo ora</a>.</p>
</div>
<?php
       }
       if (get_list_email($list_id) == ""){
       ?>
       <div class="alert-message warning fade in" data-alert="alert">
  	<a class="close" href="#">×</a>
  <p><strong>Lo sapevi?</strong> Puoi ricevere un'email quando i tuoi regali vengono prenotati. Aggiungila nelle <a href="#" data-controls-modal="edit-list" data-backdrop="true" data-keyboard="true">impostazioni</a> della tua lista.</p>
</div><?php
       }; ?>
<?php }?>
<?php echo $message; ?>
<div class="row">
        <div id="wishlist" class="span12">
        <h1><?php titolo_lista($list_id);?></h1>
        <p id="list-description"><?php desc_lista($list_id);?></p>


<p><?php form_aggiungi($list_id); ?></p>

<?php mostra_lista($list_id);?>

<p><a href="mailto:?body=<?php echo get_url($list_id); ?>&subject=<?php titolo_pagina($list_id);?>">Condividi</a> questa lista usando il link pubblico: <span class="link"><?php echo get_url($list_id);?>
</span></p>
</div>
        <div id="instructions" class="span4">
        <?php
   if(is_logged_in($list_id)){
   ?>
        <h2>Bookmarklet</h2>
        <p>Trascina il bottone qui sotto nella tua barra dei segnalibri.
        <a href="javascript:location.href='http://www.geeftable.com/adb.php?id=<?php echo $list_id; ?>&url='+encodeURIComponent(location.href)+'&title='+encodeURIComponent(document.title);" class="btn" rel="popover" data-content="I <em>bookmarklet</em> sono dei segnalibri che, una volta inseriti nella barra dei segnalibri del tuo browser, ti permettono di aggiungere velocemente oggetti alla tua lista. Per usarli, trascina questo pulsante nella tua barra dei segnalibri e clicca sul segnalibro quando sei sulla pagina di un oggetto che vorresti. Verrai indirizzato su Geeftable (potresti dover inserire la tua password) e i campi URL e Nome saranno già pronti. Alla fine dell'inserimento, verrai riportato alla pagina che stavi visitando, così potrai continuare la tua navigazione." data-original-title="Cos'è un bookmarklet?">Aggiungi a <?php titolo_lista($list_id);?></a>
        <script>
            $(function () {
              $("a[rel=popover]")
                .popover({
                  offset: 10,
                  placement: 'below',
                  html: true
                })
                .click(function(e) {
                  e.preventDefault()
                })
            })
            </script>
          </p> <?php
   };
       ?>           <h2>Come funziona?</h2>
            <p>&Egrave; semplice: qui a fianco ci sono una serie di oggetti. Se scorrendo la lista trovate un oggetto che volete regalare, potete "prenotarvi" inserendo una password. Non preoccupatevi, le password vengono criptate prima di essere memorizzate (in pratica diventano una cosa del tipo: fi3f35foskvndfewfw), cos&igrave; non è possibile risalire a chi ha prenotato. Se ci ripensate potete sempre inserire la password di nuovo e "sprenotarvi".</p>
            <h2>Share!</h2>
            <p><span class='st_facebook_vcount' displayText='Facebook'></span>
<span class='st_twitter_vcount' displayText='Tweet'></span>
<span class='st_delicious_vcount' displayText='Delicious'></span>
<span class='st_pinterest_vcount' displayText='Pinterest'></span>
<span class='st_plusone_vcount' displayText='Google +1'></span>
<span class='st_email_vcount' displayText='Email'></span></p>       </div>
      </div>

         <footer>
      <p><a href="<?php echo BASE_SITE;?>">Geeftable</a> is made by <a href="http://www.giovannitufo.com">Giovanni Tufo</a>. You're using the beta version! Thank you and send me a <a href="mailto:joevanni99@gmail.com">feedback</a> if something goes wrong. <a href="http://www.iubenda.com/privacy-policy/746061" class="iubenda-white iubenda-embed" title="Privacy Policy">Privacy Policy</a><script type="text/javascript">(function (w,d) {var loader = function () {var s = d.createElement("script"), tag = d.getElementsByTagName("script")[0]; s.src = "http://cdn.iubenda.com/iubenda.js"; tag.parentNode.insertBefore(s,tag);}; if(w.addEventListener){w.addEventListener("load", loader, false);}else if(w.attachEvent){w.attachEvent("onload", loader);}else{w.onload = loader;}})(window, document);</script>
</p>
      </footer>
        </div>
        <script type="text/javascript">
lloogg_clientid = "202002184554b743";
</script>
<script type="text/javascript" src="http://lloogg.com/l.js?c=202002184554b743">
</script>
<script type="text/javascript" src="http://s.skimresources.com/js/26969X856046.skimlinks.js"></script>
    </body>
</html>