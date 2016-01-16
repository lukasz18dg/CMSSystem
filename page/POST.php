<?php
if (isset($_POST['page'])) 
{
    if(!$wyswietlona_strona)
    {
        if(file_exists('page/'.$_POST['page'].'php')) 
        { include_once ('page/'.$_POST['page'].'php'); }
        else { include_once ("page/mainpage.php"); }
        $wyswietlona_strona=true;
    } 
}

if (isset($_POST['send']))
{
    if ($_POST['send']=="login")
    {
        $wynik=DataBaseclass::selectBySQL('SELECT `Nick`,`email`,`Uprawnienia` FROM `Uzytkownik` WHERE `Nick`=\''.$_POST["id"].'\' AND `Haslo`=\''.  sha1(md5($_POST["passwd"])).'\'');
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
                    $_SESSION["Nick"]=$i["Nick"];
                    $_SESSION["Email"]=$i["email"];
                    $_SESSION["Uprawnienia"]=$i["Uprawnienia"];
                    $_SESSION['zalogowany']=true;
                    $_SESSION['wyswietl_komunikat_pozytywny']=true;
                }
                Twigclass::WyswietlajWidok(5);
                break;
            }
        }    
    }
}

if (isset($_POST['send']))
{
    if ($_POST['send']=="rejestracja")
    {
        if(DataBaseclass::selectBySQL("SELECT * FROM `uzytkownik` WHERE `email` LIKE '".$_POST['email']."'")=="%2")
        {      
            if(DataBaseclass::selectBySQL('SELECT * FROM `uzytkownik` WHERE `Nick` LIKE "'.$_POST['login'].'";')=="%2")
            {
                //$a=DataBaseclass::insertBySQL("INSERT INTO `uzytkownik` (`ID`, `Nick`, `Haslo`, `email`, `Uprawnienia`, `Aktywowane`) VALUES (NULL, 'gł', 'egł', 'g', '0', '5')");
                echo 1;
            }
            else
            {
                Twigclass::WyswietlajWidok(8,array('nazwa1' => 'POST_EMAIL',
                    'nazwa2' => 'POST_LOGIN',
                    'POST_EMAIL', $_POST['email'],
                    'POST_LOGIN', $_POST['login']));    
            }
        }
        else
        {
            Twigclass::WyswietlajWidok(8,array('nazwa1' => 'POST_EMAIL',
                    'nazwa2' => 'POST_LOGIN',
                    'POST_EMAIL' => $_POST['email'],
                    'POST_LOGIN' => $_POST['login'])); /* */
        }
    }
}
