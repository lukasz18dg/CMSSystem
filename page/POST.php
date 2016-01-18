<?php
if (isset($_POST['page'])) 
{
    if(file_exists('page/'.$_POST['page'].'php')) 
    { include_once ('page/'.$_POST['page'].'php'); }
    else { include_once ("page/mainpage.php"); }
}

if (isset($_POST['send']))
{
    if ($_POST['send']=="login")
    {
        $wynik=DataBaseclass::selectBySQL('SELECT `Nick`,`email`,`Uprawnienia`, `Aktywowane` FROM `Uzytkownik` WHERE (`Nick`="'.$_POST["id"].'" AND `Haslo`="'.  sha1(md5($_POST["passwd"])).'") OR (`email`="'.$_POST["id"].'" AND `Haslo`="'.  sha1(md5($_POST["passwd"])).'")');
        /*
        * ^ Zwraca %1 przypadku nie powodzenia połączenia
        *   Zwraca %2 przypadku braku odpowiednich rekordów.
        *   Zwraca %3 przypadku błędnego zapytania?
        */
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
                        break;
                    }
                    else
                    {
                        Twigclass::WyswietlajWidok(12);
                        break;
                    }
                }
                break;
            }
        }    
    }
}

if (isset($_POST['send']))
{
    if ($_POST['send']=="rejestracja")
    {
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
                    foreach ($wynik as $i)
                    {   
                        $temporary["ID"]=$i["ID"];
                        $temporary["Kod_aktywacji"]=$i["Kod_aktywacji"];
                    }
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
    }
}

function poprawnosc_loginu($pole_w_bazie)
{
    $SQL=($pole_w_bazie=="email")?'SELECT `email` FROM `uzytkownik` WHERE `email`="'.$_POST['email'].'";':'SELECT `email`, `Nick` FROM `uzytkownik` WHERE `Nick`="'.$_POST['login'].'";';
    $wynik=DataBaseclass::selectBySQLCOUNT($SQL);
    if($wynik==1)
    {
        $SQL=($pole_w_bazie=="email")?'SELECT `id`, `email` FROM `uzytkownik` WHERE `email`="'.$_POST['email'].'";':'SELECT `id`, `email`, `Nick` FROM `uzytkownik` WHERE `Nick`="'.$_POST['login'].'";';
        $wynik=DataBaseclass::selectBySQL($SQL);
        $sekretny_kod=rand(1,999999999);
        $wynik=DataBaseclass::updateTable('UPDATE uzytkownik SET `kod_resetowania_hasla`="'.$sekretny_kod.'" WHERE `ID`='.$_POST['ID'].' AND `email`='.$_POST['emial'].';');
        foreach ($wynik as $i) { $temporary["ID"]=$i["ID"]; $temporary["email"]=$i["email"]; }
        //kod_resetowania_hasla
        $wiadomosc='Witaj!.\n Dostaliśmy powiadomienie, że chcesz zresetować hasło na stronie '.$_SERVER['SERVER_NAME'].'\n Jeśli to ty uczyniłeś, przejdź na stronę poniżej, jeśli nie zignoruj wiadomość.\n'.$_SERVER['SERVER_NAME']."/index.php?page=zmiana_hasla&ID=".$temporary['ID'].'&kod_resetowania_hasla='.$sekretny_kod.' \n Pozdrawiam. \n';
        Mailclass::Wyslij($temporary["email"], "Mail aktywacyjny do serwisu ".$_SERVER['SERVER_NAME'], $wiadomosc);
        Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60); 
    }
    else { return false; }


    /*$_POST['email']
            `Nick``
                . ``email` LIKE '".$_POST['email']*/
                
}

if (isset($_POST['send']))
{
    if(($_POST['email']==" ")&&($_POST['login']==" "))
    {
        Twigclass::WyswietlajWidok(14);
    }
    else
    {
        if($_POST['email']!=" ")
        {
            if(!poprawnosc_loginu('email'))
            {
                Twigclass::WyswietlajWidok(16);
            }
        }
        else
        {
            if($_POST['login']!=" ")
            {
                if(!poprawnosc_loginu('login'))
                {
                    Twigclass::WyswietlajWidok(16);
                }
        }
        }
        
       
        
    }
}
