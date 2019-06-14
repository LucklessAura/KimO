//send to backend a new alert to be put in the database


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
					if(code != "5" && code !="7")
					{
						var aux = document.getElementById('alertMessage');
						aux.innerHTML = "Alert sent";
						setTimeout(function()
						{
							aux.innerHTML = "";
							
						},3000);
					}
					else
					{
						if(code == "7")
						{
							document.getElementById('alert').play();
							alert("You are near danger");
						}
						else
						{
							document.getElementById('alert').play();
							alert("You are going too far, a supervisor has been alerted");
						}
					}
					
				}
			}
		}
	}
	xhttp.send("code=" + code);
}