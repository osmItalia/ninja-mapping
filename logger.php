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
        var timestamp= (typeof geoObj.timestamp != undefined) ? geoObj.timestamp : '';
        var lat = (typeof geoObj.coords.latitude != undefined) ? geoObj.coords.latitude : '';
        var lon = (typeof geoObj.coords.longitude != undefined) ? geoObj.coords.longitude : '';
        var alt = (typeof geoObj.coords.altitude != undefined) ? geoObj.coords.altitude : '';
        var accuracy = (typeof geoObj.coords.accuracy != undefined) ? geoObj.coords.accuracy : '';
        var sp = (typeof geoObj.coords.speed != undefined) ? geoObj.coords.speed : '';
        var direction =  (typeof geoObj.coords.heading != undefined) ? geoObj.coords.heading : '';
		
		var uid=1;
		var req='uid='+uid+'&lat='+lat+'&lon='+lon+'&ts='+timestamp+'&prec='+accuracy+'&sp='+sp+'&alt='+alt+'&dir='+direction+'&nota='+note;

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
