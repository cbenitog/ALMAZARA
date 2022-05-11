<?php


class usuario {

	public $id_usuario;
	public $datos;
	
	public $error;
	public $error_texto;
	
	
	
	
	
	
	

	function __construct() {

		$cookie_sesion = $_COOKIE["almazara_sesion"];
		$cookie_hash = $_COOKIE["almazara_hash"];
		
		if ($cookie_sesion) {
			
			$q = "SELECT id_usuario, hash 
					FROM sesion 
						WHERE id_sesion = $cookie_sesion 
							AND hash = '$cookie_hash'";
			$r = mysql_query($q);
	    	if (mysql_num_rows($r)) {
	    		$fila = mysql_fetch_array($r);
	    		if ($fila["hash"] == $cookie_hash) {
	    			if ($fila["id_usuario"]) {
		    			$this->id_usuario = $fila["id_usuario"];
	    				$this->recuperar();
		    		}
	    		}
	    	} else {
	    		$this->id_usuario = 0;
	    	};			
			
	    	return;
	    	
		 } 
		 
		$this->id_usuario = 0;
		$this->datos = "";
		
}





			
	
	
	



	function editar() {

		if ($_REQUEST["id_usuario"]) {
			if (is_numeric($_REQUEST["id_usuario"])) {
				$this->id_usuario = $_REQUEST["id_usuario"];
				$this->recuperar();
			} else {
				return acceso_restringido();
			}
		} else {
			$this->id_usuario = 0;
			$this->datos = ""; 
		}
		
		if ($_REQUEST["grabar"]) {
			
			include_once("post.php");
			$post = new post();
			$post->utf8 = 1;
			
			$post->parametros = array(
					'nombre' => array	('string',0,'Nombre'), 
					'activo' => array	('int',0,'Activo'), 
			 		'email' => array	('string',0,'Email')
			);
			
			$post->comprobar();

			if ($_REQUEST["password"]) {
				if ($_REQUEST["password"] == $_REQUEST["password2"]) {
					$password = md5($_REQUEST["password"]);
					
				} else {
					$post->error = 1;
					$post->errores["password"] = 1;
				}
			}
			
			
			
			if ($post->error) {
				
				$o .= error("ERROR: ");
				
				$primero = 1;
				foreach($post->errores as $key => $value) {
					if ($primero) {
						$primero = 0;
					} else {
						$error .= ", ";
					}
					$error .= $key;
				}
				$o .= error($error);
				
				if ($post->valores) {
					foreach ($post->valores as $key => $value) {
						$this->datos[$key] = $value;
					}
				}
				
			} else {
				
				$post->valores["nivel"] = 1;
				
			
				$q = $post->consulta($this->id_usuario,'usuario','', $extra, 'id_usuario');
				mysql_query($q);
				
				if ($password) {
					$q = "UPDATE usuario SET password = '$password' WHERE id_usuario = $this->id_usuario";
					mysql_query($q);
				}
				
				if (!$this->id_usuario) {
					$this->id_usuario = mysql_insert_id();
					
					$this->recuperar();
					loggear("usuario - alta - $this->id_usuario - " . $this->datos["titulo"]);
				} else {
					loggear("usuario - edición - $this->id_usuario - " . $this->datos["titulo"]);
				}
				
				$o .= "Usuario grabado correctamente.";
				
				return $o;
			}	
		}
		
		
		if ($this->datos["activo"]) {
			$activo = "checked";
		} else {
			$activo = "";
		}
		
		
		$o .= "
			<input type='button' value='Grabar' onclick=\"formulario(['usuario', 'editar&id_usuario=$this->id_usuario&grabar=1', 'form_usuario', 'bloque2_trabajo', 0, 1]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			<div style='clear:both;'></div>
			<form id='form_usuario' onsubmit=\"formulario(['usuario', 'editar&id_usuario=$this->id_usuario&grabar=1', 'form_usuario', 'bloque2_trabajo', 0, 1]);return false;\">

			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; '>
			 	<strong>Nombre:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<input type='text' class='todo' id='nombre' name='nombre' value='" . texto_form($this->datos["nombre"]) . "'/>
			 </div>
			 <div style='clear: both;'></div>
			</div>

			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; '>
			 	<strong>Email:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<input type='text' class='todo' id='email' name='email' value='" . texto_form($this->datos["email"]) . "'/>
			 </div>
			 <div style='clear: both;'></div>
			</div>
						
			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; '>
			 	<strong>Activo:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<input type='checkbox' id='revisado' name='activo' value='1' $activo/>
			 </div>
			 <div style='clear: both;'></div>
			</div>
			
			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; '>
			 	<strong>Contraseña:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<input type='password' class='todo' id='password' name='password' value=''/>
			 </div>
			 <div style='clear: both;'></div>
			</div>			

			<div class='tabla_tr'>
			 <div class='tabla_td' style='width: 23%; text-align: right; '>
			 	<strong>Confirmaci&oacute;n de contraseña:</strong>
			 </div>
			 <div class='tabla_td' style='width: 73%;'>
				<input type='password' class='todo' id='password2' name='password2' value=''/>
			 </div>
			 <div style='clear: both;'></div>
			</div>			
			
			</form>
			<input type='button' value='GRABAR' onclick=\"formulario(['usuario', 'editar&id_usuario=$this->id_usuario&grabar=1', 'form_usuario', 'bloque2_trabajo', 0, 1]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
			<div style='clear:both;'></div>
			";
		
		
		
		return $o;
	}
	
	
	
	
	
	
	
	
	


	
	function id_usuario() {

		$cookie_sesion = $_COOKIE["almazara_sesion"];
		$cookie_hash = $_COOKIE["almazara_hash"];
		
		if ($cookie_sesion) {
	
		    $cadena = "SELECT * FROM sesion WHERE id_sesion = " . $cookie_sesion;
		    $resultado = mysql_query($cadena);
		    
		    if (mysql_errno())	return;
		
		    if (mysql_num_rows($resultado) == 0 ) {
		    	return;
		    };
		
		    $fila_indice = mysql_fetch_array($resultado);
		    
		    	// tenemos que comprobar si el hash es el mismo
		    if ($fila_indice["hash"] == $cookie_hash) {
		        $this->id_usuario = $fila_indice["id_usuario"];
		        
		        if ($this->id_usuario) {
		        	$this->recuperar();
		        }
		    } else {
		    			// si no lo es resolvemos que no puede acceder
		    	return;
		    }
		}
	}
	
	
	
	
	
	
	function login_usuario($retorno) {

		$usuario = trim($_REQUEST["usuario"]);
		$password = $_REQUEST["password"];
			
	    if ($_COOKIE["almazara_sesion"] <> "") {
	    	$this->error = 1;
	    	$this->error_texto = "Existe una sesión previa. Por favor, haz <a href='logout.php?'>logout</a> primero.";
	    	return;
		}
	
		$fecha =  fecha_hoy() . " " . hora_ahora();
	
		$bien = 1;
	    
		if (!$usuario) {
			$this->error = 2;
			$this->error_texto = "No has indicado usuario.";
	        return;
		}
	
		if ($bien) {

			$cadena = "SELECT id_usuario, password, activo
	        			FROM usuario
	        			WHERE nombre = '" . $usuario . "'";
	
	        $resultado = mysql_query ($cadena);
	        
	        
	        if (mysql_errno()) {
	        	$this->error = 3;
	        	$this->error_texto = "Error en la búsqueda de usuarios.";
	        	return;
	        }
	
	//  Si existe el usuario comprobamos el password
	        if (mysql_num_rows($resultado)) {
	            $fila_indice = mysql_fetch_array($resultado);
	
	            $id_usuario = $fila_indice[0];
	            $pass2 = $fila_indice[1];

	            if (!$fila_indice[2]) {
	            	$this->error = 5;
		            $this->error_texto = "El usuario no está activado.";
		            return;
	            }
	            
	            
	            if ($pass2) {
	            	$password = md5($password);
	            
		            if (strcmp($password,$pass2) == 0) {
		                                                // Se ha reconocido el password de forma que creamos la sesión en la tabla
		                                                // y la cookie con los datos de la sesión
		                                                        // la comparación de password no ha sido válida
		             } else {
		             	$this->error = 5;
		             	$this->error_texto = "La contraseña no es correcta.";
		             	return;
		             }
	            }

	            $hash = md5(time() * rand());
	            
	            $q = "DELETE FROM sesion WHERE id_usuario = $id_usuario AND fecha < '" . fecha_hoy() . "'";
	            $r = mysql_query($q);
	            
                $cadena = "INSERT INTO sesion 
                				(id_usuario, hash, fecha) 
                				VALUES ($id_usuario, '$hash', '$fecha')";
                $resultado = mysql_query ($cadena);
                if (mysql_errno()) {
                	$this->error = 6;
                	$this->error_texto = "Error en la creación de la sesión $cadena";
                	return;
                }
                                        //          tenemos que recuperar el número de la sesión
                $id_sesion = mysql_insert_id();
                
                $q = "UPDATE usuario
                		SET ultimo_login = '$fecha' 
                		WHERE id_usuario= $id_usuario ";
                mysql_query($q);


                $GLOBALS["usuario"] = new usuario();
                $GLOBALS["usuario"]->id_usuario = $id_usuario;
                
                $_REQUEST["modulo"] = $_REQUEST["modulo2"];
                $_REQUEST["funcion"] = $_REQUEST["funcion2"];
                
				$salida .= "<b>Entrando en el backoffice de La Almazara...</b>
					<script language='JavaScript'>
						document.cookie = 'almazara_sesion=$id_sesion;';
                        document.cookie = 'almazara_hash=$hash;';
                        location.href = 'index.php?';
                    </script>    
					";
				
	        } else {
	        	$this->error = 4;
	        	$this->error_texto = "El usuario no se encuentra en nuestra base de datos. <br/>";
	        	return;
	        }
	
	    } 
	
		  return $salida;
	}
	
	
	
	
	
	
	
	
	
	

