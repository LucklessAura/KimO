function newChildFunction()
{
var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/addChildRequest.php",true);

xhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded");

xhttp.onreadystatechange = function()
{
	if (this.readyState == 4 && this.status == 200) 
	{
		var backendResponse = this.responseText;
		var response = document.getElementById("response");
		switch(backendResponse.trim())
		{
			case("-2"):
			{
				alert("there was an error while connecting to the database");
				break;
			}
			case("-1"):
			{
				response.innerHTML = "The username is already used";
				setTimeout(function()
				{
					response.innerHTML = "";
					
				},3000);
				break;
			}
			case("-3"):
			{
				response.innerHTML = "You have no email in the database";
				setTimeout(function()
				{
					response.innerHTML = "";
					
				},3000);
				break;
			}
			case("1"):
			{
				response.innerHTML = "An email has been sent to your adress";
				setTimeout(function()
				{
					response.innerHTML = "";
					
				},3000);
				break;
			}
		}
	}
}

var values = "username=" + document.getElementById("childUsername").value;

xhttp.send(values);


}



function ifValid()
{
	var isOk=0;
	if(VerifyTheLength() == true)
	{
		isOk++;
	}
	else
	{
		isOk=0;
	}
	if(VerifyNotChild() == true)
	{
		isOk++;
	}
	else
	{
		isOk=0;
	}
	if(isOk == 2)
	{
		document.getElementById("addChild").disabled = false;
	}
}

function VerifyTheLength()
{
	var input = document.getElementById("childUsername").value;
	var rule = document.getElementById("validLong").style;

	rule.setProperty("color","red");
	var regex = /^((?:\w)|(?:\d)|-|!|&|\.|\$){6,20}$/;
	if(regex.test(input))
	{
		rule.setProperty("color","green");
		return true;
	}
	else
	{
		rule.setProperty("color","red");
		document.getElementById("addChild").disabled = true;
		return false;
	}
}

function VerifyNotChild()
{
	var input = document.getElementById("childUsername").value;
	var rule = document.getElementById("notChild").style;
	if(!input.includes("_child"))
	{
		rule.setProperty("color","green");
		return true;
	}
		else
	{
		rule.setProperty("color","red");
		document.getElementById("addChild").disabled = true;
		return false;
	}
}

