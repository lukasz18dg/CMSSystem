<?php
class SaveFileclass 
{
    static public function ZapisDoPlikuASCII($dane,$lokalizacja_pliku,$nazwa_pliku,$tryb_otwarcia)
    {
        $fp = fopen($lokalizacja_pliku.$nazwa_pliku, $tryb_otwarcia); 
        flock($fp, 2); 
        fwrite($fp, $dane); 
        flock($fp, 3); 
        fclose($fp); 
    }
}