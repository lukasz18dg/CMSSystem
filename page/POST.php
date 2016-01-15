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
            case '%1' : 
            {
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_negatywny' => 'Problem z połaczeniem z bazą. Skontaktuj się z administratorem strony.',
                    'wyswietl_komunikat_negatywny' => '1'));
                break;
            }
            case '%2' : 
            {
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_negatywny' => 'Podano błędne login i hasło.',
                    'wyswietl_komunikat_negatywny' => '1'));
                break;
            }            
            case '%3' : 
            {
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_negatywny' => 'Wystąpił błąd 590. Proszę o ponowne zalogowowanie do serwisu.',
                    'wyswietl_komunikat_negatywny' => '1'));
                break;
            }
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
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_pozytywny' => 'Zalogowano pomyślnie!.',
                    'wyswietl_komunikat_pozytywny' => '1',
                    'zalogowany'=>'1'));
                break;
            }
        }    
    }
}

/*if (isset($_POST['send']))
{
    if ($_POST['send']=="rejestracja")
    {*/
        /*if(DataBaseclass::selectBySQL("SELECT * FROM `uzytkownik` WHERE `email` LIKE '".$_POST['email']."'")=="%2")
                
                &&(DataBaseclass::selectBySQL()
        {
            echo 1;
        }
         
	login SELECT * FROM `uzytkownik` WHERE `Nick` LIKE 'a' 
	password*/
    /*}
}*/
