<?php
/*
STUB
- auth
- ajax submission in sendpoint
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
	var timestamp=geoObj['timestamp'];
	var coords=geoObj['coords'];
	var lat=coords['lat'];
	var lon=coords['lon'];
	var accuracy=coords['accuracy'];
	var altitude=coords['altitude'];
	var speed=coords['speed'];
	var direction=coords['heading'];
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
