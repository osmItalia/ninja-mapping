<?php
include('header.php');
?>

<style>
.bubble{width:50%; border:1px solid blue;}
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
<?php elseif:?>
        <div id="chatMessages">
        <div class="bubble">
            <p class="head"><span class="timestamp">3949848293832</span> - <span class="person">Antani</span> wrote:</p>
            <p class="message">Prematurata a destra</p>
        </div>
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
 $.get('chat/postMessage.php', {'m':message},function(){});
 $('#msg').val('');
}
function getOldMessages(){
    nowTime= Math.floor(Date.now()/1000);
    $.get('chat/getPreviousMessages.php', {'ts': nowTime},function(answer){console.log(answer)});
    //nel db eventid->event_id, aggiungere author_name (in post basta recuperarlo da ulogin)
}

function getLatestMessages(){
    $.get('chat/getLatestMessages.php', {'ts': nowTime},function(answer){console.log(answer)});
    nowTime= Math.floor(Date.now()/1000);
}
window.onload=function(){
getOldMessages();
};
window.setInterval(function(){ getLatestMessages(); }, 3000);
</script>
<?php endif; ?>
<?php include('footer.php');?>
