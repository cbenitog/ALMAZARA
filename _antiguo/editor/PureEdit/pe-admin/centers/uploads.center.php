<?php
session_start();
require_once('../library/settings.lib.php');
require_once('../databases/' . $settings['pureedit']['database'] . '.db.php');
require_once('../library/definitions.lib.php');
require_once('../languages/' . LANG_PACK . '.lang.php');

if (isset($_SESSION['key'][$settings['pureedit']['sessionKey']]))
{
	require_once('../themes/' . APP_THEME . '/html/uploads.tpl.php');

	if (isset($_FILES['file'])) // Upload a file.
	{
		$dir = '../../' . $settings['uploads']['directory'] . $_POST['folder'] . '/';
		move_uploaded_file($_FILES['file']['tmp_name'], $dir . $_FILES['file']['name']);

		// Check for duplicate entries in db uploads table. If found, overwrite.
		$checkFile = $Db->query("SELECT `file` FROM `" . TABLE_PREFIX . "uploads` WHERE `file`='" . $_FILES['file']['name'] . "'"); 
		$fileCount = $Db->num_rows($checkFile);
		if ($fileCount == 1)
		{
			$Db->query("DELETE FROM `" . TABLE_PREFIX . "uploads` WHERE `file`='" . $_FILES['file']['name'] . "'");
		}
		
		// Insert file into database.
		$Db->query("INSERT INTO `" . TABLE_PREFIX . "uploads` (`file`, `folder`) VALUES ('" . $_FILES['file']['name'] . "', '" . $_POST['folder'] . "')");		
	}
	elseif (isset($_GET['delete'])) // Delete a file.
	{
		$dir = '../../' . $settings['uploads']['directory'] . $_GET['folder'] . '/';
		$delete = $Db->delete(TABLE_PREFIX . "uploads", $_GET['id']);
		unlink($dir . $_GET['file']);
	}
	
	// parse html.
	$uploads_output .= $Html->heading($lang, SITE_TITLE, APP_THEME);
	$uploads_output .= $Html->newFormHeader();
	
	foreach ($settings['uploads']['folders'] AS $key => $value)
	{
		$uploads_output .= $Html->newFormCategoryLoop($key, $value);
	}
	
	$uploads_output .= $Html->newFormFooter($lang);
    $uploads_output .= $Html->fileListHeading($lang);

	foreach ($settings['uploads']['folders'] AS $typeKey => $typeValue)
	{
		$getFile = $Db->query("SELECT * FROM `" . TABLE_PREFIX . "uploads` WHERE `folder`='" . $typeValue . "'");
		$fileCount = $Db->num_rows($getFile);
		
		$dir = '../../' . $settings['uploads']['directory'] . $typeValue . '/';
		$uploads_output .= $Html->fileListCategoryHeading($typeKey);
		
		if ($fileCount <= 0) // Check to see if files exist.
		{
			$uploads_output .= $Html->noFilesFound($lang);
		}
		else // Files present.
		{
			while ($file = $Db->fetch_assoc($getFile))
			{
				if (is_file($dir . $file['file']))
				{
					$uploads_output .= $Html->fileRow($lang, $file, $dir);
				}
			}					
		}
	}
    
	$uploads_output .= $Html->footer();
	echo $uploads_output;
}
else
{
	require_once('index.html'); // Access denied.
}
?>