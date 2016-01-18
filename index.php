<?php
session_start();
error_reporting(E_ALL);
    include 'config.php';
    include("page/POST.php"); /*^Sprawdzaie czy jest POST odbywa się wewnątrz.*/
    include("page/GET.php");  /*^Sprawdzaie czy jest GET odbywa się wewnątrz.*/	
    include("page/mainpage.php"); /* Twig sprawdza czy już zostało coś wyświetlone czy nie */

