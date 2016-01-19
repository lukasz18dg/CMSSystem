<?php
if(isset($_SESSION['zalogowany'])) 
{ if($_SESSION['zalogowany']) { Twigclass::WyswietlajWidok(6); }  } 
else { Twigclass::WyswietlajWidok(7); }