<?php

$pureedit_dir = "pe-admin/";

require_once($pureedit_dir . 'library/settings.lib.php');

require_once($pureedit_dir . 'databases/' . $settings['pureedit']['database'] . '.db.php');

require_once($pureedit_dir . 'classes/utils.class.php');

require_once($pureedit_dir . 'library/definitions.lib.php');

?>

    

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>

	<title><?php echo SITE_TITLE; ?> (Powered by PureEdit).</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <style type="text/css">

		*

		{

			margin: 0;

			padding: 0;

		}

		

		body

		{

			font-family: georgia;

			font-size: 11px;

			background-color: #fff;

		}

		

		div#out-wrapper

		{

		    width: 95%;

		    margin: 0 auto;

		}

		

		h1

		{

		    margin: 20px 0 15px;

		}

		

		div#wrapper

		{

			padding: 20px;

			background-color: #dcdcdc;

			border: 1px solid #fff;

		}

		

			ul#navigation,

			ul#footer

			{

				background-color: #ffffff;

				padding: 15px;

				text-align: center;

				list-style: none;

				height: 12px;

				border: 1px solid #c3c3c3;

			}	

			

			ul#navigation li.left,

			ul#footer li.left

			{

				float: left;

				padding-right: 10px;

			}

			

			ul#navigation li.right,

			ul#footer li.right

			{

				float: right;			

				padding-left: 10px;

			}		

			

			ul#navigation li a,

			ul#footer li a

			{

				color: #333;

			}	



			div#content

			{

				background-color: #ffffff;

				padding: 15px;

				margin-top: 15px;

				list-style: none;

				border: 1px solid #c3c3c3;

			}	

			

				div#content p

				{

					margin: 0 0 10px;

					line-height: 150%;

				}	



				div#content h2

				{

					font-size: 13px;

					margin: 0 0 10px;

				}

			

			ul#footer

			{

				margin-top: 15px;

			}							

	</style>

</head>

<body>

    

    <div id="out-wrapper">

        <h1><?php echo SITE_TITLE; ?></h1>

    	<div id="wrapper">

    		<ul id="navigation">

    			<li class="left"><a href="<?php echo SITE_URL; ?>"><?php echo SITE_TITLE; ?></a> &gt; Homepage</li>        

    			<li class="right"><a href="http://www.m1k3.net">M1k3.net</a> // <a href="http://www.pureedit.com">PureEdit.com</a> // <a href="<?php echo SITE_URL; ?>/<?php echo $pureedit_dir; ?>">Admin Login</a></li>

            </ul>

            <div id="content">

			    <?php

                	$getFAQs = $Db->select(TABLE_PREFIX . "sector_gettingstarted");

    				while($faq = $Db->fetch_assoc($getFAQs))

                    {

                    	echo '<h2>' . $faq['title_txt'] . '</h2>';

    					echo $faq['body_txtbox'];

                    }

                ?>

        	</div>

            <ul id="footer">

                <li class="left"></li>

                <li class="right">Powered by <a href="http://www.toolz.es/">Toolz</a>.</li>            

            </ul>      

    	</div>

    </div>



</body>

</html>

