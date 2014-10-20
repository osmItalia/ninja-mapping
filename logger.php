<?php
/*
STUB
- auth
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<input type="text" id="note" value=""/>
<button onclick="submitData()">Submit Point</button>
<br/>
<input type="checkbox" id="togglePos" onclick="logPosition()"/><label for="togglePos">Track Position</label>
<script>
var options={
	enableHighAccuracy: true,
	maximumAge: 0,
	timeout: 5000
}

var idWatch=0;

function submitData(){
	navigator.geolocation.getCurrentPosition(currentSuccess,echoError,options);
}

function currentSuccess(pos){
	var note=document.getElementById('note').value;
	sendPoint(pos,note);
}

function logPosition(){
	if(document.getElementById('togglePos').checked)
	{
		if ("geolocation" in navigator)
		{
			idWatch=navigator.geolocation.watchPosition(watchSuccess,echoError,options);
		}
		else
		{
			console.log('no geolocation');
		}
	}
	else{
		navigator.geolocation.clearWatch(idWatch);
	}
}

function sendPoint(geoObj,note)
{
		var timestamp,lat,lon,alt,accuracy,sp,direction;

        timestamp= (geoObj.timestamp != null) ? geoObj.timestamp : -1;
        lat = (geoObj.coords.latitude != null) ? geoObj.coords.latitude : -1;
        lon = (geoObj.coords.longitude != null) ? geoObj.coords.longitude : -1;
        alt = (geoObj.coords.altitude != null) ? geoObj.coords.altitude : -1;
        accuracy = (geoObj.coords.accuracy != null) ? geoObj.coords.accuracy : -1;
        sp = (geoObj.coords.speed != null) ? geoObj.coords.speed : -1;
        direction =  (geoObj.coords.heading != null) ? geoObj.coords.heading : -1;
		
		var uid=1;
		var eid=1;
		// user_id e event_id saranno presi in fase di autenticazione dell'utente
		var req='uid='+uid+'&eid='+eid+'&lat='+lat+'&lon='+lon+'&ts='+timestamp+'&prec='+accuracy+'&sp='+sp+'&alt='+alt+'&dir='+direction+'&nota='+note;
		
		console.log(geoObj);
		console.log(req);
		request = new XMLHttpRequest();
		request.open('GET', 't.php?'+req, true);

		request.onload = function() {
		  if (request.status >= 200 && request.status < 400){
			resp = request.responseText;
			console.log(resp);
		  } else {console.log('error');}
		};
		request.onerror = function() {console.log('req error');};
		request.send();
}


function watchSuccess(pos){
	sendPoint(pos,'');
}
function echoError(err){
	console.log(err);
}
</script>
</body>
</html>
