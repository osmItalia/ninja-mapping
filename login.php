<?php
include_once('conf.php');
//don't force login, this page already does it
$NOLOGIN=1;
$message='';

if (isset($_POST["un"])&& isset($_POST["pw"]))
{
    $username = $_POST["un"];
    $password = $_POST["pw"];
    $a=new Auth($basepath,$dbFile);
    if ($a->login($username, $password)) {
        if(isset($_POST['l']) && $_POST['l']!=="" && !strstr($_POST['l'],'logout')){
            header("Location: http://".$_SERVER['SERVER_NAME'].urldecode($_POST['l']));
        }
        else
        {
            header("Location: ".$a->basepath."/index.php");
        }
    } else {
        $message="<p class='alert'>Login incorrect</p>";
    }
}
 include('header.php');?>
    <div class="row">
     <div class="col-md-12">
        <form class="form-horizontal" id="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <fieldset>
        <legend>Login</legend>
        <?php echo $message; ?>
        <div class="form-group">
          <label class="control-label" for="un">Username</label>
          <div class="controls">
            <input id="un" name="un" type="text" placeholder="" class="input-sm form-control" required="">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label" for="pw">Password</label>
          <div class="controls">
            <input id="pw" name="pw" type="password" placeholder="" class="input-sm form-control" required="">
          </div>
        </div>

        <div class="form-group">
          <label class="control-label" for="button"></label>
          <div class="controls">
            <button id="button" name="button" class="btn btn-primary">Submit</button>
          </div>
        </div>
        </fieldset>
        </form>
        </div>
     </div>
<?php include('footer.php');?>
