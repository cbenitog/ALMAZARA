<?php
/*****************************************************
 * By Bryan Andrews <bandrews@valleytechnologiesllc.com>
*/

// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database MUST be 'enum' and your
// values/types should be listed like: 'Button1', 'Button1', 'Button3'...
// ----------------------------------------------------------------

class Radio
{
	var $value;

	function Radio($value, $column, $settings)
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
				$this->value .= '<dt>' . Utils::cleanFieldTitle($column) . '</dt><dd>';

                $options = Utils::getEnumValues(SECTOR_ABBREV, $column);           

				foreach ($options as $key => $option)
				{
					$option = str_replace("'", "", $option); // bug? what if an enum option has a comma...
					$checked = ($value == $option) ? 'checked="checked"' : ''; // are we checked?						
					$this->value .= '<input type="radio" name="' . $column . '" value="' . $option . '" ' . $checked . '/> ' . $option . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
			
				$this->value .= '</dd>';
				break;

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = $value;
		}			
	}
} // End of Enum
?>
