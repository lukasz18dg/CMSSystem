<?php
    include_once 'config.php';
    
    echo 'Test';
    $wynik=DataBaseclass::selectBySQL('SELECT * FROM `uzytkownik`');
    foreach ($wynik as $i)
    {
        foreach ($i as $a)
        {
            echo ' wartosc pobrana z bazy '.$a.'<br>';
        }
        echo "<br><br>";
    }
?>

