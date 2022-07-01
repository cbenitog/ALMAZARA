<?php
// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database can be set
// to be anything, however 'text' is a popular setting.
// ----------------------------------------------------------------

class Txtbox
{
	var $value;

	function Txtbox($value, $column, $settings)
	{
		switch($_GET['module'])
		{
			// Overview output.
			// -------------------------------------------------
			case "overview":
				$this->value = Utils::resizeValue(strip_tags($value), 100);
				break;

			// Entryview output.
			// -------------------------------------------------
			case "entryview":
				$this->value = '<dt>' . Utils::cleanFieldTitle($column) . '</dt><dd><textarea name="' . $column . '" rows="15" cols="9" style="width: 100%">' . stripslashes($value) . '</textarea></dd>';				
				break;

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = $value;
		}			
	}
} // End of Txtbox
?>