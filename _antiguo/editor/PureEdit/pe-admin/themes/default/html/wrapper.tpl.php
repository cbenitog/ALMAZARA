<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<title><?php echo SITE_TITLE; ?> (Powered by PureEdit).</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<link rel="stylesheet" href="themes/<?php echo APP_THEME; ?>/css/global.css" type="text/css" media="screen" />

	<script src="library/javascript/general.lib.js" type="text/javascript"></script>   	
	<script src="library/javascript/scriptaculous/prototype.js" type="text/javascript"></script>    	
	<script src="library/javascript/tiny_mce/tiny_mce.js" type="text/javascript" ></script>
	<script src="library/javascript/scriptaculous/scriptaculous.js" type="text/javascript"></script>	

	<script type="text/javascript">
	tinyMCE.init
	({
		mode : "textareas",
		theme : "advanced",
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,forecolor,separator,justifyleft,justifycenter,justifyright,justifyfull,separator,bullist,numlist,hr,image,link,unlink,separator,formatselect,separator,undo,redo,code",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_path_location : "bottom",
		extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]"
	});
	</script>

</head>
<body>

	<div id="wrapper">

		<!-- Navigation. -->	
 		<ul id="sectors">
			<?php
			$getNavigation = $Db->select(TABLE_PREFIX . "sectors");
			echo '<li><a href="javascript: void(0);" id="current" class="out" onclick="toggleNav();">' . SECTOR_TITLE . ' <em>(' . SECTOR_ABBREV . ')</em></a>'; 
			echo '<ul id="hiddenLinks" style="display: none;">';           
			
			while($sector = $Db->fetch_assoc($getNavigation))
			{
				$selected = (SECTOR_ID == $sector['id']) ? ' id="selected" ' : '';
				echo '<li><a href="index.php?module=overview&amp;sector=' . $sector['id'] . '"' . $selected . '>' . $sector['title'] . ' <em>(' . $sector['abbrev'] . ')</em></a></li> ' . "\n";			
			}
			
			$selected = (SECTOR_ID == 0) ? ' id="selected" ' : '';			
			echo '<li><a href="index.php"' . $selected . '>Dashboard <em>(Dshbrd)</em></a></li>';			
           	echo ' </ul>';
        	echo '</li>';  
			?> 			
        </ul>
        

        <!-- Links. -->	
        <ul id="links">
            <?php
                // Load center links at top.
                foreach ($settings['pureedit']['centers'] AS $key => $value)
                {
                    if ($value == true)
                    {
                        echo '<li style="background: url(themes/' . APP_THEME . '/images/' . $key . '_center.gif) no-repeat;">
                                <a href="javascript:void(0);" onclick="Effect.toggle(\'' . $key . '_center\', \'blind\', {duration: 0.2});">' . $lang[$key]['heading'] . '</a></li>';
                    }
                }
            ?>    
            
            <li style="background: url(themes/<?php echo APP_THEME; ?>/images/logout.gif) no-repeat;"><a href="index.php?authenticate=out"><?php echo $lang['wrapper']['logout']; ?></a></li>    
            
        </ul>
        <div style="clear: both;"></div>

		<!-- Centers Areas. -->	
        <?php
            // Load center areas that are hidden.
            foreach ($settings['pureedit']['centers'] AS $key => $value)
            {
                if ($value == true)
                {				
                    echo '<div id="' . $key . '_center" style="display: none;">';
                    include_once("centers/" . $key . ".center.php");
                    echo '</div>';
                }
            }
        ?>
	

	<!-- Content. -->
	<div id="content">
		<?php echo $module_output; ?>
	</div>
	
</div>

<!-- Please help support me in any way. -->
<div id="footer">
    <ul>
        <li id="copyright"><?php echo $lang['wrapper']['copyright'] ; ?> <a href="http://www.m1k3.net">Michael Dick</a>.</li>
        <li id="poweredBy"><?php echo $lang['wrapper']['poweredby'] ; ?> <a href="http://www.pureedit.com">PureEdit</a>.</li>
    </ul>
    <div style="clear: both;"></div>
</div>

</body>
</html>