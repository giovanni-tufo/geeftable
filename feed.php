<?php
include("header.php");
$lista = escaper($_GET['id']);
header("Content-type: text/xml; charset=utf-8");
echo "<?xml version=\"1.0\"?>";
echo "<rss version=\"2.0\">";
echo "<channel>";
echo "<title>";
titolo_pagina($lista);
echo " - Geeftable</title>";
echo "<link>http://www.geefty.com/list.php?id=" . $lista ."</link>";
echo "<description>";
desc_lista($lista);
echo "</description>";
echo "<lastBuildDate>";
list_updated($lista);
echo "</lastBuildDate>";
crea_feed($lista);
echo "</channel>";
echo "</rss>";

?>
