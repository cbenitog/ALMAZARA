<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
    <title><?php echo SITE_TITLE; ?> (Powered by PureEdit)</title>
    <link rel="stylesheet" href="themes/<?php echo APP_THEME; ?>/css/global.css" type="text/css" media="screen" />
    <script type="text/javascript" src="library/javascript/general.lib.js"></script>   	
    <script type="text/javascript" src="library/javascript/scriptaculous/prototype.js"></script>    	
    <script type="text/javascript" src="library/javascript/tiny_mce/tiny_mce.js"></script>
    <script type="text/javascript" src="library/javascript/scriptaculous/scriptaculous.js" ></script>	    

</head>
<body onload="setTimeout('100, document.login.username.focus()');<?php echo ($authRetry == true) ? ' Effect.Shake(\'shake\');' : ''; ?>" id="auth">

    <form name="login" method="post" action="index.php?authenticate=in" id="shake">

        <dl>
            <dt<?php echo ($authRetry == true) ? ' style="color: #cc6060;"' : ''; ?>><?php echo $lang['auth']['username']; ?>:</dt>
            <dd> <input name="username" type="text" /></dd>
            <dt<?php echo ($authRetry == true) ? ' style="color: #cc6060;"' : ''; ?>><?php echo $lang['auth']['password']; ?>:</dt>
            <dd><input name="password" type="password" /></dd>
        </dl>

        <button type="submit" name="loginButton"><?php echo $lang['auth']['login']; ?></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<a href="../index.php"><?php echo $lang['auth']['goBack']; ?></a>)
        &nbsp;&nbsp;&nbsp;(<a href="javascript:void(0);" onclick="Effect.toggle('forgetPassword', 'blind', {duration: 0.2});"><?php echo $lang['auth']['forgotPassword']; ?></a>)
        
    </form>
    
    <div id="forgetPassword" style="display: none;">
    <?php include_once('centers/passwordReset.center.php'); ?>
    </div>
    
</body>
</html>