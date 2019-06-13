const map = new ol.Map({
  target: 'map-container',
  layers: [
    new ol.layer.Tile({
      source: new ol.source.OSM()
    })
  ],
  view: new ol.View({
    center: ol.proj.fromLonLat([0, 0]),
    zoom: 2
  })
});

const source = new ol.source.Vector();

const layer = new ol.layer.Vector({
  source: source

});

function clearDangerSpots()
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/clearDangerSpots.php",true);

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
		}
	}
	xhttp.send();
}

clearDangerSpots();

map.addLayer(layer);

var supervisor;
var lastUpdate = Date.now();

navigator.geolocation.watchPosition(function(pos) {
  var coords = [pos.coords.longitude, pos.coords.latitude];
   supervisor = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(coords))
      });
	  supervisor.setId("supervisor");
	  supervisor.setStyle(new ol.style.Style({
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
		source.removeFeature(source.getFeatureById("supervisor"));
	}
	catch(e)
	{
		 console.log(e);
	}
	source.addFeature(supervisor);
	if(Math.floor((Date.now()-lastUpdate)/1000) >= 3)//update once every 3 seconds maximum 
	{
		sendUpdate(pos.coords.longitude.toString() + "," + pos.coords.latitude.toString());
		lastUpdate = Date.now();
	}
}, function(error) {
  alert('ERROR: Error on location, are you on the secure link? (https)');
}, {
  enableHighAccuracy: true
});

const locate = document.createElement('div');
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

map.addControl(new ol.control.Control({
  element: locate
}));



function sendUpdate(coordinates)
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/updateTimeSupervisor.php",true);

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
	xhttp.send("coords="+coords + "&distance=" + document.getElementById("distance").value+ "&range=" + document.getElementById("dangerRange").value);
}



function addChildren()
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/addChildernOnMap.php",true);

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
					showChildOnMap(sub[0],sub[1]);
				}
				
			}
		}
	}
	xhttp.send();
}



function showChildOnMap(name,coordinates)
{
	coordinates = coordinates.split(',');
	coordinates[1] = parseFloat(coordinates[1]);
	coordinates[0] = parseFloat(coordinates[0]);
	var child = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([coordinates[0], coordinates[1]]))
      });
	child.setId(name);
	  child.setStyle(new ol.style.Style({
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
	source.addFeature(child);
}


setInterval(function() {
	  addChildren();
}, 3000);

var dblClickInteraction;
// find DoubleClickZoom interaction
map.getInteractions().getArray().forEach(function(interaction) {
  if (interaction instanceof ol.interaction.DoubleClickZoom) {
    dblClickInteraction = interaction;
  }
});
// remove from map
map.removeInteraction(dblClickInteraction);




const sourceDanger = new ol.source.Vector();

const layerDanger = new ol.layer.Vector({
  source: sourceDanger

});

map.addLayer(layerDanger);

var dangerNumber = 0;
map.on('singleclick', function(evt){
    var coord = evt.coordinate;
	coord = ol.proj.transform(coord, 'EPSG:3857', 'EPSG:4326');
	writeDangerToDatabase(coord);
	var danger = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat(coord))
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
				text: "danger" + dangerNumber
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
});
	
map.on('dblclick', function (e) {
	
	e = ol.proj.transform(e.coordinate, 'EPSG:3857', 'EPSG:4326');
    var features = map.getFeaturesAtPixel(map.getPixelFromCoordinate(ol.proj.fromLonLat(e) ));
	e=ol.proj.transform(features[0].getGeometry().getCoordinates(), 'EPSG:3857', 'EPSG:4326');
	deleteDangerFromDatabase(e);
    if (features!= null) {
       sourceDanger.removeFeature(sourceDanger.getFeatureById(features[0].getId()));
    }
});


function writeDangerToDatabase(coords)
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/writeDanger.php",true);

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
		}
	}
	xhttp.send("coords=" + coords);
}


function deleteDangerFromDatabase(coords)
{
	var xhttp = new XMLHttpRequest();

	xhttp.open("POST","phpFunctions/deleteDanger.php",true);

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
		}
	}
	xhttp.send("coords=" + coords);
}

