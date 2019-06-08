function LoginFunction()
{
var xhttp = new XMLHttpRequest();

xhttp.open("POST","phpFunctions/loginRequest.php",true);

xhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded");

xhttp.onreadystatechange = function()
{
	if (this.readyState == 4 && this.status == 200) 
	{
		var response = this.responseText;
		alert(document.getElementById('rememberMe').value);
		if(response.trim() == "-2")
		{
			alert("there was an error while connecting to the database");
		}
		else 
		{
			if(response.trim() == "-1")
			{
				var reEmpty = document.getElementById('loginPassword');

				reEmpty.value = "";

				var reEmpty = document.getElementById('loginUsername');

				reEmpty.value = "";

				var querryResult =  document.getElementById('querryResult');

				querryResult.innerHTML = "Wrong Username or Password";

				setTimeout(function()
				{
					querryResult.innerHTML = "";
				},3000);
			}
			else
			{
				window.location.replace("map.php");
			}
		}	
		
	}
}

var values = "username=" + document.getElementById('loginUsername').value + "&password=" + document.getElementById('loginPassword').value + "&remember=" + document.getElementById('rememberMe').value;

xhttp.send(values);

}