<?php
session_start();
error_reporting(E_ALL);
    include_once 'config.php';
    $wyswietlona_strona=false;
    include("page/POST.php");
    /*^Sprawdzaie czy jest POST jest bez sensu.*/
    if(isset($_GET['page']))
    {
        if(!$wyswietlona_strona)
        {
            if(file_exists("page/".$_GET['page'].".php")) 
                { include("page/".$_GET['page'].".php"); } 
            else { include("page/mainpage.php"); }
            $wyswietlona_strona=true;
        }
    }
    if(!$wyswietlona_strona) include("page/mainpage.php");
?>

