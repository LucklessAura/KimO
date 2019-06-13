function childrenDetails()
{
var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/childrenDetailsRequest.php",true);

xhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded");

xhttp.onreadystatechange = function()
{
	if (this.readyState == 4 && this.status == 200) 
	{
		var response = this.responseText;
		switch(response.trim())
		{
			case("-2"):
			{
				var querryResult =  document.getElementById('response');

				querryResult.innerHTML = "A database error occured";
				setTimeout(function()
				{
					querryResult.innerHTML = "";
					
				},3000);
				break;
			}
			case("-1"):
			{
				alert("You are not logged as a supervisor");
				window.location.replace("login.php");
				break;
			}
			default:
			{
				response = response.split('&');
				var node = document.getElementById('mainSection');
				for(var i=0;i<response.length-1;i++)
				{
					var indInfo=response[i].split(';');
					var div = document.createElement('div');
					div.setAttribute("id", "childDetails");
					
					
					var newH = document.createElement('h2');
				    var newNode = document.createElement('p');
					newH.appendChild(document.createTextNode("Username"));
					newNode.appendChild(document.createTextNode(indInfo[0]));
					div.appendChild(newH);
					div.appendChild(newNode);
				
					newH = document.createElement('h2');
				    newNode = document.createElement('p');
					newH.appendChild(document.createTextNode("Last Location"));
					newNode.appendChild(document.createTextNode(indInfo[1]));
					div.appendChild(newH);
					div.appendChild(newNode);
					
					newH = document.createElement('h2');
				    newNode = document.createElement('p');
					newH.appendChild(document.createTextNode("Last Online"));
					newNode.appendChild(document.createTextNode(indInfo[2]));
					div.appendChild(newH);
					div.appendChild(newNode);
					node.appendChild(div);
				}
				break;
			}
		}
	}
}

xhttp.send();

}


childrenDetails();