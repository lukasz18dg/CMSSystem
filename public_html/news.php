<?php
include("polacz.php");
$query = mysql_query("select * from news where id='".(int)$_GET['id']."'"); // 1
$rekord = mysql_fetch_array($query);
echo '<h1>'.$rekord[1].'</h1>Autor: '.$rekord[3].'<br/>Data: '.$rekord[2].'<p>'.$rekord[4].'</p>'; // 2
?>