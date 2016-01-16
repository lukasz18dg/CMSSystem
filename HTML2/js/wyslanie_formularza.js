function scmw(nazwa_formularza,id1,id2)
/*sprawdz_czy_mozesz_wysylac*/
{
    
    
    if(parseInt(document.getElementById(id1).getAttribute("value")))
        if(parseInt(document.getElementById(id2).getAttribute("value"))) 
            { document.getElementById(nazwa_formularza).submit(); }
            else { alert('Formularzu nie można wysłać. Proszę poprawić formularz.'); }
}