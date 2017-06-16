<?php
    switch ($page->name) {
        case 'tasks':
            include $config->paths->content."tasks/crud-controller.php";
            break;
        case 'notes':
            include $config->paths->content."notes/crm/crud-controller.php";
            break;
		case 'schedule':
			include $config->paths->content."tasks/schedule/crud-controller.php";
            break;
        default:
            throw new Wire404Exception();
            break;
    }
?>
