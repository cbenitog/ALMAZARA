<?php
class Help
{
	// Help Index.
	// --------------------------------------------------
	function index($lang)
    {
    	return <<<TEMPLATE
		
		<h2>{$lang['help']['heading']}</h2>
		<div class="table-faux">
			<div style="width: 75%; margin: 0 auto; text-align: center; color: #a3a3a3; padding: 20px 0; line-height: 150%;">
                <a href="centers/help.center.php?topic=1" onclick="ajax_get('help_center', this.href); return false;">&lt;&lt; Go back to help index</a>
			</div>
		</div>
	
        
TEMPLATE;
    }
	
	// A topic.
	// --------------------------------------------------	
	function topic($helpTopicHTML, $lang)
    {
    	return <<<TEMPLATE

		<h2>{$lang['help']['heading']}</h2>
		<div class="table-faux">
            {$helpTopicHTML} (<a href="centers/help.center.php?topic=none" onclick="ajax_get('help_center', this.href); return false;">&lt;&lt; Go back to help index</a>). 
		</div>		    
        
TEMPLATE;
    }	
} // End of Help.

$Html = new Help;
?>