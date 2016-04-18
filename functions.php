<?php
function esegui_query($query) {
$link = mysql_connect(SERVER_DB, USER_DB, PASS_DB);
mysql_select_db(NAME_DB, $link);
$result = mysql_query($query, $link);
return $result;
}

function escaper($parameter){
$link = mysql_connect(SERVER_DB, USER_DB, PASS_DB);
$safe = mysql_real_escape_string($parameter);
return $safe;
}

function connection_error(){
include('error.php');
}

function titolo_lista($id){
$query = "SELECT nome,password FROM liste WHERE ID = $id";
$result = esegui_query($query);
$riga = mysql_fetch_row($result);
echo stripslashes($riga[0]);
}

function get_titolo_lista($id){
$query = "SELECT nome,password FROM liste WHERE ID = $id";
$result = esegui_query($query);
$riga = mysql_fetch_row($result);
return stripslashes($riga[0]);
}

function titolo_pagina($id){
$query = "SELECT nome FROM liste WHERE ID = $id";
$result = esegui_query($query);
$riga = mysql_fetch_row($result);
echo htmlentities(stripslashes($riga[0]));
}

function desc_lista($id){
$query = "SELECT descrizione,password FROM liste WHERE ID = $id";
$result = esegui_query($query);
$riga = mysql_fetch_row($result);
echo stripslashes($riga[0]);
}

function mostra_lista($id){
$query = "SELECT * FROM oggetti WHERE id_lista = $id ORDER BY ID";
$result = esegui_query($query);
while ($riga = mysql_fetch_array($result)){
?>
<div class="item">
<h2><?php echo htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');?></h2>
<div class="row">
<div class="image span2"><img src="<?php
 if($riga['noimg'] == 1){
 echo BASE_SITE . "images/noimg.png";
 }else{
 echo S3_URL . $riga['ID'] . ".jpg";
 }
 ?>" alt="<?php echo htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');?>" /></div>
<div class="description span10">
<p><?php echo htmlentities(stripslashes($riga['descrizione']),ENT_COMPAT,'UTF-8');
?></p>
<ul class="unstyled">
<?php if ($riga['prezzo'] != ""){?>
<li><span class="label">Price:</span> <?php echo htmlentities(stripslashes($riga['prezzo']),ENT_COMPAT,'UTF-8');?></li>
<?php };
if ($riga['url'] != ""){ ?>
<li><span class="label">URL:</span> <a href="<?php echo htmlentities($riga['url'],ENT_COMPAT,'UTF-8');?>"><?php echo htmlentities($riga['url'],ENT_COMPAT,'UTF-8');?></a></li>
<?php };
?>
</ul>
            
<div class="panel">
<?php
if ($riga['password'] == ""){
$form_action = "prenota";
$form_description = "Nessuno ha scelto di regalare questo oggetto. Puoi farlo tu inserendo una password (che ti permetter&agrave; di ripensarci!)";
$button = "<button data-controls-modal=\"password-" . $riga['ID'] . "\" data-backdrop=\"true\" data-keyboard=\"true\" class=\"btn success\">Prenota</button>";
}else{
$form_action = "lascia";
$form_description = "Qualcuno ha scelto questo oggetto. Se sei tu e non vuoi pi&ugrave; regalarlo, inserisci la password.";
$button = "<button data-controls-modal=\"password-" . $riga['ID'] . "\" data-backdrop=\"true\" data-keyboard=\"true\" class=\"btn booked\">Prenotato</button>";
};
?>
<div id="password-<?php echo $riga['ID']; ?>" class="modal hide fade">
            <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <h3>Prenota</h3>
            </div>
<form name="prenotazione" action="<?php echo get_url($id); ?>" method="POST">
<div class="modal-body">
              <p><?php echo $form_description; ?></p>
<div class="clearfix"><label for="password-<?php echo $riga['ID']; ?>">Password:</label><div class="input"><input type="password" name="password" id="password-<?php echo $riga['ID']; ?>" size="18" /></div></div> 
<input type="hidden" name="operazione" value="<?php echo $form_action; ?>" />
<input type="hidden" name="oggetto" value="<?php echo $riga['ID']; ?>" />
<input type="hidden" name="id" value="<?php echo $id;?>" />

</div>
            <div class="modal-footer">
            <input type="submit" value="Invia" class="btn primary" />
            </div>
            </form>

                      </div>

          <?php echo $button; ?>


<?php
if (is_logged_in($id)){
?>
<div id="edit-<?php echo $riga['ID']; ?>" class="modal hide fade">
            <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <h3>Modifica</h3>
            </div>
<form name="modifica" action="<?php echo get_url($id); ?>" method="POST" enctype="multipart/form-data">    
<div class="modal-body">          
<div class="clearfix"><label for="name-<?php echo $riga['ID']; ?>">Oggetto:</label> <div class="input"><input type="text" name="name" id="name-<?php echo $riga['ID']; ?>" size="18" value ="<?php echo $riga['nome']; ?>" /></div></div>
<div class="clearfix"><label for="descrizione-<?php echo $riga['ID']; ?>">Descrizione:</label> <div class="input"><textarea type="text" name="descrizione" id="descrizione-<?php echo $riga['ID']; ?>" row="3"><?php echo $riga['descrizione']; ?></textarea></div></div>
<div class="clearfix"><label for="prezzo-<?php echo $riga['ID']; ?>">Prezzo:</label><div class="input"><input type="text" name="prezzo" id="prezzo-<?php echo $riga['ID']; ?>" size="18" value ="<?php echo $riga['prezzo']; ?>"/></div></div>
<div class="clearfix"><label for="url-<?php echo $riga['ID']; ?>">URL:</label> <div class="input"><input type="text" name="url" id="url-<?php echo $riga['ID']; ?>" size="18" value="<?php echo $riga['url']; ?>"/></div></div>
<div class="clearfix"><label for="immagine-<?php echo $riga['ID']; ?>"><img src="<?php echo S3_URL . $riga['ID'];?>.jpg" alt="<?php echo htmlentities(stripslashes($riga['nome']));?>" /></label> <div class="input"><input type="file" name="image" id="image-<?php echo $riga['ID']; ?>" size="18"/></div></div>
<input type="hidden" name="operazione" value="modifica" />
<input type="hidden" name="oggetto" value="<?php echo $riga['ID']; ?>" />
<input type="hidden" name="id" value="<?php echo $id; ?>" />
</div>
            <div class="modal-footer">
            <input type="submit" value="Modifica" class="btn primary" />
          
            </div>
  </form>
                      </div>

          <button data-controls-modal="edit-<?php echo $riga['ID']; ?>" data-backdrop="true" data-keyboard="true" class="btn">Modifica</button>
          <a href="list.php?action=delete-item&id=<?php echo $id; ?>&item_id=<?php echo $riga['ID']; ?>" class="btn danger delete">Elimina</a> 
<?php }; ?>
         </div>
</div>
</div>
</div>
<?php
}
}

