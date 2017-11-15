<?php 
    $actionsreport = new UserActionsReport($page->fullURL, array('assignedto' => $user->loginid));
    
    $donutarray = $actionsreport->generate_actionsbytypearray();
    $completionarray = $actionsreport->generate_completionarray();
?>
<a href="<?= $config->pages->actions.'all/load/report-form/'; ?>" class="btn btn-primary load-into-modal" data-modal="#ajax-modal"><i class="fa fa-tasks" aria-hidden="true"></i> Generate Report</a>
<div class="row">
    <div class="col-sm-6">
        <h3>Action Type</h3>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#chart" aria-controls="chart" role="tab" data-toggle="tab">Chart</a></li>
                <li role="presentation"><a href="#table" aria-controls="table" role="tab" data-toggle="tab">Table</a></li>
            </ul>
            
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="chart">
                    <br>
                    <h4>Total Tasks: <?= $actionsreport->count_actions(); ?></h4>
                    <div id="donut-display"></div>
                </div>
                <div role="tabpanel" class="tab-pane" id="table">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Action Type</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <?php foreach ($donutarray as $action) : ?>
                            <tr>
                                <td><?= $action['label']; ?></td>
                                <td><?= $action['value']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <h3>Task Completion Data</h3>
        <div id="task-completion-chart"></div>
    </div>
</div>


<script>
    $(function() {
        var data = JSON.parse('<?= json_encode($donutarray); ?>');
        var taskdata = JSON.parse('<?= json_encode($completionarray); ?>');
        new Morris.Donut({
            element: 'donut-display',
            data: data
        });
        
        new Morris.Donut({
            element: 'task-completion-chart',
            data: taskdata
        });
    });

</script>
