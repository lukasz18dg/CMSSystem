<?php

class DataBaseclass 
{
    static private function laczeniezbaza() 
    {
        /*Funkcja statyczna, której za zadanie jest łączenie z danym 
         * serwerem, nazwą użytkownika, hasłem bazy, nazwą danej bazy.
        */
        $laczenie = new mysqli(DB_ADRESSERWERA, DB_NAZWAUZYTKOWNIKA, DB_HASLO, DB_NAZWABAZY);
        /* Jeśli podczzas łączenie nie napotkał błędów*/
        if(!mysqli_connect_errno())
        {
            $laczenie->query("SET NAMES 'utf8'");
            /*
             * ^ Ustawienie odpowiedniego kodowania znakow w bazie
             */
            return $laczenie;
            /*
             * Zwrocenie obiektu, ktory bedzie nam pomagal w wydawaniu polecen MySQL
             */
        }
        else { return false; }
    }
    
    static public function selectBySQL($SQL)
    /*
     * Za pomoca tej funkcji, będziemy wydawali polecenie SELECT w MySQL
     * Funkcja, za pomoca innej metody, ma się połączyć do wcześniej 
     * zdefiniowanej bazy, Jeśli poprawnie się połączy, ma się wykonać
     * polecenie bezpieczeństwa, real_escape_string, które przed każdym 
     * specjalnym znakiem, które by mogło zakłócić polecenie jest wstawiany, 
     * znak, który to powoduje, że znak specjalny jest trakowany jako normalny
     * znak.
     * Funkcja zwraca, tablicę jeśli poprawnie pobrano dane,
     * Jeśli nie, zwraca false. 
     */
    {
        $laczenie = self::laczeniezbaza();
        if($laczenie)
        {
            $laczenie->real_escape_string($SQL);
            $wynik = $laczenie->query($SQL);
            if(!$wynik) 
            { return false; } 
            else 
            {
                $tablicawynikow = Array(); 
                while(($row = $wynik->fetch_array(MYSQLI_ASSOC)) !== NULL) 
                {
                    $tablicawynikow[] = $row;
                } 
            }
            mysqli_close($laczenie);
            if(count($tablicawynikow)==0)
                 { return false; }
            else { return $tablicawynikow; }
        }
        else
        { return false; } 
    } 
}
