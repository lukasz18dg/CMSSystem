<?php
include("polacz.php");
$query = mysql_query("select * from news order by id desc limit 0,5");
while($rekord = mysql_fetch_array($query))
{
$naz .= '<li><a href="news.php?id='.$rekord[0].'">'.$rekord[1].'</a> Autor: '.$rekord[3].' - '.$rekord[2].'</li>';
}
echo '<ul>'.$naz.'</ul>';
?>