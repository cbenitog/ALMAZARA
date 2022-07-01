<?php
/*---------------------------------------------------------------------*
| PureEdit 1.4.1 (www.pureedit.com)
*----------------------------------------------------------------------*
| Copyright (c) 2007 by Michael Dick (www.m1k3.net).
*----------------------------------------------------------------------*
| PureEdit is free software; you can redistribute it and/or modify
| it under the terms of the GNU General Public License as published by
| the Free Software Foundation; either version 2 of the License, or
| any later version.
|
| PureEdit is distributed in the hope that it will be useful, but
| WITHOUT ANY WARRANTY; without even the implied warranty of
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
| General Public License for more details.
*---------------------------------------------------------------------*/

session_start();
require_once('library/settings.lib.php');
require_once('databases/' . $settings['pureedit']['database'] . '.db.php');
require_once('library/definitions.lib.php');
require_once('classes/auth.class.php');
require_once('languages/' . LANG_PACK . '.lang.php');
require_once('classes/utils.class.php');

if (!isset($_SESSION['key'][$settings['pureedit']['sessionKey']])) // If we are not logged in.
{
    if(isset($_GET['authenticate'])) // Have we hit submit?
    {
		$Auth = new Auth($settings);
        if ($Auth->direction("in"))
        {
			header('Refresh: 1; url=index.php');	
            include_once('themes/' . APP_THEME . '/html/authredirect.tpl.php');
        }
        else
        {
            $authRetry = true;
            include_once('themes/' . APP_THEME . '/html/authform.tpl.php');
        }
    }
    else
    {
        $authRetry = false;
        include_once('themes/' . APP_THEME . '/html/authform.tpl.php');
    }
}
elseif (isset($_SESSION['key'][$settings['pureedit']['sessionKey']])) // If we are logged in.
{
    if (isset($_GET['authenticate'])) // Logged in, but logging out.
    {
		$Auth = new Auth();
        if ($Auth->direction("out"))
        {
			header('Refresh: 1; url=index.php');		
            include_once('themes/' . APP_THEME . '/html/authredirect.tpl.php');
        }
    }
    else // Logged in, but staying logged in.
    {
		if (isset($_POST['newSector']) && ($_POST['title'] != '' && ($_POST['abbrev'] != ''))) // New Sector has been submitted.
		{
			$Db->insert(TABLE_PREFIX . "sectors");
			header('location: index.php?module=overview&sector=' . $Db->insert_id());
        }

        if (isset($_GET['module'])) // Load current template & module.
		{
			include_once('themes/' . APP_THEME . '/html/' . addslashes($_GET['module']) . '.tpl.php');
			include_once('modules/' . addslashes($_GET['module']) . '.module.php');
		}
		else // Load default which is dashboard.
		{
			include_once('themes/' . APP_THEME . '/html/dashboard.tpl.php');
			include_once('modules/dashboard.module.php');
		}
		
		// Load main wrapper template.
		include_once('themes/' . APP_THEME . '/html/wrapper.tpl.php');
    }
}
?>
