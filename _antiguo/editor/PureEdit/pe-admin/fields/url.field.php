<?php
// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database can be set
// to be anything, however 'varchar' is a popular setting.
// ----------------------------------------------------------------

class Url
{
	var $value;

	function Url($value, $column, $settings)
	{
		switch($_GET['module'])
		{
			// Overview output.
			// -------------------------------------------------
			case "overview":
				$this->value = '<a href="' . $value . '">' . $value . '</a>';
				break;

			// Entryview output.
			// -------------------------------------------------
			case "entryview":
				$this->value = '<dt>' . $column . '</dt><dd><input type="text" name="' . $column . '" value="' . htmlentities($value) . '" class="txt" /></dd>';				
				break;

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = '<a href="' . $value . '">' . $value . '</a>';
		}			
	}
} // End of Url
?>