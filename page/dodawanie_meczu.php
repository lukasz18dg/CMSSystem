<?php 
$wyniki=DataBaseclass::selectBySQL('SELECT `nazwa` FROM `druzyna`');
Twigclass::WyswietlajWidok(21,array('array_path'=>$wyniki));


