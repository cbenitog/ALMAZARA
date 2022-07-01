<?php
	$content .= '<h2>Account Setup</h2>';
	$content .= '<p>To get you logged in for the first time, PureEdit needs to know some info about the first account you need created. Fill in the input boxes and proceed to finlize the installation.</p>';
	$content .= '<div id="formDiv">';
	
	if (isset($_POST['process_step4']))
	{
		if ($_POST['title'] == "" OR $_POST['username'] == "" OR $_POST['password'] == "" OR $_POST['email'] == "" OR $_POST['website'] == "")
		{
			header('location: index.php?step=4&error=account');
		}
		else
		{
			require_once('../library/settings.lib.php');
			require_once('../databases/' . $settings['pureedit']['database'] . '.db.php');
			Db::query("INSERT INTO `" . $settings['pureedit']['tablePrefix'] . "accounts` (`id`, `title`, `email`, `website`, `password`, `username`) VALUES ('1', '" . $_POST['title'] . "', '" . $_POST['email'] . "', '" . $_POST['website'] . "', '" . md5($_POST['password']) . "', '" . $_POST['username'] . "')"); 
			
			// Overwrite the index.php page.
			$get_index = fopen("../../index.php", "w");
			$string = file_get_contents("includes/index.temp");
			$new_index = fwrite($get_index, $string);				
			
			header('location: index.php?step=4&error=none');
		}
	}
	else
	{
		if (isset($_GET['error']) && $_GET['error'] == "account")
		{
			$content .= '<div id="error">PureEdit was unable to create your first account, please ensure that you have filled out each input box, then proceed to continue.</div>';
		}
		
		if (isset($_GET['error']) && $_GET['error'] == "none")
		{
			$content .= '<div id="noerror">PureEdit has finished setting up your first account, go ahead and proceed to get logged in!</div>';
			$content .= '</div>'; // Ends the formDiv.
			
			$content .= '<button type="submit" onclick="window.location=\'../index.php\'"><img src="images/key.gif" alt="login" /> Continue to Login &gt; </button>';
		}		
		
		if (!isset($_GET['error']) OR $_GET['error'] == "account")
		{
			$content .= '<form action="index.php?step=4" method="post">';
			$content .= '<ul id="form">';
			
				$content .= '<li>Name *<em><input type="text" name="title" /></em></li>';
				$content .= '<li>Username * <em><input type="text" name="username" /></em></li>';
				$content .= '<li>Website *<em><input type="text" name="website" value="http://www." /></em></li>';									
				$content .= '<li>Password * <em><input type="password" name="password" /></em></li>';		
				$content .= '<li>Email *<em><input type="text" name="email" /></em></li>';								
	
			$content .= '</ul>';
			$content .= '<div style="clear: both;"></div>';
			$content .= '</div>';			
			$content .= '<button type="submit" name="process_step4"><img src="images/user.gif" alt="process" /> Process Account Information &gt; </button>';
			$content .= '</form>';
		}
	}
?>