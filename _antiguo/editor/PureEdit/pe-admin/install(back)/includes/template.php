<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title>Welcome to PureEdit's Installation.</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" href="css/install.css" type="text/css" media="screen" />
</head>
<body>

	<div id="wrapper">
    
        <h1><a href="http://www.pureedit.com">PureEdit</a></h1>
        <em id="title">PureEdit Installation</em>
        
        <ul id="steps">
            <li <?php echo (!isset($_GET['step'])) ? 'id="on"' : '' ; ?>>Permission Check <span style="font-weight: normal; color: #fff; margin: 0 5px;">&gt;</span></li> 
            <li <?php echo (isset($_GET['step']) && $_GET['step'] == 2) ? 'id="on"' : '' ; ?>>Website Setup <span style="font-weight: normal; color: #fff; margin: 0 5px;">&gt;</span></li>                  
            <li <?php echo (isset($_GET['step']) && $_GET['step'] == 3) ? 'id="on"' : '' ; ?>>Database Setup <span style="font-weight: normal; color: #fff; margin: 0 5px;">&gt;</span></li>
            <li <?php echo (isset($_GET['step']) && $_GET['step'] == 4) ? 'id="on"' : '' ; ?>>Account Setup <span style="font-weight: normal; color: #fff; margin: 0 5px;">&gt;</span></li>
            <li>Login</li>
        </ul>  
        
        <?php
		    echo $content;
		?>

	</div>

</body>
</html>