function form_aggiungi($list_id){

if (is_logged_in($list_id)){
?>
<div id="aggiungi" class="modal hide fade">
            <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <h3>Aggiungi un oggetto</h3>
            </div>
<form name="aggiungi" action="<?php echo get_url($list_id); ?>" method="POST" enctype="multipart/form-data">
<div class="modal-body">

<div class="clearfix"><label for="nome">Oggetto:</label><div class="input"><input type="text" name="nome" id="nome" size="18" /></div></div>
<div class="clearfix"><label for="descrizione">Descrizione:</label><div class="input"><textarea type="text" name="descrizione" id="descrizione" row="5"/></textarea></div></div>
<div class="clearfix"><label for="prezzo">Prezzo:</label><div class="input"><input type="text" name="prezzo" id="prezzo" size="18" /></div></div>
<div class="clearfix"><label for="url">URL:</label><div class="input"><input type="text" name="url" id="url" size="18" /></div></div> 
<div class="clearfix"><label for="image">Immagine:</label><div class="input"><input name="image" id="image" type="file" size="18" /></div></div> 
<input type="hidden" name="list_id" value="<?php echo $list_id; ?>" />
<input type="hidden" name="operazione" value="aggiungi" />
</div>
            <div class="modal-footer">
            <input type="submit" value="Aggiungi" class="btn primary" />
            
            </div>
</form>
                      </div>

          <button data-controls-modal="aggiungi" data-backdrop="true" data-keyboard="true" class="btn">Nuovo oggetto</button>
<?php
}
}

