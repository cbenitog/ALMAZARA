<?php
if (isset($_SESSION['key'][$settings['pureedit']['sessionKey']])) // If we are not logged in.
{
	require_once('classes/rss.class.php');	
	$rss->cache_dir = '';
	$rss->cache_time = 1200;
	
	// Check to see if /install dir exists.
	if (is_dir("install"))
	{
		$installDirFound = $Html->installDirFound($lang);
	}
	
	$module_output .= $Html->heading($installDirFound);

	if ($rs = $rss->get(APP_RSS)) // Try to load and parse RSS file
	{
		$module_output .= $Html->rssBlogHeading($rs);
		foreach($rs['items'] as $item)
		{
			$module_output .= $Html->rssBlogLoop($item);
		}
		$module_output .= $Html->rssBlogFooter();
	}
	else
	{
		$module_output .= $Html->rssBlogNotFound($lang);
	}

	$module_output .= $Html->leftFooter();
	$module_output .= $Html->openAreaForUniqueUse($lang);
	$module_output .= $Html->openAreaForUniqueUse_2($lang);
	$module_output .= $Html->footer();
}
else
{
	require_once('index.html'); // Access denied.
}
?>