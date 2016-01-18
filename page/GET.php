<?php
if(isset($_GET['page']))
{
    switch($_GET['page'])
    {
        case "ajax" :  include_once 'page/ajax.php'; break;
        case "aktywacja" : include_once 'page/aktywacja.php'; break;
        default :
            if(file_exists("page/".$_GET['page'].".php"))
            {
                if($_GET['page']=="GET") include("page/mainpage.php");
                else include("page/".$_GET['page'].".php");
            }			
            else { include("page/mainpage.php"); }
            break;
    }
}