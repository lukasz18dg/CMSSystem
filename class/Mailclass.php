<?php
class Mailclass 
{
    static private function Wyslij($odbiorca,$temat,$wiadomosc)
    {
        if(is_null($odbiorca)) return '%1';
        if(is_null($temat)) return '%2';
        if(is_null($wiadomosc)) return '%3';
        $wiadomosc=wordwrap($wiadomosc, 70, "\r\n");
        mail($odbiorca, $temat, $message);
    }
}
?>
