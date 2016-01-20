<?php
class Twigclass
{
    private static $loader;
    private static $twig;
    private static $template;
    private static $wyswietlona_strona;
    
    static private function KonstruktorTwig()
    {
        include_once 'twing/lib/Twig/Autoloader.php';
        Twig_Autoloader::register();
        self::$loader = new Twig_Loader_Filesystem('templates');
        self::$twig = new Twig_Environment(self::$loader);
        self::$wyswietlona_strona=false;
    }
    
    static private function WczytajTemplate($plik='index.twig',$tablica=array())
    {
        $plik=self::ZmianaNazwy($plik);
        self::KonstruktorTwig();
        self::$template = self::$twig->loadTemplate($plik);
        echo self::$template->render($tablica);
    }
    
    static private function ZmianaNazwy($plik)
    {
        switch ($plik) 
        {
            case 'index.twig' : return $plik;
            case 'index.php'  : return 'index.twig';

            case 'rejestracja.twig' : return 'rejestracja.twig';           
            case 'rejestracja.php'  : return 'rejestracja.twig';
                        
            case 'strona_bledu.twig' : return 'strona_bledu.twig';
            case 'strona_bledu.php'  : return 'strona_bledu.twig';
                
            case 'nic.twig' : return 'nic.twig';
            case 'nic.php'  : return 'nic.twig'; 
                
            case 'poprawnie_aktywowanie.twig'   : return 'poprawnie_aktywowanie.twig';
            case 'poprawnie_aktywowanienic.php' : return 'poprawnie_aktywowanie.twig';
                
            case 'przypominanie_hasla.twig' : return 'przypominanie_hasla.twig';
            case 'przypominanie_hasla.php'  : return 'przypominanie_hasla.twig';
                
            case 'zmiana_hasla.twig' : return 'zmiana_hasla.twig';
            case 'zmiana_hasla.php'  : return 'zmiana_hasla.twig';
                
            case 'zmiana_loginu.twig' : return 'zmiana_loginu.twig';
            case 'zmiana_loginu.php'  : return 'zmiana_loginu.twig';
                
            case 'zmiana_emailu.twig' : return 'zmiana_emailu.twig';
            case 'zmiana_emailu.php'  : return 'zmiana_emailu.twig';
                
            case 'wyloguj.twig' : return 'wyloguj.twig';
            case 'wyloguj.php'  : return 'wyloguj.twig';
        }
        return 0;
    }
    
