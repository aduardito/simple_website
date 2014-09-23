<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Aportando mi granito">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Eduardo">
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!–[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]–>
		<link rel="stylesheet" type="text/css" href="css/retocando.css" />
		<link rel="stylesheet" type="text/css" href="css/retocando_respon.css" />

		<title>Ushuari | Contacto</title>
		<link type="image/x-icon" href="./images/webhelp.ico" rel="shortcut icon"/>
		<script type="text/javascript" src="./javascript/compruebacontacto.js"></script>
		<script type="text/javascript" src="./javascript/jquery-1.7.1.js"></script>
	</head>
	<body>
		<?php include './menus/page_mobile.php';?>

				<div class="divideCon">
					<h1>Contacto</h1>
<?php 
	$guarda = "";
	$dcor = true;
	require_once('init.php');
	$nom = "";
	$ema = "";
	$tel = "";
	$tip = "";
	$des = "Descripci&oacute;n del problema";
	if(!empty($_POST)){
		$nom = $_POST["cont_nom"];
		$ema = $_POST["cont_ema"];
		$tel = $_POST["cont_tel"];
		$tip = $_POST["cont_tipo"];
		$des = $_POST["cont_descrip"];
		if(!empty($nom) && !empty($ema) && !empty($tel)){
			if(!preg_match('/^[A-Z][a-z]+/', $nom)){
				$guarda = $guarda . '<p>Error en nombre pe. Eduardo</p>';$dcor = false;
			}
			if(!preg_match('/^[69][0-9]{8}$/', $tel)){
				$guarda = $guarda . '<p>Error en telefono pe. 949123456</p>';$dcor = false;
			}					
			if (!preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',
				$ema)) {
				$guarda = $guarda . '<p>Error en email pe. eduardo@eduardo.com</p>';$dcor = false;
			}
			if($dcor){
				global $conexion;
				if(mysqli_connect_errno()){
					$_SESSION = array();
					session_destroy();
					echo '<p>Error Conexion</p>';$dcor = false;
				}
				else{
					$fecha = date('Y-m-d H:i:s');

					$nom = $conexion->real_escape_string($nom);
					$ema = $conexion->real_escape_string($ema);
					$tel = $conexion->real_escape_string($tel);
					$tip = $conexion->real_escape_string($tip);
					$des = $conexion->real_escape_string($des);

					$sql = "INSERT INTO consulta(nombre,email,telefono,tipo_con,descripcion)
					VALUES('".$nom."','".$ema."','".$tel."','".$tip."','".$des."')";
					$resultado = $conexion->query($sql);
					$conexion->close();
					$_POST = array();
					$guarda = '<h3>Enviado correctamente</h3>';
				}
			}
		}
		else{
			$guarda = $guarda . '<p>Rellena todos los campos</p>';
			$dcor=false;
		}
	}
	else{
		$dcor=false;
	}
	if (!$dcor){
		echo '	<form method="post" action="contacto.php">
					<div class="instru_iz">
						<p>Si necesitas consultarme como funciona esta p&aacute;gina estar&eacute; encantado de comunicartelo</p>
					</div>
					<table class="tablacentro"><tbody>
						<tr><td>Nombre</td>
							<td><input type="text" name="cont_nom" size="50" maxlength="29" value="'.$nom.'"/></td></tr>
						<tr><td>Email</td>
							<td><input type="text" name="cont_ema" size="50" maxlength="49" value="'.$ema.'" /></td></tr>
						<tr><td>Tel&eacute;fono</td>
							<td><input type="text" name="cont_tel" size="50" maxlength="12" value="'.$tel.'" /></td></tr>
						<tr><td>Tipo de consulta</td>
							<td>
								<select class="page_contacto" name="cont_tipo" >
		';
		global $conexion;
		if(!mysqli_connect_errno()){
			$sentencia = "SELECT tipo_con,nombre_con FROM tipoconsulta";
			$resultado = $conexion->query($sentencia);
				while($row = $resultado->fetch_assoc()){
					echo "<option value=".$row['tipo_con'].">".$row['nombre_con']."</option>";
				}	
		}
		else{echo 'error de conexion';}
		$resultado->close();
		$conexion->close();
		echo '
									</select></td></tr>
							<tr><td>Descripci&oacute;n</td>
								<td><textarea onClick="describeClick()" id="descc" name="cont_descrip" rows="4" cols="38" maxlength="1024">'.$des.'</textarea>
								</td>
							</tr>
							
							<tr><td ></td>
								<td>
									<input class="boton_registro" type="submit" value="enviar" />
									<input class="boton_registro"type="reset" value="limpiar" />
								</td></tr></tbody>
						</table>
					</form>
		';
	}

	echo '</div><!--divideCon-->';
	echo "<div class='dudas'>".$guarda."</div>";
?>

<script> 
	(function() { 
		$('div.container_menu').addClass('ocultando');
	})(); 
</script>
<script>
	(function() {
		$('a#show_main_menu').bind('click', function() {
			console.log('estamos dentro');
			if ($('div.container_menu').is(':visible')){ 
				$('div.container_menu').slideUp(600);
			}
			else{
				$('div.container_menu').slideDown(600); 
			}
		});
	})();
</script> 

<?php
	include './headfoot/foot.php';
?>