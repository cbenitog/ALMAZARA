<?php
	if (isset($_POST['process_step3']))
	{
	    require_once('../library/settings.lib.php');

		// Test Database Connection.
		if (dbConnections() == true)
		{
			// Write DB info to the settings.php file.
			change_setting("databaseHost", $_POST['databaseHost']);
			change_setting("databaseName", $_POST['databaseName']);
			change_setting("databaseUsername", $_POST['databaseUsername']);
			change_setting("databasePassword", $_POST['databasePassword']);
			change_setting("database", $_POST['databaseType']);
			change_setting("tablePrefix", $_POST['tablePrefix']);

			require('../library/settings.lib.php');
			require_once('../databases/' . $_POST['databaseType'] . '.db.php');
			require_once('../library/definitions.lib.php');

			// Do queries.
            $Db->query("CREATE TABLE `" . TABLE_PREFIX . "sector_gettingstarted` (`id` int(11) NOT NULL auto_increment, `title_txt` varchar(255) default NULL, `date_date` int(11) default NULL,
	                `" . TABLE_PREFIX . "accounts_rel` int(11) default NULL, `body_txtbox` text NOT NULL, PRIMARY KEY  (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;");
			$Db->query("INSERT INTO `" . TABLE_PREFIX . "sector_gettingstarted` VALUES (1, 'What is this page?', " . time() . ", 1, '<p>This page is the starting page for your website and as it may look that this page is tied directly to PureEdit, it isn\'t...but it is. If you look at the code of this page you will see some of the ways PureEdit handles connecting and querying a database, but you are not inclined to go this route, you may use what ever you are use to.</p>');");
			$Db->query("INSERT INTO `" . TABLE_PREFIX . "sector_gettingstarted` VALUES (2, 'What is the relationship between my site and PE? to my site?', " . time() . ", 1, '<p>Easy, PureEdit is built to give freedom to your website and design by not forcing you to follow and work within it\'s own templating engine, so pretty much you can consider PureEdit as a standalone CMS that talks and works directly with your database and then your website is standalone as well and then talks to your database as well, so technicaly PureEdit and your website never cross paths unless you decide to use the Mysql class within PureEdit which allows easy automatied database queries.</p>');");

			$Db->query("CREATE TABLE `" . TABLE_PREFIX . "accounts` (`id` int(11) NOT NULL auto_increment, `title` varchar(255) default NULL, `email` varchar(255) default NULL,
			        `website` varchar(255) default NULL, `password` varchar(255) default NULL, `username` varchar(255) NOT NULL default '', PRIMARY KEY  (`id`)) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;");

			$Db->query("CREATE TABLE `" . TABLE_PREFIX . "sectors` (`id` int(11) NOT NULL auto_increment, `title` varchar(255) NOT NULL default '', `abbrev` varchar(255) NOT NULL default '', PRIMARY KEY  (`id`))
		            ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;");
			$Db->query("INSERT INTO `" . TABLE_PREFIX . "sectors` VALUES (1, 'Getting Started', '" . TABLE_PREFIX . "sector_gettingstarted');");

			$Db->query("CREATE TABLE `" . TABLE_PREFIX . "uploads` (`id` int(11) NOT NULL auto_increment, `file` varchar(255) NOT NULL default '', `folder` varchar(255) NOT NULL default '', PRIMARY KEY  (`id`))
		            ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=0;");

			header('location: index.php?step=4');
		}
		else
		{
			header('location: index.php?step=3&error=database');
		}		
	}
	else
	{
		// Show forms.
		$content .= '<h2>Database Setup</h2>';
		$content .= '<p>To continue, PureEdit needs to know your database login information so it can connect and install the database portion of the application.</p>';
		$content .= '<div id="formDiv">';
		
		if (isset($_GET['error']) && $_GET['error'] == "database")
		{
			$content .= '<div id="error">PureEdit was unable to connect to the given database; either your database was not found or the input you typed in is not correct. Fix the problem and please try again.</div>';
		}
		
		if (!isset($_GET['error']) OR $_GET['error'] == "database")
		{
			$content .= '<form action="index.php?step=3" method="post">';
			$content .= '<ul id="form">';
			
				$content .= '<li>Database Host: <em><input type="text" name="databaseHost" value="localhost" /></em></li>';
                $content .= '<li>Database Name: <em><input type="text" name="databaseName" /></em></li>';
				$content .= '<li class="border">Username: <em><input type="text" name="databaseUsername" /></em></li>';				
				$content .= '<li class="border">Password: <em><input type="password" name="databasePassword" /></em></li>';
				$content .= '<li class="border">Database System:<em><select name="databaseType">';
				// loop files found in database dir.
				$openDir = opendir('../databases');
				while (false !== ($file = readdir($openDir)))
				{
					if ($file != "." && $file != ".." && $file != "index.html")
					{
						$content .= '<option value="' . rtrim($file, ".db.php") . '">' . rtrim($file, ".db.php") . '</option>';
					}
				}
				closedir($openDir);				
				$content .= '</select></em></li>';
				$content .= '<li class="border">Table Prefix: <em><input type="text" name="tablePrefix" value="pe_"/></em></li>';					
															
	
			$content .= '</ul>';
			$content .= '<div style="clear: both;"></div>';
			$content .= '</div>';			
			$content .= '<button type="submit" name="process_step3"><img src="images/database.gif" alt="process" /> Process Database Information &gt; </button>';
			$content .= '</form>';
			
		}
	}
?>