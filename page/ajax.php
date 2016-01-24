<?php
include '../config.php'; /*Przechodzenie przez linki, prowadzi do niszczenia zmiennych*/

function cjjwb($a1,$a2)
/*czy jest juz w bazie*/
{
    $a1=$a1=='email'?'email':'Nick';
    $wynik=DataBaseclass::selectBySQLCOUNT('SELECT `'.$a1.'` FROM Uzytkownik WHERE '.$a1.'=\''.$a2.'\';');
    if($wynik) { echo "01"; } else { echo "10"; }
}

if(isset($_GET['funkcja']))
{
    if($_GET['funkcja']=='visible')
    {
        if(isset($_GET['email'])) { cjjwb('email',$_GET['email']); }
        if(isset($_GET['login'])) { cjjwb('login',$_GET['login']); }
    }
}
