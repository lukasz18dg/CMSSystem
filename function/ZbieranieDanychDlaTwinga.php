<?php
    function ZbiorDanych($strona,$tablica=array())
    {
        //Uwaga!. Istnieje możliwość nadpisania.
        if($_SESSION['zalogowany']) $tablica['zalogowany']=($_SESSION['zalogowany']);
        Twigclass::WczytajTemplate($strona,$tablica);
    }
?>

