//check  for input validity and send to backend request to create new supervisor account

function RegisterFunction()
{
var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/registerRequest.php",true);

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
				response.innerHTML = "The email is already used";
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

var values = "username=" + document.getElementById("registerUsername").value + "&email="+ document.getElementById("registerEmail").value;

xhttp.send(values);
}

function ifValid()
{
	var isOk=0;
	if(VerifyLength() == true)
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
	if(VerifyEmail() == true)
	{
		isOk++;
	}
	else
	{
		isOk=0;
	}
	if(isOk == 3)
	{
		document.getElementById("registerButton").disabled = false;
	}
}

function VerifyLength()
{
	var input = document.getElementById("registerUsername").value;
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
		document.getElementById("registerButton").disabled = true;
		return false;
	}
}

function VerifyNotChild()
{
	var input = document.getElementById("registerUsername").value;
	var rule = document.getElementById("notChild").style;
	if(!input.includes("_child"))
	{
		rule.setProperty("color","green");
		return true;
	}
		else
	{
		rule.setProperty("color","red");
		document.getElementById("registerButton").disabled = true;
		return false;
	}
}


function VerifyEmail()
{
	var input = document.getElementById("registerEmail").value;
	var rule = document.getElementById("validEmail").style;
	rule.setProperty("color","red");
	var regex = /^((?:\w)|(?:\d)|!|&|_|\$|\.|-){2,}@((?:\w)|(?:\d)|\.|!|&|_|\$|-){2,}\.((?:\w)|(?:\d)|!|&|_|\$|\.|-){2,}$/;
	if(regex.test(input))
	{
		rule.setProperty("color","green");
		return true;
	}
	else
	{
		rule.setProperty("color","red");
		document.getElementById("registerButton").disabled = true;
		return false;
	}
}