function form_aggiungi_da_bookmarklet($list_id, $url, $title){
 $query = "SELECT password FROM liste WHERE ID = $list_id";
$result = esegui_query($query);
$riga = mysql_fetch_row($result);
if (is_logged_in($list_id)){
?>
<h3>Aggiungi un oggetto</h3>
<form name="aggiungi" action="adb.php" method="POST" enctype="multipart/form-data">
    <table>
    <tbody>
        <tr valign="top">
            <th scope="row"><label for="nome">Oggetto:</label></th><td><input type="text" name="nome" id="nome" size="18" value="<?php echo $title; ?>"/></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="descrizione">Descrizione:</label></th><td><input type="text" name="descrizione" id="descrizione" size="18"/></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="prezzo">Prezzo:</label></th><td><input type="text" name="prezzo" id="prezzo" size="18" /></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="url">URL:</label></th><td><input type="text" name="url" id="url" size="18" value="<?php echo $url;?>"/></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="image">Immagine:</label></th><td><input name="image" id="image" type="file" size="18" /></td>
        </tr>
   </tbody>
    </table>
<input type="hidden" name="list_id" value="<?php echo $list_id; ?>" />
<input type="hidden" name="operazione" value="aggiungi" />
<input type="submit" value="Aggiungi" />
</form>
<?php
}else{
    ?>
<h3>Effettua il login</h3>
  <form name="login" action="adb.php" method="POST">
<label for="password">Password:</label> <input type="password" name="password" id="password" class="pass-input" size="18" />
<input type="hidden" name="list_id" value="<?php echo $list_id; ?>" />
<input type="hidden" name="url" value="<?php echo $url; ?>" />
<input type="hidden" name="title" value="<?php echo $title; ?>" />
<input type="hidden" name="operazione" value="login" />
<input type="submit" value="Invia" class="pass-button" />
</form><?php
}
}

function delete_item($item_id){
 $query = "SELECT liste.ID FROM liste, oggetti WHERE oggetti.ID = $item_id AND liste.ID = oggetti.id_lista";
$result = esegui_query($query);
$riga = mysql_fetch_row($result);
$list_id = $riga[0];
if (is_logged_in($list_id)){
    $item = escaper($item_id);
    $query="DELETE FROM oggetti WHERE ID = $item";
    esegui_query($query);
    $s3 = new S3(awsAccessKey, awsSecretKey, false);
    $s3->deleteObject(S3_BUCKET, 'images/'. $item_id . '.jpg' );
    $message = "<div class=\"alert-message success fade in\" data-alert=\"alert\"><a class=\"close\" href=\"#\">×</a><p>Oggetto eliminato!</p></div>";
    }else{
    $message = "<div class=\"alert-message error fade in\" data-alert=\"alert\"><a class=\"close\" href=\"#\">×</a><p>Non sei autorizzato!</p></div>";
    }
    return $message;
}

function update_item($oggetto,$lista,$nome,$descrizione,$prezzo,$url,$fileTempName){
	
	$safenome = escaper($nome);
	$safedesc = escaper($descrizione);
	$safeprezzo = escaper($prezzo);
	$safeurl = escaper($url);
	
    $verifica = getimagesize($fileTempName);
    if ($verifica == FALSE){
 	$query= "UPDATE oggetti SET nome = '$safenome', descrizione = '$safedesc', prezzo = '$safeprezzo', url = '$safeurl' WHERE id = $oggetto";
	esegui_query($query) or die('Problem running query! Error number: error '. mysql_errno() . ": " . mysql_error() );
    }else{
	$query= "UPDATE oggetti SET nome = '$safenome', descrizione = '$safedesc', prezzo = '$safeprezzo', url = '$safeurl', noimg = 0 WHERE id = $oggetto";
	esegui_query($query) or die('Problem running query! Error number: error '. mysql_errno() . ": " . mysql_error() );
	$s3 = new S3(awsAccessKey, awsSecretKey, false);
    $s3->deleteObject(S3_BUCKET, 'images/'. $oggetto . '.jpg' );
	$image = new SimpleImage();
    $image->load($fileTempName);
    $image->resizeToWidth(80);
    $image->save($fileTempName);
    $s3_nuovo = new S3(awsAccessKey, awsSecretKey, false);
 	if ($s3_nuovo->putObjectFile($fileTempName, S3_BUCKET, 'images/'. $oggetto . '.jpg' , S3::ACL_PUBLIC_READ)) {
		}else{
	}

	}
	echo "<!-- $query -->";
	$message = "<div class=\"alert-message success fade in\" data-alert=\"alert\"><a class=\"close\" href=\"#\">×</a><p>Oggetto modificato!</p></div>";
    return $message;

}

