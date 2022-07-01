<?php
// ----------------------------------------------------------------
// NOTE:
// When using this field, the field type in the database MUST be 'int'.
// ----------------------------------------------------------------

class File
{
	var $value;

	function File($value, $column, $settings)
	{
		switch($_GET['module'])
		{
			// Overview output.
			// -------------------------------------------------
			case "overview":
				if ($value != null) // Only selects file name if value is set.
				{
					$getFileName = Db::select(TABLE_PREFIX . "uploads", $value);
					$file = Db::fetch_assoc($getFileName);
				}			
				$this->value = $file['file'];
				break;

			// Entryview output.
			// -------------------------------------------------
			case "entryview":
				if ($value != null) // Only selects file name if value is set.
				{
					$getFileName = Db::select(TABLE_PREFIX . "uploads", $value);
					$file = Db::fetch_assoc($getFileName);
				}
				
				// Populate the output.
				$this->value = '<dt>' . Utils::cleanFieldTitle($column) . '</dt>
								<dd>
									<input type="hidden" name="' . $column . '" id="' . $column . '_id" value="' . $value . '" />
									<input type="text" value="' . $file['file'] . '" class="file" id="' . $column . '" disabled="disabled"/> 
									&nbsp;(<a href="javascript: void(0);" onclick="uploadsCenter(\'' . $column . '\');">attach a file</a>)
									&nbsp;or
									&nbsp;(<a href="javascript: void(0);" onclick="clearFileField(\'' . $column . '\');">clear this field</a>)
								</dd>';				
				break;

			// Module not found so output typical value.
			// -------------------------------------------------
			default:
				$this->value = $value;
		}			
	}
} // End of File
?>