<?php
class Przekierowaniaclass 
{
    public static function Przekieruj($strone, $czas) { header('Refresh: '.$czas.'; url='.$strone); }
}
