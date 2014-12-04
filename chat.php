<?php
include('header.php');
?>

<style>
.bubble{width:50%; border:1px solid blue; clear:both;}
.bubble .timestamp{font-style:italic;}
.bubble .person{font-weight:bold;}
</style>
<div class="row">
    <div class="col-md-12">
        <h1>Chat</h1>
<?php if(!isset($_SESSION['event_id'])):?>
    <div class="alert alert-danger" role="alert">
    <p><a href="info.php" class="alert-link">Selezionare evento</a> nella configurazione prima di continuare</p>
    </div>
<?php else:?>
        <div id="chatMessages">

        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <form class="form-inline">
        <input type="text" class="form-control" style="min-width:40%" id="msg" name="msg" value=""/>
        <input type="button" class="btn btn-default" id="sendMsg" value="Send" onClick="sendMessage()"/>
        </form>
    </div>
</div>
</div>
<script>
var nowTime=0;
function sendMessage(){
 var message=$('#msg').val();
 $.get('chat/postMessage.php', {'m':message},function(){getLatestMessages();});
 $('#msg').val('');
}
function getOldMessages(){
    nowTime= Math.floor(Date.now()/1000);
    $.get('chat/getPreviousMessages.php', {'ts': nowTime},function(answer){
	if(!$.isPlainObject(answer))
	{
	console.log(answer);
	return;
	}
	
	$.each(answer,function(i,t){
		var msg=formatBubble(t['timestamp'],t['author_name'],t['message']);
		$('#chatMessages').append(msg);
	});
	});
}

function getLatestMessages(){
    $.get('chat/getLatestMessages.php', {'ts': nowTime},function(answer){
	if(!$.isPlainObject(answer))
	{
	console.log(answer);
	return;
	}
	
	$.each(answer,function(i,t){
		var msg=formatBubble(t['timestamp'],t['author_name'],t['message']);
		$('#chatMessages').append(msg);
	});
	});
    nowTime= Math.floor(Date.now()/1000);
}

function formatBubble(timestamp,person,message){
      var date=new Date(timestamp*1000);
	  var dateString=date.getDate()+'/'+(date.getMonth()+1)+'/'+date.getYear();
	  dateString+=' '+date.getHours()+':'+date.getMinutes()+':'+date.getSeconds();
      var bubble='<div class="bubble">';
      bubble+='<p class="head"><span class="timestamp">'+dateString+'</span> - <span class="person">'+person+'</span> wrote:</p>';
      bubble+='<p class="message">'++'</p>';
      bubble+='</div>';
}

window.onload=function(){
getOldMessages();
};
window.setInterval(function(){ getLatestMessages(); }, 3000);
</script>
<?php endif; ?>
<?php include('footer.php');?>