function login_bar() {
if (check_session() == true){
    $list_id = $_SESSION['lid'];
    ?>
<li><a href="<?php echo get_url($list_id);?>">View your list</a></li>
<li><?php edit_list_form($list_id); ?></li>
<li><a href="list.php?id=<?php echo $list_id; ?>&action=logout">Logout</a></li>
    <?php
}else{
?>
<div id="login-box" class="modal hide fade">
        <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <h3>Login</h3>
            </div>
<form name="login" action="./list.php" method="POST" class="form-stacked">
<div class="modal-body">
      <div class="clearfix"><label for="nome">Shortname or List ID</label><div class="input"><input type="text" name="list_id" id="list" size="18" /></div></div>
     <div class="clearfix"><label for="password">Password</label><div class="input"><input type="password" name="password" id="login-pwd" size="18" /></div></div>
<input type="hidden" name="operazione" value="login" />             
</div>
            <div class="modal-footer">
            <input type="submit" value="Login" class="btn primary" />
          
            </div>
  </form>
                      </div>
       <li><a href="#" data-controls-modal="login-box" data-backdrop="true" data-keyboard="true">Login</a></li>
   </li>
<?php
}

}

function login($list_id,$password){
    $query = "SELECT id, password FROM liste WHERE ID = '$list_id' OR tiny LIKE '$list_id'";
    $result = esegui_query($query);
    $riga = mysql_fetch_row($result);
    $passmd5 = md5($password);
    if ($passmd5 == $riga[1]){
	$session = uniqid();
	$lid = $riga[0];
	$ip = $_SERVER['REMOTE_ADDR'];
	set_session($lid,$session,$ip);
	$url = BASE_SITE . "list.php?id=" . $lid;
    $login = array('id' => $riga[0], 'status' => 1, 'url' => $url);
    }else{
    $url = BASE_SITE;
    $login = array('id' => $riga[0], 'status' => 0, 'url' => $url);
    } 
    return $login;
}

function is_logged_in($list_id){
	$logged = check_session();
    if($logged == true){
    if($list_id == $_SESSION['lid'])
    return true;
    }else{
    return false;
    }
}

function latest_lists(){


   $query = "SELECT l.ID, l.nome, l.descrizione, count( o.id_lista ) FROM oggetti o INNER JOIN liste l ON l.id = o.id_lista GROUP BY o.id_lista ORDER BY count(o.id_lista) DESC LIMIT 6";
   $result = esegui_query($query);
  ?><ul class="unstyled"><?php
while ($riga = mysql_fetch_array($result)){
    ?><li><strong><a href="<?php echo get_url($riga['ID']);?>"><?php echo stripslashes($riga['nome']);?></a></strong> (<?php list_count_items($riga['ID']); ?>) <?php echo stripslashes($riga['descrizione']); ?></li><?php
}
?></ul><?php
}

function latest_objects(){
$query = "SELECT ID, id_lista, nome, noimg FROM oggetti ORDER BY ID DESC LIMIT 6";
$result = esegui_query($query);
?>
<ul class="media-grid">
<?php
while ($riga = mysql_fetch_array($result)){
    ?><li><a href="<?php echo get_url($riga['id_lista']);?>" rel="twipsy" data-original-title="<?php echo htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');?>"><img class="thumbnail" src="
    <?php
 if($riga['noimg'] == 1){
 echo BASE_SITE . "images/noimg.png";
 }else{
 echo S3_URL . $riga['ID'] . ".jpg";
 }
 ?>" alt="<?php echo htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');?>" /></a></li>
<?php  }
?></ul>
<?php
}

