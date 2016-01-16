<?php
class Twigclass
{
    private static $loader;
    private static $twig;
    private static $template;
    
    static private function KonstruktorTwig()
    {
        include 'twing/lib/Twig/Autoloader.php';
        Twig_Autoloader::register();
        self::$loader = new Twig_Loader_Filesystem('templates');
        self::$twig = new Twig_Environment(self::$loader);
    }
    
    static private function WczytajTemplate($plik='index.tmpl',$tablica=array())
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
            case 'index.tmpl' : return $plik;
            case 'index.php'  : return 'index.tmpl';

            case 'rejestracja.tmpl' : return 'rejestracja.tmpl';           
            case 'rejestracja.php'  : return 'rejestracja.tmpl';
                        
            case 'strona_bledu.tmpl' : return 'strona_bledu.tmpl';
            case 'strona_bledu.php'  : return 'strona_bledu.tmpl'; 
        }
        return 0;
    }
    
    static public function WyswietlajWidok($nr_widoku=1,$tablica=array())
    {
        switch($nr_widoku)
        {
            case 1:
                Twigclass::WczytajTemplate();
                $wyswietlona_strona=true;
                break;
            
            case 2:
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_negatywny' => 'Problem z połaczeniem z bazą. Skontaktuj się z administratorem strony.',
                    'wyswietl_komunikat_negatywny' => '1'));
                $wyswietlona_strona=true;
                break;
            
            case 3:
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_negatywny' => 'Podano błędne login i hasło.',
                    'wyswietl_komunikat_negatywny' => '1'));
                $wyswietlona_strona=true;
                break;
            
            case 4:
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_negatywny' => 'Wystąpił błąd 590. Proszę o ponowne zalogowowanie do serwisu.',
                    'wyswietl_komunikat_negatywny' => '1'));
                $wyswietlona_strona=true;
                break;
            
            case 5:
                Twigclass::WczytajTemplate('index.php',array(
                    'komunikat_pozytywny' => 'Zalogowano pomyślnie!.',
                    'wyswietl_komunikat_pozytywny' => '1',
                    'zalogowany'=>'1'));
                $wyswietlona_strona=true;
                break;
            
            case 6:
                Twigclass::WczytajTemplate('strona_bledu.php',array(
                    'komunikat_negatywny' => 'Użytkownik jest już zalogowany. Nie można rejestrować konta będąc zalogowanym.',
                    'wyswietl_komunikat_negatywny' => '1',
                    'zalogowany'=>'1'));
                $wyswietlona_strona=true;
                break;
            
            case 7:
                Twigclass::WczytajTemplate('rejestracja.tmpl');
                $wyswietlona_strona=true;
                break;
            
            case 8:
                Twigclass::WczytajTemplate('rejestracja.php',array(
                    'komunikat_negatywny' => 'Email jest już używany. Wybierz inny.',
                    'wyswietl_komunikat_negatywny' => '1',
                    $tablica['nazwa1'] => $tablica[$tablica['nazwa1']],
                    $tablica['nazwa2'] => $tablica[$tablica['nazwa2']]));
                $wyswietlona_strona=true;
                break;
        }
    }
}
