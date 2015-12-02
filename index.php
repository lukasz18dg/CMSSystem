<?php
session_start();
    include_once 'config.php';

    /*Dane z POSTU*/
    /*Wersja testowa tylko!*/
    $wynik=DataBaseclass::selectBySQL('SELECT * FROM `uzytkownik` WHERE `Nick` = "a"');
    if($wynik)
    {
        foreach ($wynik as $i)
        {   
            $_SESSION["Nick"]=$i["Nick"];
            $_SESSION["Email"]=$i["email"];
            $_SESSION["Uprawnienia"]=$i["Uprawnienia"];
        }
    }
    
    $zmienna = file_get_contents($adres_strony);
		$a=strpos($zmienna, '<div class="entry-content">');
		$b=strpos($zmienna,'</div>', $a);
		$zmienna=substr($zmienna,$a,$b-$a);
?>

