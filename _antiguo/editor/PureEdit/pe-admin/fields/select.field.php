<?php
/*****************************************************
 * Original idea by Bryan Andrews <bandrews@valleytechnologiesllc.com>
 * Modified from radio inputs to select fields by Evan Dudla <evan.dudla@gmail.com>
*/

// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database MUST be 'enum' and your
// values/types should be listed like: 'Option1', 'Option1', 'Option3'...
// ----------------------------------------------------------------

class Select
{
	var $value;

	function Select($value, $column, $settings)
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

                $this->value .= '<select name="' . $column . '" class="select"><option></option>';
				foreach ($options as $key => $option)
				{
					$option = str_replace("'", "", $option); // bug? what if an enum option has a comma...
					$selected = ($value == $option) ? 'selected="selected"' : ''; // are we selected?						
					$this->value .= '<option value="' . $option . '" ' . $selected .'>' . $option . '</option>';
				}
				$this->value .= '</select>';

				
				$this->value .= '</dd>';
				break;

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = $value;
		}			
	}
} // End of Select
?>