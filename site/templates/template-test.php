<?php include('./_head-test.php'); ?>

<div class="jumbotron pagetitle">
	<div class="container">
		<h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
	</div>
</div>


<div class="container page fuelux">
	<?php echo var_dump($session->sql); ?><br>
	<?= $session->nextrec; ?><br>
	<?php echo var_dump($session->detail); ?>



</div>


<?php include('./_foot.php'); // include footer markup ?>
