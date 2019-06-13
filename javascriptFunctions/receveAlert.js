
function receveAlert()
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/readAlert.php",true);

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
					console.log("No alerts found");
				}
				else
				{

					var array = response.split('&');
					for(var i =0;i<array.length-1;i++)
					{
													
							var sub = array[i];
							sub = sub.split(';');
							switch(sub[1])
							{
								case ("1"):
								{
									document.getElementById('alert').play();
									alert(sub[0] + " sent stranger danger alert");
									break;
								}
								case ("2"):
								{
									document.getElementById('alert').play();
									alert(sub[0] + " was hit by a car");
									break;
								}
								case ("3"):
								{
									document.getElementById('alert').play();
									alert(sub[0] + " hurt himself");
									break;
								}
								case ("4"):
								{
									document.getElementById('alert').play();
									alert(sub[0] +  " is lost");
									break;
								}
								case ("5"):
								{
									document.getElementById('alert').play();
									alert(sub[0] +  " is getting too far from you");
									break;
								}
								case ("7"):
								{
									document.getElementById('alert').play();
									alert(sub[0] +  " is near danger");
									break;
								}
								default:
								{
									document.getElementById('alert').play();
									alert(sub[0] +  "sent a SOS message");
									break;
								}
							}
					}
				}
			}
		}
	}
	xhttp.send();
}


setInterval(function() {
	  receveAlert();
}, 3000);
