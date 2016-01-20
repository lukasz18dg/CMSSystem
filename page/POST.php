<?php
if (isset($_POST['page'])) 
{
    if(file_exists('page/'.$_POST['page'].'php')) 
    { include_once ('page/'.$_POST['page'].'php'); }
    else { include_once ("page/mainpage.php"); }
}

function poprawnosc_loginu($pole_w_bazie)
{
    $SQL=($pole_w_bazie=="email")?'SELECT `email` FROM `uzytkownik` WHERE `email`="'.$_POST['email'].'";':'SELECT `email`, `Nick` FROM `uzytkownik` WHERE `Nick`="'.$_POST['login'].'";';
    $wynik=DataBaseclass::selectBySQLCOUNT($SQL);
    if($wynik==1)
    {
        $SQL=($pole_w_bazie=="email")?'SELECT `ID`, `email` FROM `uzytkownik` WHERE `email`="'.$_POST['email'].'";':'SELECT `ID`, `email`, `Nick` FROM `uzytkownik` WHERE `Nick`="'.$_POST['login'].'";';
        $wynik=DataBaseclass::selectBySQL($SQL);
        foreach ($wynik as $i) { $temporary["ID"]=$i["ID"]; $temporary["email"]=$i["email"]; }
        $sekretny_kod=rand(1,999999999);
        $wynik=DataBaseclass::updateTable('UPDATE uzytkownik SET `kod_resetowania_hasla`="'.$sekretny_kod.'" WHERE `ID`='.$temporary["ID"].' AND `email`="'.$temporary["email"].'";');
        if($wynik)
        {
            //kod_resetowania_hasla
            $wiadomosc='Witaj!.\nDostaliśmy powiadomienie, że chcesz zresetować hasło na stronie '.$_SERVER['SERVER_NAME'].'\nJeśli to ty uczyniłeś, przejdź na stronę poniżej, jeśli nie zignoruj wiadomość.\n'.$_SERVER['SERVER_NAME']."/index.php?page=zmiana_hasla&ID=".$temporary['ID'].'&kod_resetowania_hasla='.$sekretny_kod.' \n Pozdrawiam.\n';
            Mailclass::Wyslij($temporary["email"], "Mail aktywacyjny do serwisu ".$_SERVER['SERVER_NAME'], $wiadomosc);
            return '%3';
        } else { return '%2'; }     
    }
    else { return '%1'; }      
}

