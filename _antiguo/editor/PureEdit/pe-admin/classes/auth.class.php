<?php
class Auth
{
	var $settings;

	function Auth($settings=null)
	{
		$this->settings = $settings;
	}

	function direction($direction)
	{
		if ($direction == "in") // Logging in.
		{
			$getAuth = Db::query("SELECT * FROM `" . TABLE_PREFIX . "accounts` WHERE
										`username` = '" . Db::escape($_POST['username']) . "'
									AND `password` = '" . Db::escape(md5($_POST['password'])) . "'");
											
			if (Db::num_rows($getAuth) > 0)
			{						
				$_SESSION['key'][$this->settings['pureedit']['sessionKey']] = true; // Set session.		
				
				$user = Db::fetch_assoc($getAuth); 
				$_SESSION['user']['id'] = $user['id'];
				
				return true;
			}
			else
			{
				return false;
			}
		}
		elseif ($direction == "out") // Logging out.
		{
			session_destroy();
			return true;
		}
	}
} // End of Auth.	
?>