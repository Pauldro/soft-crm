		<?php foreach($config->scripts->unique() as $script) : ?>
        	<script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
        <div id="loading-bkgd" class="modal-backdrop fade in"></div>
    </body>
</html>