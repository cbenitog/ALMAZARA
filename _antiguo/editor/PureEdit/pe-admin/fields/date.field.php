<?php
// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database MUST be
// be able to accept an integer the size of a timestamp.
// ----------------------------------------------------------------

class Date
{
	var $value;
	var $column;

	function Date($value, $column, $settings)
	{
		$settings['date']['types'] 	= array("mon" => "months", "mday" => "days", "year" => "years");
		$settings['date']['months'] = array("1" => "January", "2" => "Feburary", "3" => "March", "4" => "April", "5" => "May", "6" => "June", "7" => "July", "8" => "August", "9" => "September", "10" => "October", "11" => "November", "12" => "December");
		$settings['date']['days'] 	= array("1" => "1", "2" => "2", "3" => "3", "4" => "4", "5" => "5", "6" => "6", "7" => "7", "8" => "8", "9" => "9", "10" => "10", "11" => "11", "12" => "12", "13" => "13", "14" => "14", "15" => "15", "16" => "16", "17" => "17", "18" => "18", "19" => "19", "20" => "20", "21" => "21", "22" => "22", "23" => "23", "24" => "24", "25" => "25", "26" => "26", "27" => "27", "28" => "28", "29" => "29", "30" => "30", "31" => "31");
		$settings['date']['years'] 	= array( "2002" => "2002",  "2003" => "2003",  "2004" => "2004",  "2005" => "2005",  "2006" => "2006",  "2007" => "2007", "2008" => "2008", "2009" => "2009", "2010" => "2010");
			
		switch($_GET['module'])
		{
			// Overview output.
			// -------------------------------------------------
			case "overview":
				$this->value = date("m/d/Y", $value);
				break;

			// Entryview output.
			// -------------------------------------------------
			case "entryview":
				// Determine to use today's date or date in DB.
				$date = (isset($_GET['id'])) ? getdate($value) : getdate(time());

				$this->value .= '<dt>' . Utils::cleanFieldTitle($column) . '</dt><dd>'; // Header of date boxes.

				// Loops through date 'types' (month, day, year) from settings.
				foreach($settings['date']['types'] AS $typeKey => $typeValue)
				{	
					$this->value .= '<select name="' . $column . '[]" style="padding: 3px; width: 100px;"><option value=""></option>';
				
					// Loop through type.
					foreach($settings['date'][$typeValue] AS $key => $value)
					{
						if($date[$typeKey] == $key)
						{
							$selected = 'selected="selected"';
						}

						$this->value .= '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
						$selected = '';
					}

					$this->value .= '</select> ';
				}	

				$this->value .= '</dd>';
				break;
						
			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = date("m/d/Y", $value);
		}			
	}
} // End of Date
?>