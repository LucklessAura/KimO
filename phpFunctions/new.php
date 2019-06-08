<!DOCTYPE html>
<html>

    <head>
    </head>    
    
    <body>
        <script>
            var response;
            var xhttp = new XMLHttpRequest();
            xhttp.open("POST","new.php",true);
            xhttp.setRequestHeader("Content-Type" , "application/x-www-form-urlencoded");
            
            function getLocation() {
                if(navigator.geolocation)
                {
                    navigator.geolocation.watchPosition(showPosition);
                }
                else
                {
                    alert("Geolocation not supported");
                }
            }
            function showPosition()
            {
               vars = "latitude=" + position.coords.latitude +
                "&longitude=" + position.coords.longitude;
		xhttp.send(vars);
            }
            getLocation();
        </script>
        
        <?php
            if (isset($_POST['longitude'])) { echo $_POST['longitude'] . '\n' . $_POST['latitude']; }
        ?>
    </body>    
    
</html>