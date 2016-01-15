<?php

if(isset($_SESSION['zalogowany']))
{
    Twigclass::WczytajTemplate('strona_bledu.php',array(
        'komunikat_negatywny' => 'Użytkownik jest już zalogowany. Nie można rejestrować konta będąc zalogowanym.',
        'wyswietl_komunikat_negatywny' => '1',
        'zalogowany'=>'1'));
}
else 
{
    //$a=DataBaseclass::insertBySQL("INSERT INTO `uzytkownik` (`ID`, `Nick`, `Haslo`, `email`, `Uprawnienia`, `Aktywowane`) VALUES (NULL, 'gł', 'egł', 'g', '0', '5')");
    
    Twigclass::WczytajTemplate('rejestracja.tmpl',array(
    'test' => 'komunikat'));
}





