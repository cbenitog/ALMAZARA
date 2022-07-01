<?php 


//http://www.toolz.es/almazara/almazara2/ofertas.php?tabla=2&id=1

include('configuracionx.php');


$selectortabla=$_GET['tabla'];

$id=$_GET['id'];




//---conexión
$conn = mysql_connect($dbserver,$dbuser,$dbpassword);

mysql_select_db($dbname,$conn);


//--seleccion de provincia
switch ($selectortabla) {
    case 1:
		  $tablaDB=$tablename1;
        break;
    case 2:
		  $tablaDB=$tablename2;
        break;
	case 3:
		  $tablaDB=$tablename3;
        break;

}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Ofertas</title></head>
<STYLE type=text/css>
<!--
body {
	background-image: url();
	background-color: #000;
}
.Bold {
	font-family: Arial;
	font-weight: bold;
	font-size: 16px;
	color: #FFF;
}
.Normal {
	font-family: Arial;
	font-weight: normal;
	font-size: 12px;
	color: #FFF;
}
.NormalBOLD {
	font-family: Arial;
	font-weight: bold;
	font-size: 12px;
	color: #FFF;
}
-->
</STYLE>

<?php 

$ssql = "SELECT * FROM $tablaDB WHERE id=$id";


			 $rs = mysql_query($ssql,$conn);

             $datas= mysql_num_rows($rs); 

             if ($datas> 0) {

             while ($rowEmp = mysql_fetch_assoc($rs)) {
				 
				 $imagen=$rowEmp['imagen_file'];
				 
				 $texto=$rowEmp['Texto_txtbox'];

				 $texto=str_replace('\\','',$texto);
				 
				 
				 
				 
				 echo ("ruta de imagen:"+$imagen);
				 echo ("");
                 echo ("ruta texto:"+$texto);
				 
				 
			 }
			 
							 }
							 
						 
//--------------------------1
$ssql2 = "SELECT
pe_uploads.`file`,
Ofertasx.id
FROM
Ofertasx
Inner Join pe_uploads ON Ofertasx.imagen_file = pe_uploads.id WHERE Ofertasx.id=$id

";
$rs2 = mysql_query($ssql2,$conn);
$datas2= mysql_num_rows($rs2); 
if ($datas2> 0) {while ($rowEmp2 = mysql_fetch_assoc($rs2)) {
	$imagenxx=$rowEmp2['file'];
}}							 

?>

<TABLE height="80%" cellSpacing=0 cellPadding=0 width=440 align=center border=0>
<TBODY>
<TR>
<TD vAlign=top height=120><IMG height=120 alt="Almazara de Valdeverdeja - Carta Restaurante" src="<?php echo $imgruta.$imagenxx;?>" width=440></TD></TR>
<TR>
<TD vAlign=top>
<TABLE cellSpacing=0 cellPadding=0 width="96%" align=center border=0>
<TBODY>
<TR>
<TD class=Bold>
<P class=Normal><?php echo  $texto;?></P></TD></TR></TBODY></TABLE></TD></TR>
<TR>
<TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>