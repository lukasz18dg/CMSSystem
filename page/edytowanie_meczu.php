<?php
if(isset($_GET['wybor']))
{
    'SELECT * FROM `wynik` WHERE `ID`="'.$_GET['wybor'].'";';
    if(1==(DataBaseclass::selectBySQLCOUNT('SELECT `ID` FROM `wynik` WHERE `ID`="'.$_GET['wybor'].'";')))
    {
        $wynik=DataBaseclass::selectBySQL('SELECT * FROM `wynik` WHERE `ID`="'.$_GET['wybor'].'";');
        foreach ($wynik as $i) 
        { 
            $_temporary["SEZON"]=$i["Sezon"]; 
            $_temporary["DRUZYNAA"]=$i["Druzyna_A"];
            $_temporary["DRUZYNAB"]=$i["Druzyna_B"];
            $_temporary["WYNIK_A"]=$i["Wynik_A"];
            $_temporary["WYNIK_B"]=$i["Wynik_B"];
            $_temporary["DATA"]=$i["Data"];
            $_temporary["ID"]=$i["ID"];
        }  
        unset($wyniki);
        $wynik=DataBaseclass::selectBySQL('SELECT `nazwa` FROM `druzyna`');
            Twigclass::WyswietlajWidok(22,array('komunikat_pozytywny' => 'Wybrano mecz do edycji. Zaraz wyświetlę formularz, gdzie możesz edytować mecz.',
                'wyswietl_komunikat_pozytywny' => '1',
                'wybrane' => '1',
                "array_path"=>$wynik,
                "SEZON"=>$_temporary["SEZON"],
                "DRUZYNAA"=>$_temporary["DRUZYNAA"],
                "DRUZYNAB"=>$_temporary["DRUZYNAB"],
                "WYNIK_A"=>$_temporary["WYNIK_A"],
                "WYNIK_B"=>$_temporary["WYNIK_B"],
                "DATA"=>$_temporary["DATA"],
                "ID"=>$_temporary["ID"]));
    }
    else
    {
        /*Wymienić na złączenie dwóch tabel*/
        $wynik=DataBaseclass::selectBySQL('SELECT * FROM `wynik`');
        Twigclass::WyswietlajWidok(22,array('komunikat_negatywny' => 'Nie znaleziono, takiego meczu. Proszę wybrać inny.',
            'wyswietl_komunikat_negatywny' => '1',
            "wyniki_meczu"=>$wynik));      
    }
}
/*Wymienić na złączenie dwóch tabel*/
$wynik=DataBaseclass::selectBySQL('SELECT * FROM `wynik`');
Twigclass::WyswietlajWidok(22,array("wyniki_meczu"=>$wynik));

