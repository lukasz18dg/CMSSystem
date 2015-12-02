<form action="" method="post">
tytu³: <input type="text" name="tytul">
<br/>autor <input type="text" name="autor">
<br/>treœæ <textarea name="tresc" rows="20" cols="50"></textarea>
<br/><input type="submit" value="Dodaj"></form>
<?php
include("polacz.php");
$query = mysql_query("insert into news values('','".$_POST['tytul']."',now(),'".$_POST['autor']."','".$_POST['tresc']."')");
?>