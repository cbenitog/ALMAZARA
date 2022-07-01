<?php
if (isset($_SESSION['key'][$settings['pureedit']['sessionKey']])) // If we are not logged in.
{
	require_once('themes/' . APP_THEME . '/html/sectors.tpl.php');
	$sectors_output .= $Html->main($lang);
}
else
{
	require_once('index.html'); // Access denied.
}

echo $sectors_output;
?>