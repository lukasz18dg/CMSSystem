<?php

if(isset($_GET['funkcja']))
{
echo "11";	
$message = "teststetet";
// In case any of our lines are larger than 70 characters, we should use wordwrap()
$message = wordwrap($message, 70, "\r\n");
// Send
mail('lukasz18dg@gmail.com', 'My Subject', $message);

}