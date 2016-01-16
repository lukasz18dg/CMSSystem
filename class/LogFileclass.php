<?php
class LogFile
{
    const lokalizacja_pliku='logs/';
    const aplus='a+';
    
    static public function AddLogMySQL($dane) 
    {
        $nazwa_pliku='MYSQLLOG';
        $tryb_otwarcia=aplus;
        SaveFileclass::ZapisDoPlikuASCII(date('d.m.Y h:i:s').$dane,lokalizacja_pliku, $nazwa_pliku, $tryb_otwarcia);
    }
    static public function AddLogTwig($dane)
    {
        $nazwa_pliku='TWIGLOG';
        $tryb_otwarcia=aplus;
        SaveFileclass::ZapisDoPlikuASCII(date('d.m.Y h:i:s').$dane,lokalizacja_pliku, $nazwa_pliku, $tryb_otwarcia);
    }
}