function crea_feed($id){
 $query = "SELECT * FROM oggetti WHERE id_lista = $id ORDER BY ID DESC";
$result = esegui_query($query);
while ($riga = mysql_fetch_array($result)){
?>
<item>
<title><?php echo htmlentities(stripslashes($riga['nome']));?></title>
<description>
&lt;img src="<?php echo S3_URL . $riga['ID']; ?>.jpg" alt="<?php echo htmlentities(stripslashes($riga['nome']));?>" /&gt;
&lt;p&gt;<?php echo stripslashes($riga['descrizione']);?>&lt;/p&gt;
&lt;ul&gt;
&lt;li&gt;Prezzo: <?php echo htmlentities(stripslashes($riga['prezzo']));?>&lt;/li&gt;
&lt;li&gt;URL: &lt;a href="<?php echo htmlentities($riga['url']);?>"&gt;<?php echo htmlentities($riga['url']);?>&lt;/a&gt;&lt;/li&gt;
&lt;/ul&gt;
</description>
</item>
<?php
}
}

function count_lists(){
 $query = "SELECT COUNT(*) FROM liste WHERE spam = 0";
   $result = esegui_query($query);
   $riga = mysql_fetch_row($result);
   echo $riga[0];
}

function count_items(){
 $query = "SELECT COUNT(*) FROM oggetti";
   $result = esegui_query($query);
      $riga = mysql_fetch_row($result);
   echo $riga[0];
}


function list_count_items($id){
 $query = "SELECT COUNT(*) FROM oggetti WHERE id_lista = $id";
   $result = esegui_query($query);
      $riga = mysql_fetch_row($result);
   echo $riga[0];
}


function all_lists(){
   $query = "SELECT ID, nome, descrizione FROM liste WHERE spam = 0 ORDER BY ID";
   $result = esegui_query($query);
  ?><ul><?php
while ($riga = mysql_fetch_array($result)){
    ?><li><strong><a href="<?php echo get_url($riga['ID']);?>"><?php echo stripslashes($riga['nome']);?></a></strong> (<?php list_count_items($riga['ID']); ?>) <?php echo stripslashes($riga['descrizione']); ?></li><?php
}
?></ul><?php
}

function all_items(){
$query = "SELECT * FROM oggetti ORDER BY ID DESC";
$result = esegui_query($query);
while ($riga = mysql_fetch_array($result)){
?>
<div class="item">
<h2><?php echo htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');?><br /><small>da <a href="<?php echo get_url($riga['id_lista']); ?>"><?php echo titolo_lista($riga['id_lista']); ?></a></small></h2>
<div class="row">
<div class="image span2"><img src="<?php echo S3_URL . $riga['ID'];?>.jpg" alt="<?php echo htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');?>" /></div>
<div class="description span10">
<p><?php echo htmlentities(stripslashes($riga['descrizione']),ENT_COMPAT,'UTF-8');
?></p>
<ul class="unstyled">
<?php if ($riga['prezzo'] != ""){?>
<li><span class="label">Price:</span> <?php echo htmlentities(stripslashes($riga['prezzo']),ENT_COMPAT,'UTF-8');?></li>
<?php };
if ($riga['url'] != ""){ ?>
<li><span class="label">URL:</span> <a href="<?php echo htmlentities($riga['url'],ENT_COMPAT,'UTF-8');?>"><?php echo htmlentities($riga['url'],ENT_COMPAT,'UTF-8');?></a></li>
<?php };
?>
</ul>
     </div></div>                          </div>
<?php
}
}

function short_to_id($short){
   $query = "SELECT ID FROM liste WHERE tiny = '$short'";
   $result = esegui_query($query);
   $riga = mysql_fetch_row($result);
   return $riga[0];
}

