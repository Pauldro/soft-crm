<?php
    if ($input->get->q) {
        $items = searchitem_page($input->get->text('q'), true, $config->showonpage, $input->pageNum, false);
        $resultscount = searchitemcount($input->get->text('q'), true, false);
    }

?>

    <div class="panel panel-primary" id="item-results">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a role="button" data-toggle="collapse" href="#resultspanel" aria-expanded="true" aria-controls="resultspanel">
                    Item Results
                </a>
            </h4>
        </div>
        <div id="resultspanel" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">
                <div class="list-group" id="item-results">
                    <?php if ($input->get->q) : ?>
                        <?php if ($resultscount) : ?>
                            <?php foreach ($items as $item) : ?>
                            	<?php if (!file_exists($config->imagefiledirectory.$item['image'])) {$item['image'] = 'notavailable.png'; } ?>
                                <a href="#" class="list-group-item item-master-result" onclick="$('.ci-item-search').val('<?= $item['itemid']; ?>')">
                                    <div class="row">
                                        <div class="col-xs-2"><img src="<?php echo $config->imagedirectory.$item['image']; ?>" alt=""></div>
                                        <div class="col-xs-10"><h4 class="list-group-item-heading"><?php echo $item['itemid']; ?></h4>
                                        <p class="list-group-item-text"><?php echo $item['desc1']; ?></p></div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <a href="#" class="list-group-item item-master-result">
                                <div class="row">
                                    <div class="col-xs-2"></div>
                                    <div class="col-xs-10"><h4 class="list-group-item-heading">No Items Match your query.</h4>
                                    <p class="list-group-item-text"></p></div>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
