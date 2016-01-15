<?php
if(isset($_GET['page']))
{
	if(!$wyswietlona_strona)
	{
		if(file_exists("page/".$_GET['page'].".php"))
		{
			if($_GET['page']=="GET") include("page/mainpage.php");
			else include("page/".$_GET['page'].".php");
		}			
		else { include("page/mainpage.php"); }
		$wyswietlona_strona=true;
	}
}


	
?>