<?php

define('DB_ADRESSERWERA', 'localhost');
define('DB_NAZWAUZYTKOWNIKA', 'szportowemocje');
define('DB_HASLO', 'psrptoqrl');
define('DB_NAZWABAZY', 'ruchlewostronny_cba_pl');

include_once('function/ZbieranieDanychDlaTwinga.php');

set_include_path(get_include_path(). PATH_SEPARATOR . "class");

function __autoload($className) 
{   
    @include_once("class/".$className.".php");   
}
