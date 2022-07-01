<?php
// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database can be set
// to be anything, however 'varchar' is a popular setting.
// ----------------------------------------------------------------

class Txt
{
	var $value;

	function Txt($value, $column, $settings)
	{
		switch($_GET['module'])
		{
			// Overview output.
			// -------------------------------------------------
			case "overview":
				$this->value = Utils::resizeValue(strip_tags($value), 30);
				break;

			// Entryview output.
			// -------------------------------------------------
			case "entryview":
				$this->value = '<dt>' . Utils::cleanFieldTitle($column) . '</dt><dd><input type="text" name="' . $column . '" value="' . $value . '" class="txt" /></dd>';				
				break;

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = $value;
		}
	}
} // End of Txt
?>