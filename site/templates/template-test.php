<?php
 //$query = new atk4\dsql\Query();
?>
<?php include('./_head.php'); ?>

<div class="jumbotron pagetitle">
	<div class="container">
		<h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
	</div>
</div>


<div class="container page fuelux">

	<?php echo $session->sql; ?><br>
	<?php echo  get_next_note_recno(session_id(), 'lvcl7k73d9cnf6kq83gokq2075', '1', 'CART'); ?>
	<br>
	<?php
		echo $page->httpUrl;
	?>
	<br>
	<?= $session->linecount; ?>


</div>






<?php include('./_foot.php'); // include footer markup ?>
