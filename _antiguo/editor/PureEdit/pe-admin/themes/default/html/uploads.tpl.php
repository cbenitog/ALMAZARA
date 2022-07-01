<?php
class Uploads
{	
	// Uploads heading
	// --------------------------------------------------
	function heading($lang, $SITE_TITLE, $APP_THEME)
	{
		return <<<TEMPLATE
		
		<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		
		<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
		<head>
			<title>{$SITE_TITLE} (Powered by PureEdit).</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<link rel="stylesheet" href="../themes/{$APP_THEME}/css/global.css" type="text/css" media="screen" />   	
			<script src="../library/javascript/general.lib.js" type="text/javascript"></script>
			<script src="../library/javascript/scriptaculous/prototype.js" type="text/javascript"></script>            
			<script src="../library/javascript/scriptaculous/scriptaculous.js" type="text/javascript"></script>	    
		</head>
		<body style="padding: 0 20px;">
			
            <ul id="sectors">
                <li><a href="javascript: void(0);" id="current" class="out">{$lang['uploads']['heading']}</a></li>     
            </ul>
		
			<ul id="links">
				<li style="background: url(../themes/{$APP_THEME}/images/uploads_center.gif) no-repeat;"><a href="javascript:void(0);" onclick="Effect.toggle('uploadForm', 'blind', {duration: 0.3});">{$lang['uploads']['link']}</a></li>
			</ul>
			
			<div id="filesCenter">
				
				<div id="uploadForm" style="display: none; clear: both;">
					<table cellspacing="0">
						<tr>
							<th>{$lang['uploads']['link']}</th>
						</tr>
						<tr>
							<td>
                            
TEMPLATE;
	}
    
	// The form that drops down to upload new file header.
	// --------------------------------------------------
	function newFormHeader()
	{		
		return <<<TEMPLATE
			
        <br />
        <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="file" />
        <select name="folder">	
            
TEMPLATE;
	}	    

	// Populates the dropdown list of categories in the
    // new form slide in.
	// --------------------------------------------------
	function newFormCategoryLoop($key, $value)
	{		
		return <<<TEMPLATE
		
		<option value="{$value}">{$key}</option>
			
TEMPLATE;
	}

    // new form slide in footer
	// --------------------------------------------------
	function newFormFooter($lang)
	{		
		return <<<TEMPLATE
		
                    </select>
                    <input type="submit" name="upload" value="{$lang['uploads']['link']}" />
                    </form>
                    <br /><br />
                    </td>
                </tr>
            </table>
            <br />
        </div>
			
TEMPLATE;
	}

    // The heading of the actual listing of files.
	// --------------------------------------------------
	function fileListHeading($lang)
	{		
		return <<<TEMPLATE
		
        <br  style="clear: both;" />
        <table cellspacing="0" style="margin-bottom: 25px;">
            <tr>
                <th colspan="2">{$lang['uploads']['fileStorage']}</th>
            </tr>			
			
TEMPLATE;
	}
    
    // Category heading (nested inside files list)
	// --------------------------------------------------    
	function fileListCategoryHeading($typeKey)
	{		
		return <<<TEMPLATE
		
		<tr>
		<th colspan="2" style="color: #8ea173; border-top: none; border-bottom: none; background-color: #cadbb1;">{$typeKey}</th>
		</tr>
			
TEMPLATE;
	}
    
    // Displayed if no files were found in a category.
	// --------------------------------------------------    
	function noFilesFound($lang)
	{		
		return <<<TEMPLATE
		
        <tr>
        <td colspan="2"><em>{$lang['uploads']['noFiles']}</em></td>
        </tr>
			
TEMPLATE;
	}

    // Displayed if files found in a category.
	// --------------------------------------------------    
	function fileRow($lang, $file, $dir)
	{		
		return <<<TEMPLATE
		
        <tr>
        <td><strong><a href="javascript: void(0);" onclick="attach('{$file['file']}', {$file['id']}, '{$_GET['field']}')">{$file['file']}</a></strong></td>
        <td style="text-align: right;">
            | (<a href="{$dir}{$file['file']}" target="_blank">{$lang['uploads']['preview']}</a>) 
            | (<a href="?delete=true&amp;folder={$file['folder']}&amp;file={$file['file']}&amp;id={$file['id']}&amp;field={$_GET['field']}">{$lang['uploads']['delete']}</a>) 
            | (<a href="javascript: void(0);" onclick="attach('{$file['file']}', {$file['id']}, '{$_GET['field']}')">{$lang['uploads']['attach']}</a>) |
        </td>
        </tr>
			
TEMPLATE;
	}

    // The footer.
	// --------------------------------------------------
	function footer()
	{		
		return <<<TEMPLATE
		
                </table>    
                    
            </div>
        
        </body>
        </html>		
			
TEMPLATE;
	}        
} // End of Uploads.

$Html = new Uploads;
?>