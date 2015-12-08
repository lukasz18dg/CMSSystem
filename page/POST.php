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
        if($wynik)
        {
            foreach ($wynik as $i)
            {   
                $_SESSION["Nick"]=$i["Nick"];
                $_SESSION["Email"]=$i["email"];
                $_SESSION["Uprawnienia"]=$i["Uprawnienia"];
                $_SESSION['zalogowany']=true;
            }
        }
        else { echo "Zle dane"; }  
    }
}