function add_shorturl($id,$username){
if (is_logged_in($id)){
	$sanitized_url = friendly_url($username);
    $query = "UPDATE liste SET tiny ='$sanitized_url' where ID='$id'";
    esegui_query($query);
    $message = "<div class=\"alert-message success fade in\" data-alert=\"alert\"><a class=\"close\" href=\"#\">×</a><p>URL personalizzata aggiornata!</p></div>";
    }else{
    $message = "<div class=\"alert-message success fade in\" data-alert=\"alert\"><a class=\"close\" href=\"#\">×</a><p>Non sei autorizzato!</p></div>";
    }
    return $message;
}
function friendly_url($url) {
	// everything to lower and no spaces begin or end
	$url = strtolower(trim($url));
 
	//replace accent characters, depends your language is needed
	$url=replace_accents($url);
 
	// decode html maybe needed if there's html I normally don't use this
	$url = html_entity_decode($url,ENT_QUOTES,'UTF8');
 
	// adding - for spaces and union characters
	$find = array(' ', '&', '\r\n', '\n', '+',',');
	$url = str_replace ($find, '-', $url);
 
	//delete and replace rest of special chars
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);
 
	//return the friendly url
	return $url; 
}

function replace_accents($var){ //replace for accents catalan spanish and more
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ', 'ĳ', 'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ', 'œ', 'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ', 'ǽ', 'Ǿ', 'ǿ'); 
    $b = array('A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'Y', 's', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o'); 
    $var= str_replace($a, $b,$var);
    return $var; 
}

function tiny_isset($list_id){
    $query = "SELECT tiny FROM liste WHERE ID = '$list_id' LIMIT 1";
    $result = esegui_query($query);
    $riga = mysql_fetch_row($result);
    if ($riga[0] != ''){
        return $riga[0];
    }else {
        return false;
    }
}

function get_url($list_id){
    $url = BASE_SITE;
$tiny = tiny_isset($list_id);
if ($tiny != false){
    $url .= $tiny;
}else{
$url .= "list.php?id=" . $list_id;
}
return $url;
}

//Login con sessions
function session_defaults() {
 $_SESSION['logged'] = false;
 $_SESSION['lid'] = 0;
 $_SESSION['sid'] = '';
}

function set_session($lista,$session,$ip){
$query = "UPDATE liste SET session = '$session', ip = '$ip' WHERE ID = $lista";
esegui_query($query);
 $_SESSION['logged'] = true;
 $_SESSION['lid'] = $lista;
 $_SESSION['sid'] = $session;
}

function check_session(){
$lista = $_SESSION['lid'];
$ip = $_SERVER['REMOTE_ADDR'];
$session = $_SESSION['sid'];
$query = "SELECT * from liste WHERE session = '$session' AND id = '$lista' AND ip = '$ip'";
$result = esegui_query($query);
$rows = mysql_num_rows($result);
if($rows == 1){
	return TRUE;
}else{
	return FALSE;
}
}

function edit_list_form($list_id){
if (is_logged_in($list_id)){
?>
<div id="edit-list" class="modal hide fade">
            <div class="modal-header">
              <a href="#" class="close">&times;</a>
              <h3>Modifica Lista</h3>
            </div>
<form name="modifica" action="<?php echo get_url($id); ?>" method="POST">
<div class="modal-body">
<div class="clearfix"><label for="nome">Nome della lista:</label><div class="input"><input type="text" name="nome" id="nome" size="18" value="<?php echo titolo_lista($list_id);?>"/></div></div>
<div class="clearfix"><label for="descrizione">Descrizione:</label><div class="input"><textarea type="text" name="descrizione" id="descrizione" row="5"/><?php echo desc_lista($list_id); ?></textarea></div></div>
<div class="clearfix"><label for="email">Email:</label><div class="input"><input type="text" name="email" id="email" size="18" value="<?php echo get_list_email($list_id);?>"/></div></div>
<input type="hidden" name="list_id" value="<?php echo $list_id; ?>" />
<input type="hidden" name="operazione" value="edit-list" />
</div>
            <div class="modal-footer">
            <input type="submit" value="Modifica" class="btn primary" />
           
            </div>
 </form>
                      </div>

          <a href="#" data-controls-modal="edit-list" data-backdrop="true" data-keyboard="true">List settings</a>
<?php
}
}
function edit_list($id,$nome,$descrizione,$email){
	$safenome = escaper($nome);
	$safedesc = escaper($descrizione);
	$safemail = escaper($email);
	$query = "UPDATE liste SET nome = '$safenome', descrizione = '$safedesc', email = '$safemail' WHERE id = $id";
	esegui_query($query);
	$url = get_url($id);
	header("location: " . $url);
}

