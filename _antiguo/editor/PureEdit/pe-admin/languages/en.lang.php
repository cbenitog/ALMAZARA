<?php
// Wrapper trasnlations (Header/Nav/Footer)
$lang['wrapper'] = array
(
    "logout" => "Logout",
    "poweredby" => "Powered by",
    "copyright" => "&copy; 2008"
);

// Auth login areas.
$lang['auth'] = array
(
    // Login form.
    "username" => "Username",
    "password" => "Password",
    "login" => "Continue to login &gt;",
    "goBack" => "Cancel, go back",
        
    // Reset password.
    "resetInstructions" => "To reset your password, fill out the input field below and then your new password will be emailed to you.",         
    "forgotPassword" => "Reset your password?",        
    "resetPassword" => "Reset Password",          
    "cancelReset" => "Cancel, close reset form",     
    "email" => "Email",    
    "noEmailWasTypedIn" => "<b>Sorry!</b><br /><br />You did not input an email to search for. Please <a href=\"centers/passwordReset.center.php?tryagain=true\" onclick=\"ajax_get('forgetPassword', this.href); return false;\">try again</a>.",
    "emailFound" => "<b>Congratulations!</b><br /><br />Your email was found in our database and your new password has been emailed to the email on file.<br /><br /><a href=\"javascript:void(0);\" onclick=\"Effect.toggle('forgetPassword', 'blind', {duration: 0.2});\">Close forgot password module</a>",
    "emailNotFound" => "<b>Sorry!</b><br /><br />The email you submitted was not found on file. Please <a href=\"centers/passwordReset.center.php?tryagain=true\" onclick=\"ajax_get('forgetPassword', this.href); return false;\">try again</a>",
    "emailSubject" => "Your password has been reset!",
    "emailMessage" => "Thank you for resetting your password. You may now login using this passowrd: ",        
        
    // Redriect
    "redirect" => "Please wait while we log you <strong>" . $_GET['authenticate'] . "</strong>. <br /><br /><a href=\"index.php\">Or, click here to be redirected manually.</a>"
);

// Dashboard translations.
$lang['dashboard'] = array
(
    "recentActivityHeader" => "Recent Activity",
    "recentActivityText" => "<br /><br /><p style=\"color: #a3a3a3; text-align: center;\">Recent activity feature is in the making and <br /> will be released in a future update. I apologize for any inconvenience.</p><br /><br /><br />",
    "openAreaHeader" => "Open Area for Unique Use",
    "openAreaText" => "<br /><br /><p style=\"color: #a3a3a3; text-align: center;\">This area is here to demonstrate your ability to add <br /> in custom boxes for your own unique use.</p><br /><br /><br />",
    "warningHeader" => "Warning! PureEdit has found a potential risk.",
    "warningProblem" => "The Problem: The <strong>/install</strong> directory is still in exsistance and can be a possible security threat.",
    "warningSolution" => "The Solution: Delete the <strong>/install</strong> directory as quickly as possible."
);

// Overview translations.
$lang['overview'] = array
(
    "warningHeader" => "Warning! PureEdit has encountered an error.",
    "warningProblem" => "The Problem: A table named <strong>" . SECTOR_ABBREV . "</strong> could not be found.",
    "warningSolution" => "The Solution: Create a table called <strong>" . SECTOR_ABBREV . "</strong>.",
    "fieldNotFound" => "Warning! PureEdit could not find the following field: ",
    "create" => "Create an entry",
    "delete" => "Delete an entry",
    "deleteMessage" => "Delete these entry(s)?"
);


// Entryview translations.
$lang['entryview'] = array
(
    "save" => "Save this entry &gt;",
    "cancel" => "&lt; Cancel and go back"
);

// Sectors Center translations.
$lang['sectors'] = array
(
    "heading" => "Sectors Center",
    "title" => "Title",
    "abbrev" => "Abbrev",
    "save" => "Save this sector",
    "close" => "Close, do not save this sector"
);

// Account Centers translations.
$lang['accounts'] = array
(
    "heading" => "Accounts Center",
    "id" => "ID",
    "name" => "Name",        
    "email" => "Email",        
    "website" => "Website",
    "username" => "Username",
    "password" => "Password",
    "create" => "Create an account",
    "delete" => "Delete this account",
    "deleteMessage" => "Delete this account?",
    "save" => "Save this account",
    "close" => "Close, do not save this account"    
);

