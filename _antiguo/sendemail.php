<?php 
include('configuracionx.php');

$eleccion=$_GET['eleccion'];

$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$telefono=$_POST['telefono'];
$mail=$_POST['mail'];
$personas=$_POST['personas'];

//--Fecha de entrada
$dia_in=$_POST['dia_in'];
$mes_in=$_POST['mes_in'];
$ano_in=$_POST['ano_in'];

//--Fecha de salida
$dia_out=$_POST['dia_out'];
$mes_out=$_POST['mes_out'];
$ano_out=$_POST['ano_out'];

//--Otros datos
$habitaciones=$_POST['habitaciones'];
$llegada=$_POST['llegada'];
$camaextra=$_POST['camaextra'];
$mensaje=$_POST['mensaje'];

//---Tarjeta de credito
$tipocard=$_POST['tipocard'];
$diacard=$_POST['diacard'];
$mescard=$_POST['mescard'];
$otra=$_POST['otra'];
$titular=$_POST['titular'];
$numero=$_POST['numero'];

//envio de correo

if($eleccion==1){
$correoprincipal= $correoprincipal1;
}else{
$correoprincipal= $correoprincipal2;
}

$cabecera= "From: ".$mail."\r\n";
//$cabecera= "To: edgar@toolz.es\r\n";


$correo="www.almazaradevaldeverdeja.com\n\n";


if($eleccion==1){

$correo.="FORMULARIO DE RESERVAS";
$correo.= "\n";
$correo.= "\n";
$correo.= "Nombre: ".$nombre."\n";
$correo.= "telefono: ".$telefono."\n";
$correo.= "mail: ".$mail."\n";
$correo.= "nº de Personas: ".$personas."\n";
$correo.= "----------------------"."\n";
$correo.= "\n";
$correo.= " Fecha de entrada: ".$dia_in."-".$mes_in."-".$ano_in."\n";
$correo.= " Fecha de salida: ".$dia_out."-".$mes_out."-".$ano_out."\n";
$correo.= "\n";
$correo.= "habitaciones: ".$habitaciones."\n";
$correo.= "Llegada: ".$llegada."\n";
$correo.= "Cama Extra: ".$camaextra."\n";
$correo.= "----------------------"."\n";
$correo.=  $mensaje."\n";
$correo.= "----------------------"."\n";
$correo.= "Tipo de tarjeta:".$tipocard;
$correo.= "Fecha de caducidad: ".$diacard."-".$mescard."\n";
$correo.= "Otra: ".$otra."\n";
$correo.= "Titular: ".$titular."\n";
$correo.= "Numero: ".$numero."\n";
$correo.= "\n\n";
$correo.= "Powered by TOOLZ ";

}else{

//---------------------------------------------

$correo.="FORMULARIO DE INFORMACION";
$correo.= "\n";
$correo.= "\n";
$correo.= "Nombre: ".$nombre."\n";
$correo.= "telefono: ".$telefono."\n";
$correo.= "mail: ".$mail."\n";
$correo.= "nº de Personas: ".$personas."\n";
$correo.= "----------------------"."\n";
$correo.= " Fecha de entrada: ".$dia_in."-".$mes_in."-".$ano_in."\n";
$correo.= "\n";
$correo.= "----------------------"."\n";
$correo.=  $mensaje."\n";


}

//---------------------------------------------


if (mail($correoprincipal, "Reservas",$correo, $cabecera)) {
		echo "mail enviado";
	} else {
		echo "error en el envio";
	}
?>





