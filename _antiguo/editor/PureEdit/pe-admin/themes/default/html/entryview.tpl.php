<?php
class Entryview
{	
	// Entryview header.
	// --------------------------------------------------
	function entryviewHeader($endUrlString)
	{
	 	global $column;
            
		return <<<TEMPLATE
		
        <form method="post" action="index.php?module=entryview&amp;sector={$_GET['sector']}{$endUrlString}">
		<div id="entryviewBackground">
		<dl>
			
TEMPLATE;
	}     


	// Entryview footer
	// --------------------------------------------------
	function entryviewFooter($lang)
	{	 	
		return <<<TEMPLATE
		
		</dl>
        <div class="actions_buttons" style="margin-top: 10px;">
            <button style="float: left;" type="submit" name="save" >{$lang['entryview']['save']}</button>            
        	<button style="float: right;" type="button" onclick="javascript:window.location='index.php?module=overview&amp;sector={$_GET['sector']}';">{$lang['entryview']['cancel']}</button> 
        </div>
        </form>
        <div style="clear: both;"></div>
		</div>

TEMPLATE;
	}
} // End of Entryview.

$Html = new Entryview;
