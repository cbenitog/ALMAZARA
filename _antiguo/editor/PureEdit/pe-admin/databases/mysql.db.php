<?php
class Db
{
	// Constructor method.
	// -------------------------------------------------
    function Db($host, $username, $password, $database)
    {
        $this->connect($host, $username, $password, $database);
    }
    
	function connect($host, $username, $password, $database)
	{
		mysql_select_db($database, mysql_connect($host, $username, $password));
	}

	// Delete method.
	// -------------------------------------------------
	function delete($table, $id)
	{
		$sql = "DELETE FROM `" . $table . "` WHERE `id` = '" . Db::escape($id) . "'";
		return mysql_query($sql);
	}

	// Select method.
	// -------------------------------------------------
	function select($table, $id=null)
	{
	    if ( $id!="0" && empty($id)) // No $id given, thus select all rows.
        {
		    $sql = "SELECT * FROM `" . $table . "` ORDER BY `id`";
		}
		elseif (is_array($id)) // grabs rows matching WHERE clauses match.
		{
			$sql = "SELECT * FROM `" . $table . "` WHERE ";
			
			$first = true;
			foreach($id as $col => $val)
			{
				if($first)
				{
	    	 		$first=false;
				}
				else
				{
					$sql.=" AND ";
				}
				
				$sql .= "`" . Db::escape($col) . "` = '" . Db::escape($val) . "'";
			}

		}
		else // Grabs the row associated with the given $id.
		{
				$sql = "SELECT * FROM `" . $table . "` WHERE `id` = '" . Db::escape($id) . "'";
		}
		
		return mysql_query($sql);
	}

	// Update method.
	// -------------------------------------------------
	function update($table, $id)
	{
		$getColumns = mysql_query("SELECT * FROM " . $table);
		while($column = mysql_fetch_field($getColumns))
		{
			$column = $column->name;
			if (isset($_POST[$column]))
			{
				Utils::manipulateValues($column); // Manipulate certain values before inserting them into db.	
				$fields[] = "`" . $column . "` = '" . Db::escape($_POST[$column]) . "'";
			}
		}

		$sql = "UPDATE `" . $table . "` SET " . implode(", ", $fields) . " WHERE `id` = '" . $id . "'";
		return mysql_query($sql);
	}

	// Insert method.
	// -------------------------------------------------
	function insert($table)
	{
		$getColumns = mysql_query("SELECT * FROM " . $table);

		while($column = mysql_fetch_field($getColumns))
		{
			$column = $column->name;
			if (isset($_POST[$column]))
			{
				Utils::manipulateValues($column); // Manipulate certain values before inserting them into db.                                 	
				$fields[$column] = "'" . Db::escape($_POST[$column]) . "'";
			}
		}

		$sql = "INSERT INTO `" . $table . "` (`" . implode("`, `", array_keys($fields)) . "`) VALUES (" . implode(", ", $fields) . ")";
		return mysql_query($sql);
	}
	
	// Normal query for custom needs.
	// NOTICE: When using this method, it is your job to assure user submitted-data is secure.
	// -------------------------------------------------
	function query($sql)
	{
		return mysql_query($sql);
	}
	
	function insert_id()
	{
		return mysql_insert_id();
	}
	
	function num_fields($result)
	{
	    return mysql_num_fields($result);
	}
	
	function fetch_field($result)
	{
	    return mysql_fetch_field($result);
	}
	
	function fetch_row($result)
	{
	    return mysql_fetch_row($result);
	}
	
	function num_rows($result)
	{
	  return mysql_num_rows($result);
	}
	
	function fetch_array($result)
	{
	    return mysql_fetch_array($result);
	}
	
	function fetch_assoc($result)
	{
	    return mysql_fetch_assoc($result);
	}
	
	function escape($string)
	{
	    return mysql_real_escape_string($string);
	}


	// Custom queries used by PE.
	// -------------------------------------------------
	function table_exists($sector)
	{
		$getTables = mysql_query("SHOW TABLES");
		while($table = mysql_fetch_array($getTables))
		{
			if ($sector == $table[0])
			{
				return true;
			}
		}
	}
	
    function show_columns($table, $column)
    {
        return mysql_query("SHOW COLUMNS FROM `" . $table . "` LIKE '" . $column . "'");
    }
		
}

$Db = new Db($settings['database']['databaseHost'], $settings['database']['databaseUsername'], $settings['database']['databasePassword'], $settings['database']['databaseName']);
?>