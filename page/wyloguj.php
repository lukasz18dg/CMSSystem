<?php
if(isset($_SESSION['zalogowany']))
{
    session_destroy();
    Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
    Twigclass::WyswietlajWidok(20,array('komunikat_pozytywny' => 'Pomyślnie wylogowano. Przekierowanie nastąpi za 1 min.',
                                    'wyswietl_komunikat_pozytywny' => '1'));
}
else   
{ 
    Przekierowaniaclass::Przekieruj($_SERVER['PHP_SELF'], 60);
    Twigclass::WyswietlajWidok(20,array('komunikat_negatywny' => 'Nie mogę wylogować użytkownika, który nie jest zalogowany!. Przekierowanie nastąpi za 1 min.',
                                    'wyswietl_komunikat_negatywny' => '1')); 
}

