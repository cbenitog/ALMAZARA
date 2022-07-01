<?php
	if (isset($_POST['process_step2']))
	{	
		if ($_POST['title'] != "")
		{
			change_setting("title", $_POST['title']);
			change_setting("url", $_POST['url']);				
			header('location: index.php?step=2&error=none');
		}
		else
		{
			header('location: index.php?step=2&error=website');
		}		
	}
	else
	{
		// Show forms.
		$content .= '<h2>Website Setup</h2>';
		$content .= '<p>First, PureEdit needs to know your website title and url so that it can properly redirect you after installation is complete.</p>';
		$content .= '<div id="formDiv">';
		
		if (isset($_GET['error']) && $_GET['error'] == "website")
		{
			$content .= '<div id="error">PureEdit was unable to see both your <strong>Title</strong> and <strong>Url</strong>, please input your data again and try again.</div>';
		}
		
		if (isset($_GET['error']) && $_GET['error'] == "none")
		{
			header('location: index.php?step=3');
		}		
		
		if (!isset($_GET['error']) OR $_GET['error'] == "website")
		{
			$content .= '<form action="index.php?step=2" method="post">';
			$content .= '<ul id="form">';
			
				$content .= '<li>Website Title * <em><input type="text" name="title" value="" /></em></li>';
				$content .= '<li>Website Url * <em><input type="text" name="url" value="http://' . $_SERVER['HTTP_HOST'] . '/" /></em></li>';												
	
			$content .= '</ul>';
			$content .= '<div style="clear: both;"></div>';
			$content .= '</div>';			
			$content .= '<button type="submit" name="process_step2"><img src="images/website.gif" alt="process" /> Process Website Information &gt; </button>';
			$content .= '</form>';
			
		}
	}
?>