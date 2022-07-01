<?php
// Determine if we need to reinclude files (due to ajax).
if (isset($_POST['email']) || isset($_GET['tryagain']))
{
	// Do we need to re-require/include these files.
	// * I'm not the best at Ajax, oops. Sorry.
	// * Is there a better way? Help! Kthxbye.
	// ==================================================
    require_once('../library/settings.lib.php');
    require_once('../databases/' . $settings['pureedit']['database'] . '.db.php');
    require_once('../library/definitions.lib.php');
    require_once('../classes/utils.class.php');
    require_once('../languages/' . LANG_PACK . '.lang.php');
}
if (!isset($_POST['email']))
{
    $reset_output .= '        
       <p>' . $lang['auth']['resetInstructions'] . '</p>
        
        <form method="post" action="centers/passwordReset.center.php" onsubmit="new Ajax.Updater(\'forgetPassword\', this.action, {asynchronous:true, parameters:Form.serialize(this)}); return false;">
            <dl style="margin: 15px 0 0;">
                <dt>' . $lang['auth']['email'] . ':</dt>
                <dd> <input name="email" type="text" id="email" /></dd>
            </dl>

            <button type="submit" name="resetPassword">' . $lang['auth']['resetPassword'] . '</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<a href="javascript:void(0);" onclick="Effect.toggle(\'forgetPassword\', \'blind\', {duration: 0.2});">' . $lang['auth']['cancelReset'] . '</a>)
        </form>
    ';  
}
else
{
    if ($_POST['email'] == "")
    {
        $reset_output .= $lang['auth']['noEmailWasTypedIn'];
    }
    else
    {
        $getEmail = $Db->query("SELECT * FROM `" . TABLE_PREFIX . "accounts` WHERE `email`='" . $_POST['email'] . "'");
        if (mysql_num_rows($getEmail) <= 0)
        {
            $reset_output .= $lang['auth']['emailNotFound'];
        }
        else
        {
            $new_password = $Utils->resetPassword();
            $Db->query("UPDATE `" . TABLE_PREFIX . "accounts` SET `password`='" . md5($new_password) . "' WHERE `email`='" . $_POST['email'] . "'");
            mail($_POST['email'], $lang['auth']['emailSubject'], $lang['auth']['emailMessage'] . $new_password, "From: " . SITE_TITLE);
            $reset_output .= $lang['auth']['emailFound']; 
        }
    }    
}

echo $reset_output;
?> 