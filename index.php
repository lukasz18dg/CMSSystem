<?php
session_start();
error_reporting(E_ALL);
    include_once 'config.php';
    $wyswietlona_strona=false;
    include("page/POST.php"); /*^Sprawdzaie czy jest POST odbywa się wewnątrz.*/
    include("page/GET.php");  /*^Sprawdzaie czy jest GET odbywa się wewnątrz.*/	
    if(!$wyswietlona_strona) include("page/mainpage.php");
?>

