<?php
if(isset($_GET['ID'])&&isset($_GET['Kod_aktywacji']))
{
    $wynik=DataBaseclass::selectBySQLCOUNT('SELECT ID,Kod_aktywacji FROM `Uzytkownik` WHERE `ID` = '.$_GET['ID'].' AND `Kod_aktywacji` LIKE "'.$_GET['Kod_aktywacji'].'"' );
    if($wynik==1)
    {
        $wynik=DataBaseclass::updateTable('UPDATE Uzytkownik SET `Aktywowane`="1",`Kod_aktywacji`=0 WHERE `ID`='.$_GET['ID'].' AND `Kod_aktywacji`='.$_GET['Kod_aktywacji'].';');
        if($wynik)
        {
            Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
            Twigclass::WyswietlajWidok(11);
        }        
    }
    else { Twigclass::WyswietlajWidok(10); }
}
else { Twigclass::WyswietlajWidok(10); }
//localhost/index.php?page=aktywacja&ID=11&Kod_aktywacji=799652099 

