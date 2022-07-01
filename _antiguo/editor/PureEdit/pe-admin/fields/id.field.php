<?php
// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database CAN be
// anything, however the most popular use is 'int', and if it's 'int',
// then you are going to want to 'auto_increment' it.
// ----------------------------------------------------------------

class Id
{
	var $value;

	function Id($value, $column, $settings)
	{
		switch($_GET['module'])
		{
			// Overview output.
			// -------------------------------------------------
			case "overview":
				$this->value = '<a href="index.php?module=entryview&amp;sector=' . $_GET['sector'] . '&amp;id=' . $value . '">' . $value . '</a>';
				break;

			// Entryview output.
			// -------------------------------------------------
			case "entryview":    		                                                                                              
				$this->value = '<dt>' . Utils::cleanFieldTitle($column) . '</dt><dd><input type="text" name="id" value="' . $value . '" class="txt" disabled="disabled" /></dd>';	
				break;		

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = $value;
		}			
	}
} // End of Id
?>