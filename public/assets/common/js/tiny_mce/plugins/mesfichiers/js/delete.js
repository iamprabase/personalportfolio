function createXHR() 
{
    var request = false;
        try {
            request = new ActiveXObject('Msxml2.XMLHTTP');
        }
        catch (err2) 
		{
            try {
                request = new ActiveXObject('Microsoft.XMLHTTP');
            }
			
            catch (err3) 
			{
			
			
		try {
			request = new XMLHttpRequest();
		}
		catch (err1) 
		{
			request = false;
		}
            }//Fin de catch(err3)
			
        }//Fin de catch(err2)
    return request;
	
}// Fin de fonction createXHR

function supprimer(id) 
{
	var xhr=createXHR();
	xhr.open("POST", "php/delete.php",true);
	xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhr.onreadystatechange = function()
	{ 
	if (xhr.readyState == 4 && xhr.status == 200) 
		{
			alert(xhr.responseText);
		}
	}
	var data="IDT="+id+"&supprimer=supprimer";
	xhr.send(data);


}




