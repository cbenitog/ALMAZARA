<?php
class Overview
{	
	// Overview heading.
	// --------------------------------------------------
	function heading()
	{	 	
		return <<<TEMPLATE
		
		<form method="post" action="index.php?module=overview&amp;sector={$_GET['sector']}">     
			<table cellspacing="0">
				<tr>
			
TEMPLATE;
	}	
	
	
	// Overview table loop.
	// --------------------------------------------------
	function tableHeadingLoop($column)
	{	 	
		return <<<TEMPLATE
		
		<th width="">{$column}</th>
		
TEMPLATE;
	}
	
	// Overview table loop.
	// --------------------------------------------------
	function fieldNotFound($lang, $field)
	{	 	
		return <<<TEMPLATE
		
		<div class="fieldWarning">
			<h2>{$lang['overview']['fieldNotFound']} <b>{$field}</b></h2>
		</div>
		
TEMPLATE;
	}				
	
	// Overview table footer.
	// --------------------------------------------------
	function tableHeadingFooter()
	{ 	
		return <<<TEMPLATE
		
		<th><input name="" type="checkbox" value="" onclick="CheckAllBoxes(this);" /></th>
		</tr>
			
TEMPLATE;
	}		
	
	
	// Overview entry list head.
	// --------------------------------------------------
	function entryListHeading()
	{	 	
		return <<<TEMPLATE
	
		<tr>												
		
TEMPLATE;
	}	

	// Overview entry list.
	// --------------------------------------------------
	function entryListLoop($value)
	{	 	
		return <<<TEMPLATE
	
		<td>
			{$value}
		</td>												
		
TEMPLATE;
	}
	
	// Overview list footer.
	// --------------------------------------------------
	function entryListFooter($entry)
	{	 	
		return <<<TEMPLATE
		
			<td width="1px" style="background-color: #e8f6d1;">
				<input name="delete[]" type="checkbox" value="{$entry['id']}" />
			</td>	
		</tr>												
		
TEMPLATE;
	}	
	

	// No entries found.
	// --------------------------------------------------
	function entriesNotFound($settings)
	{		
		return <<<TEMPLATE
				
            <tr>
                <td style="color: #777; background-image: url(themes/{$settings['pureedit']['theme']}/images/no_entries_found.gif); height: 594px;" colspan="6">&nbsp;</td>
            </tr>

TEMPLATE;
	}


	// No sector found.
	// --------------------------------------------------
	function sectorTableNotFound($lang, $entry, $settings, $SECTOR_ABBREV)
	{
		return <<<TEMPLATE
		
		<div class="warning">
			<h2>{$lang['overview']['warningHeader']}</h2>
			<ul>
				<li class="problem">{$lang['overview']['warningProblem']}</li>
				<li class="solution">{$lang['overview']['warningSolution']}</li>
			</ul>
		</div>

TEMPLATE;
	}
        
					
	// Overview footer.
	// --------------------------------------------------
	function footer($lang, $entry, $SECTOR_ABBREV)
	{
		return <<<TEMPLATE

       	</table>
        <div class="action_buttons" style="margin-top: 10px;">
            <button style="float: left;" type="button" onclick="window.location='index.php?module=entryview&amp;sector={$_GET['sector']}'">{$lang['overview']['create']}</button>
            <button  style="float: right;" type="submit" name="deleteSubmit" onclick="return confirm('{$lang['overview']['deleteMessage']}');">{$lang['overview']['delete']}</button>
        </div>
        <div style="clear: both;"></div>
	    </form>   
	    
TEMPLATE;
	}
} // End of Overview.

$Html = new Overview;
?>