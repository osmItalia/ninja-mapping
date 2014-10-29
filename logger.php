<?php include('header.php');?>
    <div class="row">
     <div class="col-md-12">

<?php if( !isset( $_SESSION['event_id'])): ?>
	<div class="alert alert-danger" role="alert">
	<p><a href="info.php" class="alert-link">Selezionare evento</a> nella configurazione prima di continuare</p>
	</div>
<?php else: ?>
	<div class="control-group">
	  <div class="controls">
	    <div class="form-inline">
	      <input id="note" value="" class="form-control" placeholder="Insert note" type="text"/>
	        <button onclick="submitData()" class="btn btn-default">Submit Point</button>
	    </div>
	    <label class="checkbox" for="togglePos">
	      <input type="checkbox" name="togglePos" id="togglePos" value=""  onclick="logPosition()">
	      Track Position
	    </label>
<?php endif; ?>	
  </div>
</div>

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
	document.getElementById('note').value='';
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
        var direction = (isNaN(geoObj.coords.heading)) ? -1 : geoObj.coords.heading ;
		
		var uid=<?php echo $a->getUid(); ?>;
		var eid=<?php if(isset( $_SESSION['event_id'])) echo  $_SESSION['event_id']; else echo "-1"; ?>;
		// user_id e event_id saranno presi in fase di autenticazione dell'utente
		var req='uid='+uid+'&eid='+eid+'&lat='+lat+'&lon='+lon+'&ts='+timestamp+'&prec='+accuracy+'&sp='+sp+'&alt='+alt+'&dir='+direction+'&note='+note;

		request = new XMLHttpRequest();
		request.open('GET', 't.php?'+req, true);

		request.onload = function() {
		  if (request.status >= 200 && request.status < 400){
			resp = request.responseText;
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
        </div>
     </div>
<?php include('footer.php');?>