// Uploads Centers translations.
$lang['uploads'] = array
(
    "heading" => "Uploads Center",
    "link" => "Upload new file",
    "fileStorage" => "Files in Storage",
    "noFiles" => "No files have been uploaded to this folder.",
    "preview" => "Preview",
    "delete" => "Delete",
    "attach" => "Attach"        
);

// Help Center translations.
$lang['help'] = array
(
    "heading" => "Help Center",
    "text" => "Every PureEdit you install will include unique features that will be specific to that installation only. Since this is the case, the <strong>Help Center</strong> has been left open for you to implement your own unique help topics to accomdate these unique features.
                    <!-- An example of an <a href=\"centers/help.center.php?topic=1\" onclick=\"ajax_get('help_center', this.href); return false;\">ajax powered link</a> is right there and <a href=\"centers/help.center.php?topic=2\" onclick=\"ajax_get('help_center', this.href); return false;\">here</a>. -->"      
);

// Install translations.
$lang['install'] = array
(
    // Permissions Check Step
    "headingPermissionsCheck" => "Permissions Check",
    "descPermissionsCheck" => "<p>PureEdit is checking the file permissions on the files listed below. Files highlighted <span id=\"green\">green</span> have the correct permissions, however files highlighted <span id=\"red\">red</span> need to be corrected to match the needed permission.</p>",
    "notePermissionsCheck" => "Some servers will give a 500 Internal Server Error if you set the permissions on files to anything higher than 755. If you get this error when changing the permissions to 777, set them to 755 instead, then proceed to <b>skip this step</b>.",
    "tableHeadingFilePath" => "filePath",
    "tableHeadingNeededCHMOD" => "Needed CHMOD",
    "tableHeadingCurrentCHMOD" => "Current CHMOD",
    "buttonRefreshAndCheckAgain" => " Refresh &amp; Check Again ",
    "buttonContinueToWebsiteSetup" => " Continue to Website Setup &gt; ",
    "linkOrSkipThisStep" => "or skip this step (not recommended) &gt;&gt;",
        
    // Website Setup Step
    "headingWebsiteSetup" => "Website Setup",
    "descWebsiteSetup" => "<p>First, PureEdit needs to know your website title and url so that it can properly redirect you after installation is complete.</p>",
    "websiteErrorText" => "PureEdit was unable to see both your <strong>Title</strong> and <strong>Url</strong>, please input your data again and try again.",
    "websiteSuccessText" => "PureEdit properly set the title and url of your website, continue on to setup your database.",
    "buttonContinueToDatabase" => " Continue to Database Setup &gt; ",
    "websiteSetupWebsiteTitle" => "Website Title",
    "websiteSetupWebsiteURL" => "Website Url",
    "buttonProcessWebsiteInfo" => " Process Website Information &gt; ",
        
    // Database Setup Step
    "headingDatabaseSetup" => "Database Setup",
    "descDatabaseSetup" => "<p>To continue, PureEdit needs to know your database login information so it can connect and install the database portion of the application.</p>",
    "errorDatabaseSetup" => "PureEdit was unable to connect to the given database; either your database was not found or the input you typed in is not correct. Fix the problem and please try again.",
    "noerrorDatabaseSetup" => "PureEdit has finished setting up your database, go ahead and proceed to setup the first account so you can login and get to working!",
    "buttonContinueToAccountsSetup" => " Continue to Account Setup &gt; ",
    "localhost" => "Database Host",
    "dbUsername" => "Database Username",
    "dbName" => "Database Name",
    "dbPassword" => "Database Password",
        
    // Account Setup Step
    "headingAccountSetup" => "Account Setup",
    "descAccountSetup" => "<p>To get you logged in for the first time, PureEdit needs to know some info about the first account you need created. Fill in the input boxes and proceed to finlize the installation.</p>",
    "errorAccountSetup" => "PureEdit was unable to create your first account, please ensure that you have filled out each input box, then proceed to continue.",
    "noerrorAccountSetup" => "PureEdit has finished setting up your first account, go ahead and proceed to get logged in!",
    "buttonAccountSetup" => " Continue to Login &gt; ",
    "accountName" => "Name",
    "accountUsername" => "Username",
    "accountWebsite" => "Website",
    "accountPassword" => "Password",
    "accountEmail" => "Email",
    "buttonProcessInfo" => " Process Account Information &gt; "
);
?>