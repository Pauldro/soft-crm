<?php include('./_head-test.php'); ?>
<?php $config->scripts->append($config->urls->templates.'scripts/test/jSignature.min.js'); ?>
<div class="jumbotron pagetitle">
	<div class="container">
		<h1><?php echo $page->get('pagetitle|headline|title') ; ?></h1>
	<?php echo $session->sql; ?><br><?php echo $session->nextrec; ?>
	</div>
</div>

<style>
#signature {
	border: 2px solid black;
}
</style>
<div class="container page fuelux">
	<?php echo $session->sql; ?>

<?php
$links = array('writtenby' => 'paul', 'customerlink' => 'BECKER', 'shiptolink' => '123456', 'contactlink' => false);

echo getlinkednotescount($links, false);

?>
<div id="signature"></div>
</div>
<script>
$(document).ready(function() {
		$("#signature").jSignature()
	})
</script>
<?php



?>
<?php include('./_foot.php'); // include footer markup ?>
