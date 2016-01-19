<?php
if(isset($_GET['page']))
{
    switch($_GET['page'])
    {
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