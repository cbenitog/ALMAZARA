<?php
class Accounts
{	
	// Accounts heading.
	// --------------------------------------------------
	function heading($lang)
	{	
		return <<<TEMPLATE
		
		<form action="centers/accounts.center.php" name="accountsForm" id="accountsForm" onsubmit="new Ajax.Updater('accounts_center', this.action, {asynchronous:true, parameters:Form.serialize(this)}); return false;">
		<table cellspacing="0">
			<tr>
				<th width="1%">{$lang['accounts']['id']}</th>
				<th width="20%">{$lang['accounts']['name']}</th>
				<th width="25%">{$lang['accounts']['email']}</th>
				<th width="24%">{$lang['accounts']['website']}</th>					
				<th width="15%">{$lang['accounts']['username']}</th>
				<th width="15%">{$lang['accounts']['password']}</th>
			</tr>	
			
TEMPLATE;
	}


	// A row that is selected (has input fields).
	// --------------------------------------------------
	function accountSelected($account)
	{		
		return <<<TEMPLATE
		
		<tr>
			<td>
				<input type="hidden" value="{$account['id']}" name="id" />
                <input type="text" value="{$account['id']}" name="id" class="textbox" disabled="disabled" />
			</td>		
			<td>
				<input type="text" value="{$account['title']}" name="title" class="textbox" />
			</td>
			<td>
				<input type="text" value="{$account['email']}" name="email" class="textbox" />
			</td>
			<td>
				<input type="text" value="{$account['website']}" name="website" class="textbox" />
			</td>		
			<td>
				<input type="text" value="{$account['username']}" name="username" class="textbox" />
			</td>
			<td>
				&lowast; &lowast; &lowast; &lowast; &lowast; &lowast; &lowast;
			</td>
		</tr>		
			
TEMPLATE;
	}
	

	// A row that is not selected.
	// --------------------------------------------------
	function accountNotSelected($account)
	{		
		return <<<TEMPLATE
		
		<tr>	
			<td>
				<a href="centers/accounts.center.php?account={$account['id']}" onclick="ajax_get('accounts_center', this.href); return false;">{$account['id']}</a>
			</td>			  
			<td>
				<a href="centers/accounts.center.php?account={$account['id']}" onclick="ajax_get('accounts_center', this.href); return false;">{$account['title']}</a>
			</td>
			<td>
				<a href="centers/accounts.center.php?account={$account['id']}" onclick="ajax_get('accounts_center', this.href); return false;">{$account['email']}</a>
			</td>
			<td>
				<a href="centers/accounts.center.php?account={$account['id']}" onclick="ajax_get('accounts_center', this.href); return false;">{$account['website']}</a>
			</td>									
			<td>
				<a href="centers/accounts.center.php?account={$account['id']}" onclick="ajax_get('accounts_center', this.href); return false;">{$account['username']}</a>
			</td>
			<td>
				<a href="centers/accounts.center.php?account={$account['id']}" onclick="ajax_get('accounts_center', this.href); return false;">&lowast; &lowast; &lowast; &lowast; &lowast; &lowast; &lowast;</a>
			</td>		
		</tr>		
			
TEMPLATE;
	}	


	// New account row that pops down.
	// --------------------------------------------------
	function createNewAccountRow()
	{	
		return <<<TEMPLATE
		
	 	<tr id="newAccount" style="display: none;">	 
			<td>
				<input type="hidden" value="0" name="id" />
                <input type="text" value="" name="IDdisabled" class="textbox" disabled="disabled" />
			</td>			
			<td>
				<input type="text" value="" name="title" class="textbox" />
			</td>
			<td>
				<input type="text" value="" name="email" class="textbox" />
			</td>
			<td>
				<input type="text" value="" name="website" class="textbox" />
			</td>	
			<td>
				<input type="text" value="" name="username" class="textbox" />
			</td>
			<td>
				<input type="password" value="" name="password" class="textbox" />
			</td>			
		</tr>	
			
TEMPLATE;
	}
	
	
	// Accounts footer and action buttons.
	// --------------------------------------------------
	function footer($lang, $account, $diableCreateButtons, $disableEditButtons)
	{		
		return <<<TEMPLATE
		
		</table>
		<div class="action_buttons" style="margin-top: 10px;">
        	<button type="button" name="create" {$diableCreateButtons} onclick="Effect.toggle('newAccount', 'blind', {duration: .1}); removeDisabled();">{$lang['accounts']['create']}</button>
			<button type="submit" name="save" {$disableEditButtons}>{$lang['accounts']['save']}</button>            
            <button type="button" name="delete" {$disableEditButtons} onclick="deleteAccount('centers/accounts.center.php?delete={$_GET['account']}', '{$lang['accounts']['deleteMessage']}');">{$lang['accounts']['delete']}</button>  
            <button name="close" {$disableEditButtons} onclick="ajax_get('accounts_center', 'centers/accounts.center.php?close=true'); return false;">{$lang['accounts']['close']}</button>  
		</div>
		</form>				
			
TEMPLATE;
	}
} // End of Accounts.

$Html = new Accounts;
?>