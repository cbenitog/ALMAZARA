<?php

/* CLASE POST

// omprueba los datos que se reciben por POST para ver si son correctos, y trabaja con las siguientes variables:   
//	- parametros: descripción de los datos que se espera recibir, indicando: nombre, tipo, obligatoriedad
//	- valores: los valores recuperados que han resultado ser válidos
//	- error: a 1 si se ha encontrado algún error.
//	- errores: array de errores en los datos de entrada, representados por valores numéricos. 
//	- errores_obligatorio: array de errores si era obligatorio y no hay valor
//	-   	

*/

class post {
	
	public $parametros;
	public $valores;
	public $error, $errores;
	public $utf8;

	
	
	
	
	function consulta($id, $tabla) {
		
		$args = func_get_args();
		$where = $args[2];
		$extra = $args[3];
		$id_nombre = $args[4];
		
		
		if (!$id_nombre) {
			$id_nombre = "id_" . $tabla;
		}
		$primero = 1; 
		foreach ($this->valores as $key => $value) {

						// Preparamos algunos valores
			if ($this->parametros[$key][0] == "date") {
				if ($value) {
					$value = fecha_bbdd($value);
				} else {
					continue;
				}
			} else if ($this->parametros[$key][0] == "int") {
				if (!$value) {
					$value = 0;
				}
			}
			
			$value = addslashes(stripslashes($value));
					
			
			if ($id) {
				if ($primero) {
					$primero = 0;
				} else {
					$valores .= ", ";
				}
		
				$valores .= $key . " = '" . $value . "'";
				
			} else {
				if ($primero) {
					$primero = 0;
				} else {
					$campos .= ", ";
					$valores .= ", ";
				}
				
				$campos .= $key;
				$valores .= "'" . $value . "'";
			}
		}	
		
		if ($extra) {
			foreach($extra as $campo => $valor) {
				if ($id) {
					$valores .= ", $campo = '$valor'";
				} else {
					$campos .= ", $campo";
					$valores .= ", '$valor'";
				}
			}
		}

		
		if ($id) {
			if (!$where) {
				$where = $id_nombre . " = " . $id;
			}
			
			
			$q = "UPDATE $tabla 
					SET $valores 
					WHERE $where";
		} else {
			$q = "INSERT INTO $tabla ($campos)
					VALUES ($valores)";
		}
		
		return $q;
		
	}
	
	
	
	
	function comprobar() {
	
		$i = 0;
	
		$keys = array_keys($this->parametros);
		$i = current($keys);
		
		foreach ($this->parametros as $variable => $parametro) {
//			$var = $this->parametros[$i][0];
			if ($this->utf8) {
				$valor = iconv("UTF-8", "CP1252", trim($_REQUEST[$variable]));
			} else {
				$valor = trim($_REQUEST[$variable]);
			}

				// Primero comprobamos si el parámetro es obligatorio
			if ($parametro[1] == 1) {
				if (isset($valor) && ($valor <> "")) {
					$error = 0;
				} else {
					$error = 1;
					$this->error = 1;
					$this->errores[$variable] = 1;
				}
			} else {
				$error = 0; 
			}
			
			if (!$error) {
				
				if ($parametro[0] == "string") {
					if ($valor) {
						$this->valores[$variable] = $valor;
					} else {
						$this->valores[$variable] = "";
					}
					
					
				} else if ($parametro[0] == "int") {
					
					if (is_numeric($valor)) {
						$this->valores[$variable] = $valor;
					} else if (($valor == "")) {    
						$this->valores[$variable] = "";
					} else {
						$this->valores[$variable] = $valor;
						$this->error = 1;
						$this->errores[$variable] = 2;
					}
					
					
				} else if ($parametro[0] == "boolean") {
					
					if ($valor == "on") {
						$this->valores[$variable] = 1;
					} else if (($valor == 1) || ($valor == 'true')) {				
						$this->valores[$variable] = 1;
					} else if (($valor == 0) || ($valor == "")) {
						$this->valores[$variable] = 0;
					} else {
						$this->valores[$variable] = $valor;
						$this->error = 1;
						$this->errores[$variable] = 3;
					}
					
					
				} else if ($parametro[0] == "date") {
					if (fecha_valida($valor) || ($valor == "")) {
						if ($valor) {
							$this->valores[$variable] = $valor;
						} else {
							$this->valores[$variable] = "";
						}
					} else {
						$this->valores[$variable] = $valor;
						$this->error = 1;
						$this->errores[$variable] = 4;
					}
						
				
				} else if ($parametro[0] == "sexo") {
					if (($valor == 'H') || ($valor == 'M')) {
						$this->valores[$variable] = $valor;
					} else if ($valor == "") {
						$this->valores[$variable] = $valor;
					} else {
						$this->valores[$variable] = $valor;
						$this->error = 1;
						$$this->errores[$variable] = 5;
					}
						
				
				} else if ($parametro[0] == "tlf") {
					if (is_numeric($valor) || ($valor == "")) {
						if ($valor) {
							$this->valores[$variable] = $valor;
						} else {
							$this->valores[$variable] = "";
						}
					} else {
						$this->valores[$variable] = $valor;
						$this->error = 1;
						$this->valores[$variable] = 6;
					}
						
				} else {
					$this->error = 1;
					$this->errores[$variable] = 99;
				}
	
			}
			
		}
	
		return;
	
		
	
	}

	
	
}


?>