	function logout() {
    	echo '<script LANGUAGE="JavaScript">
                    document.cookie = "almazara_sesion=";
                    document.cookie = "almazara_hash=";
               </script>';

		echo '<head>
	            <meta http-equiv="refresh" content="3;URL=index.php?">
		       </head>
			  <body>	
		  		<center>Saliendo del backoffice de La Almazara...</center>
			  </body>
		';
	}



	
	
	function recuperar() {
		if ($this->id_usuario) {
			$q = "SELECT * FROM usuario WHERE id_usuario = $this->id_usuario";
			$r = mysql_query($q);
			
			if (mysql_num_rows($r)){
				$this->datos = mysql_fetch_assoc($r);
			}
		}
		
	}		
	
	
	
	
	
	
	
	
	function tabla() {

		if (!$GLOBALS["usuario"]->id_usuario) {
			return acceso_restringido();
		}
		
		$num_filas = 20;
		if ($_REQUEST["hoja"]) {
			$puntero = $num_filas * $puntero;
		} else {
			$puntero = 0;
		}
		
		

		
		
		$fecha = fecha_hoy();
		
		$q = "SELECT * 
				FROM usuario 
				ORDER BY id_usuario
				LIMIT $puntero, $num_filas";
		$r = mysql_query($q);
		
		if (mysql_num_rows($r)) {
			$i = 0;
			
			$o .= "
				<input type='hidden' id='hoja' value='" . $_REQUEST["hoja"] . "'/>
				<input type='button' value='NUEVO' onclick=\"modulo(['usuario', 'editar', '', 'bloque2_trabajo', 0, 0]);\" style='float: right; margin: 5px 2px 5px 2px;'/>
				
				<div class='tabla_cabecera'>	
				<div class='tabla_th' style='width: 65%;'>
					USUARIO
				</div>
				<div class='tabla_th' style='width: 15%;'>
					ACTIVO
				</div>
				<div class='tabla_th' style='width: 20%;'>
					&nbsp; 
				</div>
				<div style='clear:both;'></div>
				</div>
			";
			
			while ($fila = mysql_fetch_array($r)) {
				if (($i % 2) == 0) {
					$clase = "tabla_par";
				} else {
					$clase = "tabla_impar";
				}
				
				$this->id_usuario = $fila[0];
				$this->recuperar();
				$o .= "<div class='tabla_tr $clase'>" . $this->tabla_fila() . "</div>";
				$i += 1;
			}
			
		} else {
			$o .= error("No hay usuarios");
		}

		
		
		return $o;
		
	}
	
	
	
	
	
	

	
	
