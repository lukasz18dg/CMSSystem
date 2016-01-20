<?php
 if ((isset($_GET['ID']))&&(isset($_GET['kod_resetowania_hasla'])))
 {
    Twigclass::WyswietlajWidok(17,  array('id' => $_GET['ID'], 'kod_resetowania_hasla' => $_GET['kod_resetowania_hasla']));
 }
 Twigclass::WyswietlajWidok(17);
//localhost/index.php?page=zmiana_hasla&ID=51&kod_resetowania_hasla=874450683\
