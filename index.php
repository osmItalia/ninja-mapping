<?php 
//don't force login, we are in homepage
$NOLOGIN=1;

include('header.php');?>
<div class="row">
    <div class="col-md-12">
        <h1>Ninja Mapping</h1>	
	<?php if ( !$a->authenticated() ): ?>
		<p><a href="login.php">Login first</a></p>
	<?php endif; ?>
	<p>
	<p>Use the menu to choose the function</p>
    </div>
</div>
<?php include('footer.php');?>
