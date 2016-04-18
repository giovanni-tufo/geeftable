<?php
include("header.php");
$url = escaper($_GET['url']);
$title = escaper($_GET['title']);
$list_id = $_GET['id'];
$operazione = $_POST['operazione'];
switch ($operazione){
        case "login":
        $list_id = escaper($_POST['list_id']);
        $password = $_POST['password'];
        $url = escaper($_POST['url']);
        $title = escaper($_POST['title']);
        $message = login($list_id,$password);
        header("location: ". BASE_SITE . "adb.php?id=$list_id&url=$url&title=$title");
        break;
    	case "aggiungi":
	$list_id = $_POST['list_id'];
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
        header("location: " . $safeurl);
    break;
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
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
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
</head>
    <body>
<div class="container_12 clearfix" id="wrapper">
<div class="grid_12 clearfix" id="blog-title">
    <h1><a href="<?php echo BASE_SITE;?>">Geeftable</a> <span class="beta">(beta)</span></h1>

</div>
<section class="grid_9 clearfix" id="content">
<h2><?php titolo_lista($list_id);?></h2>
<p><?php desc_lista($list_id);?></p>
<?php form_aggiungi_da_bookmarklet($list_id,$url,$title); ?>

</section>
</div>
        <footer class="container_12 clearfix" id="footer">
            	<p><a href="<?php echo BASE_SITE;?>">Geeftable</a> &egrave; un'idea di <a href="http://www.giovannitufo.com">Giovanni Tufo</a>. Stai usando la versione beta! Grazie e non dimenticare di mandarmi un <a href="mailto:joevanni99@gmail.com">feedback</a> se qualcosa non funziona come dovrebbe.</p>
        </footer>
        <script type="text/javascript">
lloogg_clientid = "202002184554b743";
</script>
<script type="text/javascript" src="http://lloogg.com/l.js?c=202002184554b743">
</script>
    </body>
</html>