function zmiana_clasy_i_wartosci(id,value)
{
	if (value==1)
	{
		document.getElementById(id).className = "widoczny";
		document.getElementById(id).value = "1";
	}
	else
	{
		document.getElementById(id).className = "ukryty";
		document.getElementById(id).value = "0";
	}
}
function zmiania_widocznosci(idelementu,id1,id2)
{
	if (window.XMLHttpRequest) { xmlhttp = new XMLHttpRequest();  /*code for IE7+, Firefox, Chrome, Opera, Safari*/ }
	else { xmlhttp = new ActiveXObject("Microsoft.XMLHTTP"); /*code for IE6, IE5*/ }
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var x= xmlhttp.responseText;
			switch(x)
			{
				case "10":
					zmiana_clasy_i_wartosci(id1,"1");
					zmiana_clasy_i_wartosci(id2,"0");
					break;
				case "01":
					zmiana_clasy_i_wartosci(id1,"0");
					zmiana_clasy_i_wartosci(id2,"1");
					break;
				case "11":
					zmiana_clasy_i_wartosci(id1,"1");
					zmiana_clasy_i_wartosci(id2,"1");
					break;
				default : /*00*/
				{
					zmiana_clasy_i_wartosci(id1,"0");
					zmiana_clasy_i_wartosci(id2,"0");
				}
			}
		}
	}
	xmlhttp.open("GET","page/ajax.php?funkcja=visible&"+idelementu+"="+(document.getElementById(idelementu).value));
	xmlhttp.send();
}


