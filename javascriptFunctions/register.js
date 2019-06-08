function RegisterFunction()
{
	/*
var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/loginRequest.php",true);

xhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded");

xhttp.onreadystatechange = function()
{
	if (this.readyState == 4 && this.status == 200) 
	{
		
	}
}

var values = ;

xhttp.send(values);
*/



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
	}
	else
	{
		rule.setProperty("color","red");
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
	}
	else
	{
		rule.setProperty("color","red");
	}
}