if (isset($_POST['send']))
{
    switch ($_POST['send'])
    {
        case "login" :
            $wynik=DataBaseclass::selectBySQL('SELECT `Nick`,`email`,`Uprawnienia`, `Aktywowane` FROM `Uzytkownik` WHERE (`Nick`="'.$_POST["id"].'" AND `Haslo`="'.  sha1(md5($_POST["passwd"])).'") OR (`email`="'.$_POST["id"].'" AND `Haslo`="'.  sha1(md5($_POST["passwd"])).'")');
            /* ^ Zwraca %1 przypadku nie powodzenia połączenia Zwraca %2 przypadku braku odpowiednich rekordów.
            *   Zwraca %3 przypadku błędnego zapytania? */
            switch ($wynik)
            {
                case '%1' : { Twigclass::WyswietlajWidok(2); break; }
                case '%2' : { Twigclass::WyswietlajWidok(3); break; }            
                case '%3' : { Twigclass::WyswietlajWidok(4); break; } 
                default :
                {
                    foreach ($wynik as $i)
                    {
                        if($i["Aktywowane"])
                        {
                            $_SESSION["Nick"]=$i["Nick"];
                            $_SESSION["Email"]=$i["email"];
                            $_SESSION["Uprawnienia"]=$i["Uprawnienia"];
                            $_SESSION['zalogowany']=true;
                            $_SESSION['wyswietl_komunikat_pozytywny']=true;
                            Twigclass::WyswietlajWidok(5);
                        }
                        else { Twigclass::WyswietlajWidok(12); break; }
                    }
                }
            }
            break;
            
        case "rejestracja":
            if((DataBaseclass::selectBySQL("SELECT * FROM `uzytkownik` WHERE `email` LIKE '".$_POST['email']."'")=="%2")
                ||(DataBaseclass::selectBySQL('SELECT * FROM `uzytkownik` WHERE `Nick` LIKE "'.$_POST['login'].'";')=="%2"))
            {               
                DataBaseclass::insertBySQL('INSERT INTO `uzytkownik` (`Nick`,`Haslo`,`email`,`Uprawnienia`,`Aktywowane`,`Kod_aktywacji`,`kod_resetowania_hasla`) VALUES ("'.$_POST['login'].'", "'.sha1(md5($_POST['password'])).'", "'.$_POST['email'].'", "2", "0", "'.rand(1,999999999).'", "0")');
                $wynik=DataBaseclass::selectBySQL('SELECT `ID`,`Kod_aktywacji` FROM uzytkownik WHERE  `Nick`="'.$_POST['login'].'"');
                switch ($wynik)
                {
                    case '%1' : { Twigclass::WyswietlajWidok(2); break; }            
                    default :
                    {
                        foreach ($wynik as $i) { $temporary["ID"]=$i["ID"]; $temporary["Kod_aktywacji"]=$i["Kod_aktywacji"]; }
                        $wiadomosc="Witaj.\nZarejestrowałeś się na stronie ".$_SERVER['SERVER_NAME']."\nDziękujemy za rejestację. \nPodane dane w rejestacji są następujące: \nE-mail: ".$_POST['email']." \nLogin : ".$_POST['login']." \nHasło : Takie jak podano przy tworzeniu konta. \nJednak, aby w pełni korzystać z konta musisz je aktywować odwiedzając ".$_SERVER['SERVER_NAME']."/index.php?page=aktywacja&ID=".$temporary["ID"]."&Kod_aktywacji=".$temporary["Kod_aktywacji"]." \nJeśli jednak nie ty tworzyłeś te konto, zignoruj tą wiadomość \n Pozdrawiam. \n";
                        Mailclass::Wyslij($_POST['email'], "Mail aktywacyjny do serwisu ".$_SERVER['SERVER_NAME'], $wiadomosc);
                        /*wyeksportowac do pliku^*/
                        Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                        Twigclass::WyswietlajWidok(9);
                        break;
                    }
                }
            }
            else
            {
                Twigclass::WyswietlajWidok(8,array('nazwa1' => 'POST_EMAIL',
                    'nazwa2' => 'POST_LOGIN',
                    'POST_EMAIL', $_POST['email'],
                    'POST_LOGIN', $_POST['login']));    
            }
            break;
            
        case 'przypomianie_hasla':
            if(($_POST['email']=="")&&($_POST['login']=="")) { Twigclass::WyswietlajWidok(14); }
            else
            {        
                if(($r=poprawnosc_loginu('email'))=='%3')
                {
                    Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                    Twigclass::WyswietlajWidok(16);
                    exit();
                }
                if(($t=poprawnosc_loginu('login'))=='%3')
                {
                    Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                    Twigclass::WyswietlajWidok(16);
                    exit();
                }
                $tekst="";
                if($r=='%1') { $tekst.="Podany email, nie znaleziono w bazie, podaj ponownie. "; }
                if($t=='%1') { $tekst.="Podany login, nie znaleziono w bazie, podaj ponownie. "; }
                if($r=='%2') { $tekst.="Problemy z bazą. "; }
                if($r=='%2') { $tekst.="Problemy z bazą. "; }
                Twigclass::WyswietlajWidok(16,array('komunikat_negatywny' => $tekst));
                exit();
            }
            break;
        
        case 'zmiana_hasla':
            if($_POST['password']!="")
            {
                if(($_POST['ID']!=0)&&($_POST['kod_resetowania_hasla']!=0))
                {
                    $wynik=DataBaseclass::selectBySQLCOUNT('SELECT ID FROM `uzytkownik` WHERE `ID` = '.$_POST['ID'].' AND `kod_resetowania_hasla` LIKE "'.$_POST['kod_resetowania_hasla'].'"');
                    if($wynik==1)
                    {
                        $wynik=DataBaseclass::updateTable('UPDATE uzytkownik SET `Haslo`="'.sha1(md5($_POST['password'])).'",`kod_resetowania_hasla`=0 WHERE `ID`='.$_POST['ID'].';');
                        if($wynik)
                        {
                            Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                            Twigclass::WyswietlajWidok(17,array('komunikat_pozytywny' => 'Pomyślnie zmieniono hasło. Teraz może się zalogować. Przekierowanie nastąpi za 1 min.',
                            'wyswietl_komunikat_pozytywny' => '1',
                            'poprawna__zmiana_hasla' => '1'));
                        } 
                    }
                    else { Twigclass::WyswietlajWidok(17,array('komunikat_negatywny' => 'Nie znaleziono, takiej prośby o zmianę o hasło. Skopiuj/wpisz adres ponownie.',
                            'wyswietl_komunikat_negatywny' => '1',
                            'id' => $_POST['ID'],
                            'kod_resetowania_hasla' => $_POST['kod_resetowania_hasla'])); }
                }
                else 
                {
                    if($_SESSION['zalogowany'])
                    {
                        $wynik=DataBaseclass::selectBySQLCOUNT('SELECT ID FROM `uzytkownik` WHERE `Nick` = "'.$_SESSION['Nick'].'" AND `email` LIKE "'.$_SESSION['Email'].'"');
                        if($wynik==1)
                        {
                            $wynik=DataBaseclass::updateTable('UPDATE uzytkownik SET `Haslo`="'.sha1(md5($_POST['password'])).'" WHERE `Nick`="'.$_SESSION['Nick'].'";');
                            if($wynik)
                            {
                                Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                                Twigclass::WyswietlajWidok(17,array('komunikat_pozytywny' => 'Pomyślnie zmieniono hasło. Teraz możesz się wylogować, aby zalogować z nowym hasłem. Przekierowanie nastąpi za 1 min.',
                                    'wyswietl_komunikat_pozytywny' => '1',
                                    'poprawna__zmiana_hasla' => '1'));
                            }
                        }
                    }
                    else
                    {
                        Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                        Twigclass::WyswietlajWidok(17,array('komunikat_negatywny' => 'Jesteś nie uprawniony do zmiany hasła. Przekierowanie nastąpi za 1 min.',
                            'wyswietl_komunikat_negatywny' => '1',
                            'poprawna__zmiana_hasla' => '1'));
                    }
                }
            }
            else
            {
                Twigclass::WyswietlajWidok(17,array('komunikat_negatywny' => 'Podane hasło jest puste.',
                        'wyswietl_komunikat_negatywny' => '1', 
                        'id' => $_POST['ID'],
                        'kod_resetowania_hasla' => $_POST['kod_resetowania_hasla'])); 
            }
            break;
        
        case 'zmiana_loginu':
            /*Zablokować skryptem*/
            if($_POST['login']!="")
            {
                if($_SESSION['zalogowany'])
                {
                    $wynik=DataBaseclass::selectBySQLCOUNT('SELECT ID FROM `uzytkownik` WHERE `Nick` = "'.$_SESSION['Nick'].'" AND `email` LIKE "'.$_SESSION['Email'].'"');
                    if($wynik==1)
                    {
                        /*Zamienic na ajaxa*/
                        $wynik=DataBaseclass::selectBySQLCOUNT('SELECT ID FROM `uzytkownik` WHERE `Nick` = "'.$_POST['login'].'"');
                        if($wynik==0)
                        {
                            $wynik=DataBaseclass::updateTable('UPDATE uzytkownik SET `Nick`="'.$_POST['login'].'" WHERE `email`="'.$_SESSION['Email'].'";');
                            if($wynik)
                            {
                                Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                                Twigclass::WyswietlajWidok(18,array('komunikat_pozytywny' => 'Pomyślnie zmieniono login. Teraz możesz się wylogować, aby zalogować z nowym loginem. Przekierowanie nastąpi za 1 min.',
                                    'wyswietl_komunikat_pozytywny' => '1',
                                    'poprawna__zmiana_loginu' => '1'));
                            }
                        }
                        else
                        {
                            Twigclass::WyswietlajWidok(18,array('komunikat_negatywny' => 'Użytkownik o takim loginie już istnieje.',
                                'wyswietl_komunikat_negatywny' => '1'));
                        }
                        
                    }
                }
                else
                {
                    Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                    Twigclass::WyswietlajWidok(18,array('komunikat_negatywny' => 'Jesteś nie uprawniony do zmiany hasła. Przekierowanie nastąpi za 1 min.',
                        'wyswietl_komunikat_negatywny' => '1'));
                }
            }
            else 
            {
                Twigclass::WyswietlajWidok(18,array('komunikat_negatywny' => 'Podany login jest pusty.',
                        'wyswietl_komunikat_negatywny' => '1')); 
            }
            break;
        case 'zmiana_emailu':
            /*Zablokować skryptem*/            
            if($_POST['email']!="")
            {
                if($_SESSION['zalogowany'])
                {         
                    $wynik=DataBaseclass::selectBySQLCOUNT('SELECT ID FROM `uzytkownik` WHERE `Nick` = "'.$_SESSION['Nick'].'"');
                    if($wynik==1)
                    {
                        
                        
                        /*Zamienic na ajaxa*/
                        $wynik=DataBaseclass::selectBySQLCOUNT('SELECT ID FROM `uzytkownik` WHERE `email` = "'.$_POST['email'].'"');
                        if($wynik==0)
                        {                            
                            $wynik=DataBaseclass::updateTable('UPDATE uzytkownik SET `email`="'.$_POST['email'].'" WHERE `Nick`="'.$_SESSION['Nick'].'";');
                            if($wynik)
                            {
                                Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                                Twigclass::WyswietlajWidok(19,array('komunikat_pozytywny' => 'Pomyślnie zmieniono email. Teraz możesz się wylogować, aby zalogować z nowym emailem. Przekierowanie nastąpi za 1 min.',
                                    'wyswietl_komunikat_pozytywny' => '1',
                                    'poprawna__zmiana_emailu' => '1'));
                            }
                        }
                        else
                        {
                            Twigclass::WyswietlajWidok(19,array('komunikat_negatywny' => 'Użytkownik o takim emailu już istnieje.',
                                'wyswietl_komunikat_negatywny' => '1'));
                        }
                        
                    }
                    echo "f";
                    exit();
                }
                else
                {
                    Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
                    Twigclass::WyswietlajWidok(19,array('komunikat_negatywny' => 'Jesteś nie uprawniony do zmiany loginu. Przekierowanie nastąpi za 1 min.',
                        'wyswietl_komunikat_negatywny' => '1'));
                }
            }
            else 
            {
                Twigclass::WyswietlajWidok(19,array('komunikat_negatywny' => 'Podany email jest pusty.',
                        'wyswietl_komunikat_negatywny' => '1')); 
            }
            break;
    }
}

