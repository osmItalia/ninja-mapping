<?php include('header.php');?>
<div class="row">
    <div class="col-md-12">

<link rel="stylesheet" href="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.css" />
<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
<script src='https://api.tiles.mapbox.com/mapbox.js/plugins/leaflet-hash/v0.2.1/leaflet-hash.js'></script>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>

<style>
#map{
float:right; width:80%; height:100%; min-height:500px;
}

#show{
float:left; width:18%; min-height:500px;
padding:5px;
}
.b{font-weight:bold;}
.i{font-style:italic;
font-size:14px;}
</style>

<div id="show">
<h1>Radar</h1>
<?php if(!isset($_SESSION['event_id'])):?>
    <div class="alert alert-danger" role="alert">
    <p><a href="info.php" class="alert-link">Selezionare evento</a> nella configurazione prima di continuare</p>
    </div>
<?php endif;?>
<p class="i hide">Passa il mouse su un segnalino!</p>
    <p>Ultimo punto segnalato da:</p>
    <div id="dati"></div>
    <div class="hide">
        <hr/>
        <h3>GPS quality:</h3>
        <img src="img/marker_green.png" /> Inferiore a 10 metri<br />
        <img src="img/marker_yellow.png" /> Tra 10 e 20 metri<br />
        <img src="img/marker_red.png" /> Superiore a 20 metri<br />
        <img src="img/marker.png" /> Non pervenuta<br />
    </div>
</div>
<div id="map"></div>
<script>

/***  little hack starts here ***/
L.Map = L.Map.extend({
    openPopup: function(popup) {
        //        this.closePopup();  // just comment this
        this._popup = popup;

        return this.addLayer(popup).fire('popupopen', {
            popup: this._popup
        });
    }
}); /***  end of hack ***/

L.RotatedMarker = L.Marker.extend({
  options: { angle: 0 },
  _setPos: function(pos) {
    L.Marker.prototype._setPos.call(this, pos);
    if (L.DomUtil.TRANSFORM) {
      // use the CSS transform rule if available
      this._icon.style[L.DomUtil.TRANSFORM] += ' rotate(' + this.options.angle + 'deg)';
    } else if (L.Browser.ie) {
      // fallback for IE6, IE7, IE8
      var rad = this.options.angle * L.LatLng.DEG_TO_RAD,
      costheta = Math.cos(rad),
      sintheta = Math.sin(rad);
      this._icon.style.filter += ' progid:DXImageTransform.Microsoft.Matrix(sizingMethod=\'auto expand\', M11=' +
        costheta + ', M12=' + (-sintheta) + ', M21=' + sintheta + ', M22=' + costheta + ')';
    }
  }
});
L.rotatedMarker = function(pos, options) {
    return new L.RotatedMarker(pos, options);
};



var map = L.map('map').setView([42, 10], 5);

var Stamen = L.tileLayer('http://tile.stamen.com/toner/{z}/{x}/{y}.png', {
attribution: 'Stamen'
});

var Mapnik = L.tileLayer(
            'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            }).addTo(map);

var BaseMaps = {
    "Stamen": Stamen,
    "Mapnik": Mapnik
    };

L.control.layers(BaseMaps).addTo(map);


var hash = new L.Hash(map);


var dati_update = function (props) {
document.getElementById('dati').innerHTML = (props ? '<p class="b">'+  props.user_id +'</p><p  class="collapse">Ora: '+ props.timestamp +' <br>Altitudine: '+ props.altitude +' <br>Direzione: '+ props.direction +'°<br>Precisione: '+ props.accuracy +' m<br> Note:  '+ props.note +'</p>' : 'n/d');
};


var markers=[];
function getLayer(){
    $.getJSON('api/getEventLastPoint.php',{e:"<?php if(isset($_SESSION['event_id'])) echo $_SESSION['event_id'];?>"},function (res) {
        var f=res['features'];
        $(f).each(function(i,j){
            var id=j['properties']['user'];
            var coords=j['geometry']['coordinates'];
            if(markers[id]!==undefined){
                markers[id].setLatLng([coords[1],coords[0]]);
                return;
            }
            var ico = 'img/marker.png';
            if(j['properties']['accuracy'] < 20 )
                ico = 'img/marker_yellow.png';
            if(j['properties']['accuracy'] < 10 )
                ico = 'img/marker_green.png';
            if(j['properties']['accuracy'] >= 20 )
                ico = 'img/marker_red.png';
            var mar=L.rotatedMarker([coords[1],coords[0]],{
                icon: L.icon({
                    iconUrl: ico,
                    iconSize: [24,24],
                    })
                });
            markers[id]=mar;
            mar.bindPopup(id);


            mar.on('mouseover', function(e) {
                dati_update(j['properties']);
                });
            /*mar.on('mouseout', function(e) {
                dati_update();
                });
            */
            mar.options.angle = j['properties']['direction'];
            mar.addTo(map);

        });
    });
}

getLayer();
var stop=false; //bottone che toggla sta variabile per fermare il refresh
setInterval(
    function(){
        if(!stop) {
                getLayer();
            }
    },5000);

</script>

</div>
</div>
<?php include('footer.php');?>
