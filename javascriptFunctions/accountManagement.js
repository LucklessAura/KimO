function logOut()
{
	var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/logOut.php",true);

xhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded");

xhttp.onreadystatechange = function()
{
	if (this.readyState == 4 && this.status == 200) 
	{
		window.location.replace("index.php");
	}
}
xhttp.send();
}



function issueResetCode()
{
var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/issueResetCode.php",true);

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
				response.innerHTML = "The user id is not in the database";
				setTimeout(function()
				{
					response.innerHTML = "";
					
				},3000);
				break;
			}
			case("-3"):
			{
				response.innerHTML = "Unknown error";
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
var val = "username=" +document.getElementById("username").value;
xhttp.send(val);
}




function ResetPass()
{
	window.location.replace("resetPass.php");
}

function changePasswordRequest()
{
var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/changePasswordRequest.php",true);

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
				window.location.replace("index.php");
			}
			case("1"):
			{
				response.innerHTML = "Password changed";
				setTimeout(function()
				{
					response.innerHTML = "";
					
				},3000);
				break;
			}
		}
	}
}
var link = window.location.href;
link = link.split(/\=(.+)/)[1];
var val = "password=" + document.getElementById("newPassword").value + "&code=" + link;
xhttp.send(val);	
}




function seeIfValid()
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
	if(VerifyUpperCase() == true)
	{
		isOk++;
	}
	else
	{
		isOk=0;
	}
	if(VerifyLowerCase() == true)
	{
		isOk++;
	}
	else
	{
		isOk=0;
	}
	if(VerifyNumber() == true)
	{
		isOk++;
	}
	else
	{
		isOk=0;
	}
	if(VerifySymbol() == true)
	{
		isOk++;
	}
	else
	{
		isOk=0;
	}
	if(isOk == 5)
	{
		document.getElementById("changePassword").disabled = false;
	}
}


function VerifyLength()
{
	var input = document.getElementById("newPassword").value;
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
		document.getElementById("changePassword").disabled = true;
		return false;
	}
}


function VerifyUpperCase()
{
	var input = document.getElementById("newPassword").value;
	var rule = document.getElementById("hasUpperCase").style;

	rule.setProperty("color","red");
	var regex = /(?=.*[A-Z])/;
	if(regex.test(input))
	{
		rule.setProperty("color","green");
		return true;
	}
	else
	{
		rule.setProperty("color","red");
		document.getElementById("changePassword").disabled = true;
		return false;
	}
}

function VerifyLowerCase()
{
	var input = document.getElementById("newPassword").value;
	var rule = document.getElementById("hasLowerCase").style;

	rule.setProperty("color","red");
	var regex = /(?=.*[a-z])/;
	if(regex.test(input))
	{
		rule.setProperty("color","green");
		return true;
	}
	else
	{
		rule.setProperty("color","red");
		document.getElementById("changePassword").disabled = true;
		return false;
	}
}

function VerifyNumber()
{
	var input = document.getElementById("newPassword").value;
	var rule = document.getElementById("hasNumber").style;

	rule.setProperty("color","red");
	var regex = /(?=.*\d)/;
	if(regex.test(input))
	{
		rule.setProperty("color","green");
		return true;
	}
	else
	{
		rule.setProperty("color","red");
		document.getElementById("changePassword").disabled = true;
		return false;
	}
}

function VerifySymbol()
{
	var input = document.getElementById("newPassword").value;
	var rule = document.getElementById("hasSymbol").style;

	rule.setProperty("color","red");
	var regex = /(?=.*(-|!|&|\.|\$))/;
	if(regex.test(input))
	{
		rule.setProperty("color","green");
		return true;
	}
	else
	{
		rule.setProperty("color","red");
		document.getElementById("changePassword").disabled = true;
		return false;
	}
}