<?php
// If we are not logged in.
if (isset($_SESSION['key'][$settings['pureedit']['sessionKey']]))
{	
	// Delete entries if delete was hit.
	if (isset($_POST['deleteSubmit']) && isset($_POST['delete']))
	{
		foreach ($_POST['delete'] AS $key => $id)
		{
			$Db->delete(SECTOR_ABBREV, $id);
		}	
	}

	// Check to see if table (sector) exsists.
	if ($Db->table_exists(SECTOR_ABBREV))
	{
		// Check to see if we need to override columns.
		$columnsToShow =  (array_key_exists(SECTOR_ABBREV, $settings['columns'])) ? 'id, ' . $settings['columns'][SECTOR_ABBREV] : '*';
		$getEntries = $Db->query("SELECT " . $columnsToShow . " FROM " . SECTOR_ABBREV);

		// Print heading row.
		$module_output .= $Html->heading();
		for($i = 0; $i < $Db->num_fields($getEntries); $i++)
		{
			$column = $Db->fetch_field($getEntries, $i);
			$column = $column->name;
			
			$field = $Utils->findField($column);
			if (@!include_once('fields/' . $field . '.field.php'))
			{
				$module_output .= $Html->fieldNotFound($lang, $field);
			}		

			$module_output .= $Html->tableHeadingLoop(Utils::cleanFieldTitle($column));			
		}	
		$module_output .= $Html->tableHeadingFooter();
	
		// Start listing.
		if ($Db->num_rows($getEntries) > 0)
		{
			while($entry = $Db->fetch_assoc($getEntries))
			{
				$module_output .= $Html->entryListHeading();
						
				foreach($entry as $column => $value)
				{
						$field = $Utils->findField($column);
						if (class_exists($field))
						{
							$value = stripslashes(htmlentities ($value, ENT_QUOTES, "UTF-8"));
							$getValue = new $field($value, $column, $settings);
							$value = $getValue->value;
						}

					$module_output .= $Html->entryListLoop($value);
				}
				$module_output .= $Html->entryListFooter($entry);
			}
		}
		else
		{
			$module_output .= $Html->entriesNotFound($settings);
		}
	
		$module_output .= $Html->footer($lang, $entry, SECTOR_ABBREV);
	}
	else
	{
		$module_output .= $Html->sectorTableNotFound($lang, $entry, $settings, SECTOR_ABBREV);
	}
}
else
{
	require_once('index.html'); // Access denied.
}		
?> 