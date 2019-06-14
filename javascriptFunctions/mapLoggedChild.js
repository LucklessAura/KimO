const map = new ol.Map({//create a map object
  target: 'map-container',
  layers: [
    new ol.layer.Tile({
      source: new ol.source.OSM()
    })
  ],
  view: new ol.View({
    center: ol.proj.fromLonLat([0, 0]), //coordinates at the center of the view will be [0.000,0.000]
    zoom: 2
  })
});

const source = new ol.source.Vector(); // source of features to be applied to a layer (only features will be the supervisor and the logged child)

const layer = new ol.layer.Vector({ // layer where the person logged is attached
  source: source

});

map.addLayer(layer); // add the layer to the map

var me; //object representing current user
var lastUpdate = Date.now(); // for a cooldown on map updates

navigator.geolocation.watchPosition(function(pos) { // pos is retrned by watchPosition
  var coords = [pos.coords.longitude, pos.coords.latitude]; //take the coordinates
   me = new ol.Feature({ 
        geometry: new ol.geom.Point(ol.proj.fromLonLat(coords)) // apply them to the feature 
      });
	  me.setId("me"); // set an ID
	  me.setStyle(new ol.style.Style({ //styling 
        image: new ol.style.Icon(({
            color: '#ffcd46',
            crossOrigin: 'anonymous',
            src: 'https://raw.githubusercontent.com/LucklessAura/KimO/master/images/you.png',
			scale:0.03,
			
        })),
		text: new ol.style.Text({
				font: "Courier new 25px",	
				fill: new ol.style.Fill({ color: '#c1c1c1' }),
				text: 'You'
			  })
    }));
	try{
		source.removeFeature(source.getFeatureById("me")); // remove feature if it has the same id as 'me', first time the map start ther will be a null error
	}
	catch(e)
	{
		 console.log(e);
	}
	source.addFeature(me); // add feature with new coordinates
	if(Math.floor((Date.now()-lastUpdate)/1000) > 3)//update database once every 3 seconds maximum 
	{
		sendUpdate(pos.coords.longitude.toString() + "," + pos.coords.latitude.toString());
		lastUpdate = Date.now();
	}
}, function(error) {
  alert('ERROR: Error on location, are you on the secure link? (https), do you have the gps on?');
}, {
  enableHighAccuracy: true
});

const locate = document.createElement('div'); //map control buttons
locate.className = 'ol-control ol-unselectable locate';
locate.innerHTML = '<button title="Locate me">◎</button>';
locate.addEventListener('click', function() {
  if (!source.isEmpty()) {
    map.getView().fit(source.getExtent(), {
      maxZoom: 18,
      duration: 500
    });
  }
});

map.addControl(new ol.control.Control({ // add them to the map
  element: locate
}));



function sendUpdate(coordinates) // update database with new coordinates
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/updateChild.php",true);

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
				console.log("updated time");
			}
		}
	}
	
	var coords = coordinates;
	
	xhttp.send("coords=" + coords);
}

var maxdist=1000000;

function addSupervisors() // get assigned supervisor coordinates
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/addSupervisorsOnMap.php",true);

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
				var array = response.split('&');
				for(var i =0;i<array.length-1;i++)
				{
					var sub = array[i];
					sub = sub.split(';');
					showSupervisorsOnMap(sub[0],sub[1]);
					maxdist = parseInt(sub[2]); //get max distance permitted from him
				}
				
			}
		}
	}
	xhttp.send();
}

const sourceDanger = new ol.source.Vector(); // source where danger type features will be added

const layerDanger = new ol.layer.Vector({ // layer where the features will be shown
  source: sourceDanger

});

map.addLayer(layerDanger); // add danger layer to the map

function showSupervisorsOnMap(name,coordinates)// create new supervisor object, delete the old one, add the new one to the layer
{
	coordinates = coordinates.split(',');
	coordinates[1] = parseFloat(coordinates[1]);
	coordinates[0] = parseFloat(coordinates[0]);
	var supervisor = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([coordinates[0], coordinates[1]]))
      });
	supervisor.setId(name);
	  supervisor.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
            color: '#ffcd46',
            crossOrigin: 'anonymous',
            src: 'https://raw.githubusercontent.com/LucklessAura/KimO/master/images/baby.png',
			scale:0.06,
			
        })),
		text: new ol.style.Text({
				font: "Courier new 25px",	
				fill: new ol.style.Fill({ color: '#414141' }),
				text: name
			  })
    }));
	try
	{
	source.removeFeature(source.getFeatureById(name));
	}
	catch(e)
	{
		console.log(e);
	}
	source.addFeature(supervisor);
	if(distanceBetweenPoints(me,supervisor) > parseInt(maxdist))// check if distance is greater than permited if it is send an alert to the supervisor
	{
		sendAlert(5);
	}
}

function distanceBetweenPoints(point1, point2){ // distance calculations between 2 points using a 3D globe replica
        return parseInt(ol.sphere.getDistance(ol.proj.transform(point1.getGeometry().getCoordinates(), 'EPSG:3857', 'EPSG:4326'), ol.proj.transform(point2.getGeometry().getCoordinates(), 'EPSG:3857', 'EPSG:4326'), ol.proj.Projection("WGS84")));
    }


setInterval(function() {
	  addSupervisors();
}, 3000); // 1 update each 3 seconds max

var maxDangerDist = 1000000;

function isNearDanger() // check if logged child is in the area of any danger point on map
{
	var features=[];
	features = layerDanger.getSource().getFeatures();
	for(var feature in features)
	{
		feature = layerDanger.getSource().getFeatureById("danger" + feature);
		if(distanceBetweenPoints(feature,me) < maxDangerDist)
		{
			return true;
		}
	}
	return false;
}

setInterval(function() {
	if(isNearDanger() == true) // if near danger send alert
	{
		sendAlert(7);
	}
}, 3000);


function addDangerSpots() // get coordinates of all danger points 
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/addDangerSpotsOnMap.php",true);

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
				sourceDanger.clear(); // delete all danger points from the danger layer
				dangerNumber=0;
				var array = response.split('&'); // split string in multiple coordinates 
				maxDangerDist = parseInt(array[0]);
				for(var i =1;i<array.length-1;i++)
				{
					showDangerSpotsOnMap(array[i]);
				}
				
			}
		}
	}
	xhttp.send();
}

var dangerNumber=0;

function showDangerSpotsOnMap(coordinates) // add them to the layer
{
	coordinates = coordinates.split(',');
	coordinates[1] = parseFloat(coordinates[1]);
	coordinates[0] = parseFloat(coordinates[0]);
	var danger = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([coordinates[0], coordinates[1]]))
      });
	danger.setId("danger" + dangerNumber);
	  danger.setStyle(new ol.style.Style({
        image: new ol.style.Icon(({
            color: '#ffcd46',
            crossOrigin: 'anonymous',
            src: 'https://raw.githubusercontent.com/LucklessAura/KimO/master/images/danger.png',
			scale:0.06,
			
        })),
		text: new ol.style.Text({
				font: "Courier new 25px",	
				fill: new ol.style.Fill({ color: '#414141' }),
				text: name
			  })
    }));
	try
	{
	sourceDanger.removeFeature(sourceDanger.getFeatureById("danger" + dangerNumber));
	}
	catch(e)
	{
		console.log(e);
	}
	sourceDanger.addFeature(danger);
	dangerNumber++;
}



setInterval(function() {
	  addDangerSpots();
}, 3000);