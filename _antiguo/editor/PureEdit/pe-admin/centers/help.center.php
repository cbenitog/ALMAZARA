<?php
// Determine if we need to reinclude files (due to ajax).
if (isset($_GET['topic']))
{
	// Do we need to re-require/include these files.
	// * I'm not the best at Ajax, oops. Sorry.
	// * Is there a better way? Help! Kthxbye.
	// ==================================================
    require_once('../library/settings.lib.php');
    require_once('../databases/' . $settings['pureedit']['database'] . '.db.php');
    require_once('../library/definitions.lib.php');
    require_once('../classes/auth.class.php');
    require_once('../languages/' . LANG_PACK . '.lang.php');
    require_once('../classes/utils.class.php');
    require_once('../themes/' . APP_THEME . '/html/help.tpl.php');	
}
else
{
	require_once('themes/' . APP_THEME . '/html/help.tpl.php');
}

// Determine if we have clicked a link.
if (isset($_GET['topic']) && $_GET['topic'] != "none")
{
	// You can store this data in the database if you wished? You can get creative.
	switch($_GET['topic'])
	{
		case 1: $helpTopicHTML = "You may want to explain how to create entries...or explain what each field means here."; break;
		case 2: $helpTopicHTML = "A good tip to put here would be a way to explain to your client how to use your built-in addons (called centers), or how to use the <strong>Uploads Center</strong>."; break;
		default: $helpTopicHTML = "No help topic was found.";
	}
	
	$help_output .= $Html->topic($helpTopicHTML, $lang);	
}
else
{
	$help_output .= $Html->index($lang);
}

echo $help_output;
?>