<?php

class DataBaseclass 
{
    static private function laczeniezbaza() 
    {
        $laczenie = new mysqli(DB_ADRESSERWERA, DB_NAZWAUZYTKOWNIKA, DB_HASLO, DB_NAZWABAZY);
        if(!mysqli_connect_errno())
        {
            $laczenie-> query("SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
            return $laczenie;       
        }
        else { return false; }
    }
    
    static public function selectBySQL($SQL)
    { 
        if($laczenie = self::laczeniezbaza())
        {
            $laczenie->real_escape_string($SQL);
            $wynik = $laczenie->query($SQL);
            if(!$wynik) { return '%3'; } 
            else 
            {
                $tablicawynikow = Array(); 
                while(($row = $wynik->fetch_array(MYSQLI_ASSOC)) !== NULL) 
                { $tablicawynikow[] = $row; } 
            }
            mysqli_close($laczenie);
            if(count($tablicawynikow)==0) { return '%2'; }
            else { return $tablicawynikow; }
        }
        else { return '%1'; } 
    }
    /*
     * ^ Zwraca %1 przypadku nie powodzenia połączenia
     *   Zwraca %2 przypadku braku odpowiednich rekordów.
     *   Zwraca %3 przypadku błędnego zapytania?
     */
    
    static public function insertBySQL($SQL)
    {
        static $wynik;
        if($laczenie = self::laczeniezbaza())
        {
            $wynik = $laczenie->query($SQL);
            if(!($wynik)) { return false; } 
            else { return true; }
        }
        else return false;
    }
    /*
     * Zwraca true, w przypadku poprawnego wprowadzenia zapytania, false w przeciwnym
     */
    
    
}