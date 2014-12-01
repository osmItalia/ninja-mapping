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
function sendMessage(){

}
function getMessage(){
    //now unix
    //call getbefore (now)
    //successivamente chiama getlatest con l'ultimo timestamp che è stato visto.
}
</script>
<?php include('footer.php');?>
