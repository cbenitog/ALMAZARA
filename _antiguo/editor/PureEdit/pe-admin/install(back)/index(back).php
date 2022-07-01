<?php
// Installer is VERY messy because it's just here to install...sorry folks.
require_once('includes/functions.php');

switch($_GET['step'])
{
	case 1:
		include('steps/1.php');
		break;
		
	case 2:
		include('steps/2.php');
		break;
		
	case 3:
		include('steps/3.php');
		break;
		
	case 4:
		include('steps/4.php');
		break;		
		
	default:
		include('steps/1.php');				
}

include('includes/template.php');
?>