    static public function WyswietlajWidok($nr_widoku=1,$tablica=array())
    {
        if(isset($_SESSION['zalogowany'])) { if($_SESSION['zalogowany']) { $tablica['zalogowany']='1'; } }
        if(!self::$wyswietlona_strona)
        {
            switch($nr_widoku)
            {
                case 1:
                    Twigclass::WczytajTemplate('index.php',$tablica);
                    self::$wyswietlona_strona=true;
                    break;

                case 2:
                    Twigclass::WczytajTemplate('index.php',array_merge($tablica,array(
                        'komunikat_negatywny' => 'Problem z połaczeniem z bazą. Skontaktuj się z administratorem strony.',
                        'wyswietl_komunikat_negatywny' => '1')));
                    self::$wyswietlona_strona=true;
                    break;

                case 3:
                    Twigclass::WczytajTemplate('index.php',array_merge($tablica,array(
                        'komunikat_negatywny' => 'Podano błędne login i hasło.',
                        'wyswietl_komunikat_negatywny' => '1')));
                    self::$wyswietlona_strona=true;
                    break;

                case 4:
                    Twigclass::WczytajTemplate('index.php',array_merge($tablica,array(
                        'komunikat_negatywny' => 'Wystąpił błąd 590. Proszę o ponowne zalogowowanie do serwisu.',
                        'wyswietl_komunikat_negatywny' => '1')));
                    self::$wyswietlona_strona=true;
                    break;

                case 5:
                    Twigclass::WczytajTemplate('index.php',array_merge($tablica,array(
                        'komunikat_pozytywny' => 'Zalogowano pomyślnie!.',
                        'wyswietl_komunikat_pozytywny' => '1')));
                    self::$wyswietlona_strona=true;
                    break;

                case 6:
                    Twigclass::WczytajTemplate('strona_bledu.php',array_merge($tablica,array(
                        'komunikat_negatywny' => 'Użytkownik jest już zalogowany. Nie można rejestrować konta będąc zalogowanym.',
                        'wyswietl_komunikat_negatywny' => '1')));
                    self::$wyswietlona_strona=true;
                    break;

                case 7:
                    Twigclass::WczytajTemplate('rejestracja.php',$tablica);
                    self::$wyswietlona_strona=true;
                    break;

                case 8:
                    Twigclass::WczytajTemplate('rejestracja.php',array_merge($tablica,array(
                        'komunikat_negatywny' => 'Email jest już używany. Wybierz inny.',
                        'wyswietl_komunikat_negatywny' => '1',
                        $tablica['nazwa1'] => $tablica[$tablica['nazwa1']],
                        $tablica['nazwa2'] => $tablica[$tablica['nazwa2']])));
                    self::$wyswietlona_strona=true;
                    break;
                case 9:
                    Twigclass::WczytajTemplate('rejestracja.php',array_merge($tablica,array(
                        'komunikat_pozytywny' => 'Pomyślnie założone hasło. Na e-mail zostanie przesłana wiadomość aktywacyjna. Przekierowanie nastąpi za 1 min.',
                        'wyswietl_komunikat_pozytywny' => '1',
                        'poprawna_rejestracja' => '1')));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 10:
                    Twigclass::WczytajTemplate('nic.php');
                    self::$wyswietlona_strona=true;
                    break;
                
                case 11:
                    Twigclass::WczytajTemplate('poprawnie_aktywowanienic.php',array_merge($tablica,array(
                        'komunikat_pozytywny' => 'Pomyślnie aktywowane konto. Możesz już się zalogować na swoje konto. Przekierowanie nastąpi za 1 min.',
                        'wyswietl_komunikat_pozytywny' => '1',
                        'poprawna_rejestracja' => '1')));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 12:
                    Twigclass::WczytajTemplate('index.php',array_merge($tablica,array(
                        'komunikat_negatywny' => 'Konto jest niezaaktywowane, proszę je ponownie zaaktywować.',
                        'wyswietl_komunikat_negatywny' => '1')));
                    self::$wyswietlona_strona=true;
                    break;
                
                 case 13:
                    Twigclass::WczytajTemplate('przypominanie_hasla.php',$tablica);
                    self::$wyswietlona_strona=true;
                    break;
                
                case 14:
                    Twigclass::WczytajTemplate('przypominanie_hasla.php',array_merge($tablica,array(
                        'komunikat_negatywny' => 'Oba pola są puste. Podaj ponownie.',
                        'wyswietl_komunikat_negatywny' => '1')));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 15:
                    Twigclass::WczytajTemplate('przypominanie_hasla.php',array_merge($tablica,array(
                        'wyswietl_komunikat_negatywny' => '1',
                        $tablica['nazwa1'] => $tablica[$tablica['nazwa1']],
                        $tablica['nazwa2'] => $tablica[$tablica['nazwa2']])));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 16:
                    Twigclass::WczytajTemplate('przypominanie_hasla.php',array_merge($tablica,array(
                        'komunikat_pozytywny' => 'Wysłano informacje jak zresetować hasło na emaila. Przekierowanie nastąpi za 1 min.',
                        'wyswietl_komunikat_pozytywny' => '1',
                        'poprawna_zresetowanie_hasla' => '1')));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 17:
                    Twigclass::WczytajTemplate('zmiana_hasla.php',array_merge($tablica));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 18:
                    Twigclass::WczytajTemplate('zmiana_loginu.php',array_merge($tablica));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 19:
                    Twigclass::WczytajTemplate('zmiana_emailu.php',array_merge($tablica));
                    self::$wyswietlona_strona=true;
                    break;
                
                case 20:
                    Twigclass::WczytajTemplate('wyloguj.php',array_merge($tablica));
                    self::$wyswietlona_strona=true;
                    break;
            }
        }
    }   
}
