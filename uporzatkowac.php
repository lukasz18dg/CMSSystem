<?php
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
    
    
   echo "Koniec";
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

