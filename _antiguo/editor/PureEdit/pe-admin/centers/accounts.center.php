<?php
// Determine if we need to reinclude files (due to ajax).
if ((isset($_GET['account'])) || (isset($_GET['close'])) || (isset($_GET['delete'])) || (isset($_POST['id'])))
{
	// Do we need to re-require/include these files.
	// * I'm not the best at Ajax, oops. Sorry.
	// * Is there a better way? Help! Kthxbye.
	// ==================================================
    require_once('../library/settings.lib.php');
    require_once('../databases/' . $settings['pureedit']['database'] . '.db.php');
    require_once('../library/definitions.lib.php');
    require_once('../classes/auth.class.php');
    require_once('../languages/' . LANG_PACK . '.lang.php');
    require_once('../classes/utils.class.php');
    require_once('../themes/' . APP_THEME . '/html/accounts.tpl.php');
}
else
{
	require_once('themes/' . APP_THEME . '/html/accounts.tpl.php');
}

$accounts_output .= $Html->heading($lang);

// Determine the action. 
if (isset($_GET['account'])) // Editing an account.
{
	$getAccounts = $Db->select(TABLE_PREFIX . "accounts");
	while($account = $Db->fetch_assoc($getAccounts))
	{
		if ($_GET['account'] == $account['id']) // Is the current loop the selected account?
		{	
			$accounts_output .= $Html->accountSelected($account);
		}
		else
		{
			$accounts_output .= $Html->accountNotSelected($account);
		}
	}
	
	// Disabled action buttons.
	$disableEditButtons = '';
	$diableCreateButtons = 'disabled="disabled"';
}
else // Not editing.
{
	// Actions.
	if (isset($_POST['id'])) // Action: save.
	{
		if ($_POST['id'] == "0") // It's a new one, insert it.
		{
			$Db->insert(TABLE_PREFIX . "accounts");
		}
		else // It's not new, update it.
		{
			$Db->update(TABLE_PREFIX . "accounts", $_POST['id']);
		}
	}
	elseif (isset($_GET['delete'])) // Action: delete.
	{
		$Db->delete(TABLE_PREFIX . "accounts", $_GET['delete']); 
	}
	
	// No actions.
	$getAccounts = $Db->select(TABLE_PREFIX . "accounts");
	while($account = $Db->fetch_assoc($getAccounts))
	{
		$accounts_output .= $Html->accountNotSelected($account);
	}
	
	$accounts_output .= $Html->createNewAccountRow();
	
	// Disabled action buttons.
	$disableEditButtons = 'disabled="disabled"';	
	$diableCreateButtons = '';
}

$accounts_output .= $Html->footer($lang, $account, $diableCreateButtons, $disableEditButtons);
echo $accounts_output;
?> 