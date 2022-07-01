<?php
// Do a test connection so that we can determine if provided input is correct.
function dbConnections()
{
    switch($_POST['databaseType'])
    {
        case 'mysql':
            return @mysql_select_db($_POST['databaseName'], mysql_connect($_POST['databaseHost'], $_POST['databaseUsername'], $_POST['databasePassword']));
            
        /*
        case 'pgsql':
            $check =  @pg_select($_POST['databaseName'], @pg_connect($_POST['databaseHost'], $_POST['databaseUsername'], $_POST['databasePassword']));
        */
    }
}

// Check permissions function.
function check_perm($file_path)
{
	global $continue, $content;

	clearstatcache();
	$file_perm = substr(sprintf('%o', fileperms($file_path)), -3); 
	$file_type = "File";
	if (!is_writable($file_path))
	{
		$class = "bad";
		$file_status = "Not Writable";
		array_push($continue, "bad");
	}
	else
	{
		$class = "good";
		$file_status = "OK!";
		array_push($continue, "good");
	}
	
	// If the path leads to a dir then change type to DIR.
	if(is_dir($file_path))
	{
		$file_type = "Directory";
	}
	
	$content .= '<tr>'; 
	$content .= '<td class="' . $class . '">' . $file_path . '</td>'; 
	$content .= '<td class="' . $class . '">' . $file_type . '</td>'; 		
	$content .= '<td class="' . $class . '">' . $file_perm . '</td>'; 	
	$content .= '<td class="' . $class . '">' . $file_status . '</td>'; 
	$content .= '</tr class="' . $class . '">';
}	

// Print strings to a file.
if (!function_exists('file_put_contents'))
{
   function file_put_contents($file, $contents = '', $method = 'w')
   {
      $file_handle = fopen($file, $method);
      fwrite($file_handle, $contents);
      fclose($file_handle);

      return true;
   }
}

// change settings to settings.lib.php/
function change_setting($setting, $newValue)
{
	$open_settings = fopen("../library/settings.lib.php", "r+");
	$copy = file_get_contents("../library/settings.lib.php");
	
	// Setup strings to read/write.
	$old_settings = '"' . $setting . '" => ""';
	$new_settings = '"' . $setting . '" => "' . $newValue . '"';	
	
	$paste = str_replace($old_settings, $new_settings, $copy);
	file_put_contents("../library/settings.lib.php", $paste);
	fclose($open_settings);
}
?>