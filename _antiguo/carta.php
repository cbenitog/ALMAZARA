<?php 

include('configuracionx.php');


$selectortabla=$_GET['tabla'];




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
<title>Carta</title></head>
<STYLE type=text/css>
<!--
body {
	background-image: url();
	background-color: #000;
}
.Bold {
	font-family: Arial;
	font-size: 16px;
	color: #FFF;
}
.Normal {
	font-family: Arial;
	font-weight: normal;
	font-size: 12px;
	color: #FFF;
}
-->
</STYLE>

<?php 

$ssql = "SELECT * FROM $tablaDB";


			 $rs = mysql_query($ssql,$conn);

             $datas= mysql_num_rows($rs); 

             if ($datas> 0) {

             while ($rowEmp = mysql_fetch_assoc($rs)) {
				 
				 $imagen=$rowEmp['imagen_file'];
				 
				 $texto=$rowEmp['menu_txtbox'];

				 $texto=str_replace('\\','',$texto);
				 
				 
				 
				 
				 echo ("ruta de imagen:"+$imagen);
				 echo ("");
                 echo ("ruta texto:"+$texto);
				 
				 
			 }
			 
							 }
							 
						 
//--------------------------1
$ssql2 = "SELECT
pe_uploads.`file`
FROM
cartax
Inner Join pe_uploads ON cartax.imagen_file = pe_uploads.id
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
<TD vAlign=top height=120><IMG height=120 alt="Almazara de Valdeverdeja - Carta Restaurante" src="<?php echo $imgruta.$imagenxx;?>" width=440></TD>
</TR>
<TR>
<TD vAlign=top>
<TABLE cellSpacing=0 cellPadding=0 width="100%"  border=0>
<TBODY>
<TR>
<TD class=Bold>

<P><?php echo $texto;?></P></TD></TR></TBODY></TABLE></TD></TR>
<TR>
<TD vAlign=top>&nbsp;</TD></TR></TBODY></TABLE>