function notify_new_list($lid) {

include("class.phpmailer.php");
include("class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$text ="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional //EN\">" . "\r\n" ;
$text .= "<html>" . "\r\n" ;
$text .= "<head>" . "\r\n" ;
$text .= "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">" . "\r\n" ;
$text .= "<title>Geeftable</title>" . "\r\n" ;
$text .= "</head>" . "\r\n" ;
$text .= "<body style=\"font-family: 'Helvetica Neue', Helvetica, Arial," . "\r\n" ;
$text .= "sans-serif; background:#f1f1f1; padding:25px auto;\">". "\r\n" ;
$text .= "<table style=\"border: 1px solid #ccc;width:600px;margin:35px auto 3px" ."\r\n" ;
$text .= "auto;background: #fff\" cellpadding=\"0\" cellspacing=\"0\">" . "\r\n" ;
$text .= "<tr style=\"background: #db3300; color: #fff;\">" . "\r\n" ;
$text .= "<td style=\"padding: 6px; font-size:20px\">Geeftable</td></tr>" . "\r\n" ;
$text .= "<tr><td style=\"padding: 6px;\"><p><b>Nuova lista</b></p>" . "\r\n" ;
$text .= "<p style=\"font-size: 14px\">&Egrave; stata creata una nuova lista:" . "\r\n" ;
$text .= "<a href=\"" . get_url($lid ) . "\" style=\"color:#db3300\">" . "\r\n"  . get_titolo_lista($lid) . "</a></p></td></tr>" . "\r\n" ;
$text .= "<tr><td><a href=\"". BASE_SITE . "/b7435b722c8a57c00ee5a2dcd05c62a3.php?key=204eed2f74a58c4a9a08edc6e312187d&lid=" . $lid . "\" style=\"color:#db3300\">" . "\r\n Segnala come SPAM</a></p></td></tr>" . "\r\n" ;
$text .= "</table>" . "\r\n" ;
$text .= "<table style=\"width:600px;margin:3px auto;\" cellpadding=\"0\" " . "\r\n" ;
$text .= "cellspacing=\"0\">" . "\r\n" ;
$text .= "<tr><td style=\"color:#888; font-size: 10px\">Questo &egrave; un " . "\r\n" ;
$text .= "messaggio automatico. Non rispondere a questa email.</td></tr>" . "\r\n" ;
$text .= "</table></body></html>";

$mail             = new PHPMailer();

$mail->SetFrom("joevanni99@gmail.com","Geeftable");
$mail->Subject    = "Nuova lista: #$lid " . get_titolo_lista($lid);
$mail->AltBody    = "Nuova lista: #$lid " . get_titolo_lista($lid); //Text Body
$mail->WordWrap   = 50; // set word wrap


$mail->MsgHTML($text);


$mail->AddAddress("joevanni99@gmail.com","Giovanni Tufo");

$mail->IsHTML(true); // send as HTML

$mail->Send();
}
function notifica_prenotazione($oid) {

include("class.phpmailer.php");

$query = "SELECT * FROM oggetti WHERE ID = $oid";
$result = esegui_query($query);
$riga = mysql_fetch_array($result);

$id_lista = $riga['id_lista'];

$receiver = get_list_email($id_lista);

if($receiver != ""){
if($riga['noimg'] == 1){
 $filename = BASE_SITE . "images/noimg.png";
 }else{
 $filename = S3_URL . $riga['ID'] . ".jpg";
 }
$body ="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional //EN\">
<html>
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">
<title>Geeftable</title>
</head>
<body style=\"font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background:#f1f1f1\">
<div style=\"height:25px;width:100%;background:transparent;\">&nbsp;</div>
<table style=\"border: 1px solid #ccc;width:600px;margin:35px auto 3px auto;background: #fff\" cellpadding=\"0\" cellspacing=\"0\">
<tr style=\"background: #db3300; color: #fff;\">
<td style=\"padding: 6px; font-size:20px\" colspan=\"2\">Geeftable</td></tr>
<tr><td style=\"padding: 6px;\"><img src=\"$filename\" /></td><td><p><b>Oggetto prenotato</b></p>
<p style=\"font-size: 14px\">Qualcuno ha scelto di regalarti <b>" . htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8') . "</b></p></td></tr>
</table>
<table style=\"width:600px;margin:3px auto;\" cellpadding=\"0\" 
cellspacing=\"0\">
<tr><td style=\"color:#888; font-size: 10px\">Questo &egrave; un 
messaggio automatico. Non rispondere a questa email.</td></tr>
</table><div style=\"height:25px;width:100%;background:transparent;\">&nbsp;</div></body></html>";

$mail             = new PHPMailer();

$mail->SetFrom("joevanni99@gmail.com","Geeftable");
$mail->Subject    = "Oggetto prenotato: " . htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');
$mail->AltBody    = "Qualcuno ha scelto di regalare " . htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8'); //Text Body
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

$mail->AddAddress($receiver);

$mail->Send();

}
}

function get_list_email($lid){
$query = "SELECT email FROM liste WHERE ID = $lid";
$result = esegui_query($query);
$riga = mysql_fetch_row($result);
return $riga[0];
}

function notifica_rilascio($oid) {
include("class.phpmailer.php");
//include("class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$query = "SELECT * FROM oggetti WHERE ID = $oid";
$result = esegui_query($query);
$riga = mysql_fetch_array($result);

$id_lista = $riga['id_lista'];

$receiver = get_list_email($id_lista);

if($receiver != ""){

if($riga['noimg'] == 1){
 $filename = BASE_SITE . "images/noimg.png";
 }else{
 $filename = S3_URL . $riga['ID'] . ".jpg";
 }
 
$mail             = new PHPMailer();

$mail->SetFrom("joevanni99@gmail.com","Geeftable");
$mail->Subject    = "Oggetto non piu' prenotato: " . htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8');
$mail->AltBody    = "Qualcuno ha deciso di non regalare piu' " . htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8'); //Text Body
$mail->WordWrap   = 50; // set word wrap

$text ="<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional //EN\">" . "\r\n" ;
$text .= "<html>" . "\r\n" ;
$text .= "<head>" . "\r\n" ;
$text .= "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">" . "\r\n" ;
$text .= "<title>Geeftable</title>" . "\r\n" ;
$text .= "</head>" . "\r\n" ;
$text .= "<body style=\"font-family: 'Helvetica Neue', Helvetica, Arial," . "\r\n" ;
$text .= "sans-serif; background:#f1f1f1\">". "\r\n" ;
$text .= "<div style=\"height:25px;width:100%;background:transparent;\">&nbsp;</div>";
$text .= "<table style=\"border: 1px solid #ccc;width:600px;margin:35px auto 3px" ."\r\n" ;
$text .= "auto;background: #fff\" cellpadding=\"0\" cellspacing=\"0\">" . "\r\n" ;
$text .= "<tr style=\"background: #db3300; color: #fff;\">" . "\r\n" ;
$text .= "<td style=\"padding: 6px; font-size:20px\" colspan=\"2\">Geeftable</td></tr>" . "\r\n" ;
$text .= "<tr><td style=\"padding: 6px;\"><img src=\"$filename\" /></td><td><p><b>Oggetto non pi&ugrave; prenotato</b></p>" . "\r\n" ;
$text .= "<p style=\"font-size: 14px\">Qualcuno ha deciso di non regalarti pi&ugrave; <b>" . htmlentities(stripslashes($riga['nome']),ENT_COMPAT,'UTF-8') . "</b></p></td></tr>" . "\r\n" ;
$text .= "</table>" . "\r\n" ;
$text .= "<table style=\"width:600px;margin:3px auto;\" cellpadding=\"0\" " . "\r\n" ;
$text .= "cellspacing=\"0\">" . "\r\n" ;
$text .= "<tr><td style=\"color:#888; font-size: 10px\">Questo &egrave; un " . "\r\n" ;
$text .= "messaggio automatico. Non rispondere a questa email.</td></tr>" . "\r\n" ;
$text .= "</table><div style=\"height:25px;width:100%;background:transparent;\">&nbsp;</div></body></html>";


$mail->MsgHTML($text);

$mail->AddAddress($receiver);

$mail->Send();
}
}
?>