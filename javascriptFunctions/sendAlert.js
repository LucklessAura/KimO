function sendAlert(code)
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/sendAlert.php",true);

	xhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded");
	
	xhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200) 
		{
			var response = this.responseText;
			if(response.trim() == "-2")
			{
				alert("there was an error while connecting to the database");
			}
			else 
			{
				if(response.trim() == "-1")
				{
					alert("You have no supervisor assigned");
				}
				else
				{
					if(code != "5")
					{
						var aux = document.getElementById('alertMessage');
						aux.innerHTML = "Alert sent";
					}
					else
					{
						var aux = document.getElementById('alertMessage');
						aux.innerHTML = "You are going too far, a supervisor has been alerted";
					}
					
				}
			}
		}
	}
	xhttp.send("code=" + code);
}