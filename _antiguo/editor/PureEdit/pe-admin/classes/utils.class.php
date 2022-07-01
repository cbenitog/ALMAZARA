<?php
class Utils
{
	// Manipulate values before inserting or updating into db.
	// Used by the db class.
	// Doesn't return anything cause it modifies the $_POST.
	function manipulateValues($column)
	{
		$field = Utils::findField($column);
		if ($column == "password") // Password? Then hash it.
		{
			$_POST[$column] = md5($_POST[$column]);
		}
		elseif ($field == "date") // Date? Then timestamp it.
		{
			$_POST[$column] = mktime(0, 0, 0, $_POST[$column][0], $_POST[$column][1], $_POST[$column][2]);
		}
	}
	
	// Strips whatever is after the last _ in your column name and labels that as the field.
	function findField($column)
	{
		return ltrim(substr($column, strrpos($column, "_")), "_");
	}	
	
	// Get a list of enum values in an array.
    function getEnumValues($table, $column)
	{
        $enum_array = array();
        $result = Db::show_columns($table, $column);
        $row = Db::fetch_row($result);
        preg_match_all('/\'(.*?)\'/', $row[1], $enum_array);
        
        if(!empty($enum_array[1]))
        {
            // Shift array keys to match original enumerated index in MySQL (allows for use of index values instead of strings)
            foreach($enum_array[1] as $mkey => $mval) $enum_fields[$mkey+1] = $mval;
            return $enum_fields;
        }
        else
        {
            // Return an empty array to avoid possible errors/warnings if array is passed to foreach() without first being checked with !empty().   
            return array();
        }
    }					
    
	// Reset Password.
    function resetPassword($length = 6)
    {
        $password = "";
        $possible = "123456789bcdfghjkmnpqrstvwxyz"; 
        
        for ($i = 0; $i < $length; $i++)
        { 
            $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
            $password .= $char;
        }
        
        return $password;
    }	
    
	// Value too big?
    function resizeValue($value, $length)
    {
        return (strlen($value) > $length) ? substr($value, 0, $length) . '...' : $value;
    }	  
	
	// Takes the title and cleans it up.
	// Written by "nazzz" from the PE community.
	// Added 6/8/2008
	function cleanFieldTitle($title)
	{
		//Break field name in to words
		$array = explode('_', $title);
		
		//If first word is table prefix remove it.
		if(current($array) . "_" == TABLE_PREFIX) array_shift($array);
		
		//If last word is field extention remove it.
		if(count($array) > 1) array_pop($array);
		
		//If there is more than one word insert space between them
		$title = (count($array) > 1) ? implode(" ", $array) : current($array);
		
		return ucwords($title);
	}	  			
} // End of Utils	

$Utils = new Utils;
?>