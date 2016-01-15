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
    
    static public function WczytajTemplate($plik='index.tmpl',$tablica=array())
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
}
?>