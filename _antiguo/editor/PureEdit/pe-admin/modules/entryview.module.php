<?php
if (isset($_POST['save'])) // Are we saving?
{
	(isset($_GET['id'])) ? $Db->update(SECTOR_ABBREV, $_GET['id']) : $Db->insert(SECTOR_ABBREV);
	header('location: index.php?module=overview&sector=' . $_GET['sector']);
}
else // Display fields.
{		
	$module_output .= $Html->entryviewHeader($endUrlString = (isset($_GET['id'])) ? '&amp;id=' . $_GET['id'] : '');
	
	$getEntry = (isset($_GET['id'])) ? $Db->select(SECTOR_ABBREV, $_GET['id']) : $Db->select(SECTOR_ABBREV, "0");
	$entry = $Db->fetch_row($getEntry);
	
	$getColumn = $Db->select(SECTOR_ABBREV, "0");

	for($i = 0; $i < $Db->num_fields($getColumn); $i++) // Loop through all columns (not rows).
	{
		// Find/Build column and values.
		$column = $Db->fetch_field($getColumn);
		$column = $column->name;
		$value = $entry[$i];

		$field = $Utils->findField($column); // Find/Build field type.

		if (($field == "id" && $settings['pureedit']['showId'] == true) || $field != "id")
		{
			if (@!include_once('fields/' . $field . '.field.php')) // Checks to see if the field is predefined.
			{													   // If it is not then it uses default (txt).
				$field = "txt";
			}
			else if (class_exists($field)) // If class exisits then convert value.
			{
				$value = stripslashes(htmlentities ($value, ENT_QUOTES, "UTF-8"));
				$getValue = new $field($value, $column, $settings);
				$module_output .= $getValue->value;
			}	
		}
	}
	
	$module_output .= $Html->entryviewFooter($lang);
}
?>