	function tabla_fila() {
		
		if ($this->datos["activo"]) {
			$activo = "S&Iacute;";
		} else {
			$activo = "NO";
		}
		
		$o .= "
			<div class='tabla_td' style='width: 63%;'>
				<span class='a' onclick=\"modulo(['usuario', 'editar', '&id_usuario=$this->id_usuario', 'bloque2_trabajo', 0, 0]);\">" . $this->datos["nombre"] . "</span>
			</div>
			<div class='tabla_td' style='width: 13%; text-align: center;'>
				$activo
			</div>
			<div class='tabla_td' style='width: 18%; text-align: right;'>
				<span class='a' onclick=\"confirmacion(['Borrar usuario: " . $this->datos["nombre"] . "', 'usuario', 'borrar', '&id_usuario=$this->id_usuario', 'bloque2_trabajo', 0,1]);\">borrar</span>
			</div>
			<div style='clear:both;'></div>
		";
		
		return $o;
		
	}
	
	
	
	
	
	
	
	
	
}








function usuario_permiso($campo) {

    $cookie_sesion = $_REQUEST["hwings_sesion"];

	if ($cookie_sesion) {

// 1. Comprobación de usuario recuperándolo a partir de la sesión

    $cadena = "SELECT * FROM sesion WHERE id_sesion = " . $cookie_sesion;
    $resultado = mysql_query($cadena);
    if (mysql_errno())	mysql_error();

    if (mysql_num_rows($resultado) == 0 ) {
    	admin_login();
    	return 0;
    };

    $fila_indice = mysql_fetch_array($resultado);

    $id_usuario = $fila_indice[1];

    if ($id_usuario) {

        if (strcmp($fila_indice[2],$_REQUEST["newline_admin_hash"]) == 0) {

                                                // recuperamos el usuario y su nivel
            $cadena = "SELECT $campo FROM usuario WHERE id_usuario = $id_usuario";
            $resultado = mysql_query($cadena);
            if (mysql_errno()) {
            	echo mysql_error();
            	return 0;
            }
            return mysql_result($resultado,0,0);


        } else {
            return 0;
        };

      } else {
          return 0;
      }
	
	} else {
		admin_login();
        return 0;
	}
	
	
	
	
	
	
	


	
	

}










?>
