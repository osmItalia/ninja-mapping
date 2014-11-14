<?php
include_once('conf.php');
$a=new Auth($basepath,$dbFile);

//force authentication except for the pages with $NOLOGIN=1;
if(!isset($NOLOGIN) || $NOLOGIN != 1)
	$a->forceAuthentication();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
   <title></title>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css"/>
<link rel="stylesheet" href="style.css"/>
</head>
 <body>
    <div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
			<?php if($a->authenticated()):?>
				<li><a href="logger.php">Logger</a></li>
	            		<li><a href="info.php">Info/settings</a></li>
				<li><a href="radar.php">Radar</a></li>
            		<?php endif; ?>
          </ul>
		<ul class="nav navbar-nav navbar-right">
				<?php if($a->authenticated()):?>
				<li><a href="logout.php">(<?php echo $a->getUsername(); ?>) Logout</a></li>
                <?php else: ?>
				<li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
      </div>
    </div>

    <div class="container">
