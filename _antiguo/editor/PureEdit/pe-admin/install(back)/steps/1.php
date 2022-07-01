<?php
	$continue = array();   	
	
	// First step.
	$content .= '<h2>Permissions Check</h2>';
	$content .= '<p>PureEdit is checking the file permissions on the files listed below. Files highlighted <span id="green">green</span> have the correct permissions, however files highlighted <span id="red">red</span> need to be corrected to match the needed permission.</p>';
	$content .= '<table cellspacing="0">';
	$content .= '<tr>';
	$content .= '<th>Path</th>';
	$content .= '<th>Type</th>';	
	$content .= '<th>Permission</th>';
	$content .= '<th>Status</th>';
	$content .= '</tr>';
	
	// Files to check if writable.
	check_perm("../library/settings.lib.php");	
	check_perm("../../index.php");
	check_perm("../../uploads");
	
	$content .= '</table>';
	
	// Can we continue or not?
	if (in_array("bad", $continue))
	{
		// No continue.
		$content .= '<button type="submit" onclick="document.location.reload(true)"><img src="images/refresh.gif" alt="refresh" /> Refresh &amp; Check Again</button<br />';
	}
	else
	{
		// Continue.
		$content .= '<button type="submit" onclick="window.location=\'index.php?step=2\'"><img src="images/website.gif" alt="to datbase" /> Continue to Website Setup &gt; </button>';
	}
?>