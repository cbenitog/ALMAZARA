<?php
class Sectors
{
	// The main html for the Sectors Center.
	// --------------------------------------------------
	function main($lang)
    {
    	return <<<TEMPLATE

		<form action="" method="post">
		<h2>{$lang['sectors']['heading']}</h2>
		<div class="table-faux" style="padding: 15px 10px;">
			<dl>
				<dt>{$lang['sectors']['title']}:</dt>
				<dd><input name="title" type="text" class="textBox" value="" /></dd>
				<dt>{$lang['sectors']['abbrev']}:</dt>
				<dd><input name="abbrev" type="text" class="textBox" value="" /></dd>
			</dl>
			<div style="clear: both;"></div>
		</div>
		
		<div class="action_buttons" style="margin-top: 10px;">
		<button type="submit" name="newSector" style="float: left;">{$lang['sectors']['save']}</button>
		<button type="button" style="float: right;" onclick="Effect.toggle('sectors_center', 'blind', {duration: 0.3});">{$lang['sectors']['close']}</button>
		</div>
		<div style="clear: both;"></div>
		</form>            
        
TEMPLATE;
    }
} // End of Sectors.

$Html = new Sectors;
?>