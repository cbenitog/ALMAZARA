<?php
// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database MUST be 'int' and your
// ----------------------------------------------------------------

class Rel
{
	var $value;

	function Rel($value, $column, $settings)
	{
		switch($_GET['module'])
		{
			// Overview output.
			// -------------------------------------------------
			case "overview":
				$foreignTable = substr($column, 0, strrpos($column, '_'));
				$getRelation = Db::select($foreignTable, $value);
				$relation = Db::fetch_array($getRelation);		
				$this->value = Utils::resizeValue(strip_tags($relation[1]), 30);
				break;

			// Entryview output.
			// -------------------------------------------------
			case "entryview":				
				$foreignTable = substr($column, 0, strrpos($column, '_'));
				$getRelation = Db::select($foreignTable);
				
				$this->value .= '<dt>' . Utils::cleanFieldTitle($column) . '</dt>';
				$this->value .= '<dd><select name="' . $column . '" class="select">';
				$this->value .= '<option value=""></option>';
				
				while($relation = Db::fetch_array($getRelation))
				{
					$selected = ($value == $relation['id']) ? ' selected="selected"' : '';
					$this->value .= '<option value="' . $relation[0] . '"' . $selected . '>' . $relation[1] . '</option>';
				}
				
				$this->value .= '</select></dd>';
				break;

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = $value;
		}	
	}
} // End of Rel
?>