<?php
	require_once('./includes/include_classes.php');
	require_once('./includes/include_function.php');

$datacontent = array(
	'posted_form_data' => array(
		//data
        'name' => '',
        'apellido' => '',
        'email' => '',
        'telefono' => '',
        'password' => '',
    ),
	'form_ok' => false,
	'consejos' => array(),
	'errores' => array()
	);

//fill the tips to sign in
$datacontent['consejos'][] = 'Rellena todos los campos';
$datacontent['consejos'][] = 'La contrase&ntilde;a debe tener al menos 5 caracteres. Adem&aacute;s debe tener algun caracter especial, por temas de seguridad';

if(array_key_exists('nombre', $_POST)){
	$existe= true;
	$keys = array('nombre', 'apellido', 'email', 'contrasena', 'rcontrasena', 'telefono');
	foreach ($keys as $value) {
		if (!array_key_exists($value, $_POST)){
			$existe=false;
		}
	}

	if($existe){

		$datacontent['posted_form_data']['name'] = array_key_exists('nombre', $_POST) ? $_POST['nombre'] : '';
		$datacontent['posted_form_data']['apellido'] = array_key_exists('apellido', $_POST) ? $_POST['apellido'] : '';
		$datacontent['posted_form_data']['email'] = array_key_exists('email', $_POST) ? $_POST['email'] : '';
		$datacontent['posted_form_data']['password'] = array_key_exists('contrasena', $_POST) ? $_POST["contrasena"] : '';
		$pas1 = array_key_exists('rcontrasena', $_POST) ? $_POST["rcontrasena"] : '';

		$datacontent['posted_form_data']['telefono'] = array_key_exists('telefono', $_POST) ? $_POST["telefono"] : '';

		foreach ($datacontent['posted_form_data'] as $key => $value){
			if (empty($value)){
				$datacontent['errores'][] = 'Rellena el campo-> '.$key;
			}
		}
		if(count($datacontent['errores']) == 0){
			if(strcmp($datos['password'], $pas1) != 0 && $datos['password'] != '' && $pas1 != ''){
				$datacontent['errores'][] = 'La Contrase&ntilde;a no coincide';
				$datacontent['form_ok'] = false;
			}
			else{
				$cliente = new NewCliente();
				$returndata = $cliente->creandoCliente($datacontent['posted_form_data']);
				$datacontent['form_ok'] = $returndata['form_ok'];
				if($datos = $returndata['errores']){
					foreach ($returndata['errores'] as $err) {
						$datacontent['errores'][] = $err;
					}
				}			
			}
		}
	}

}


?>
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

		<title>Ushuari | Registro</title>
		<link type="image/x-icon" href="./images/webhelp.ico" rel="shortcut icon"/>
		<script type="text/javascript" src="javascript/compruebaregistro.js"></script>
	</head>
	<body>
		<div class="container_principal" >

<?php
			include './menus/mnu_pri.php';
			echo '<div class="divide" id="principalpal">';
if (!$datacontent['form_ok']){
	
	if (isset($datacontent['consejos'])){
		echo '<div class="divComentario">';
		foreach ($datacontent['consejos'] as $con) {
			echo '<p>'.$con.'</p>';
		}
		echo '</div>';
	}
	$datos = $datacontent['posted_form_data'];
	echo '<!-- class divComentario-->
	<form class="formulario_registro" method="post" action="registro.php">
		<h4>NUEVO USUARIO</h4>
		<label>Nombre</label>
		<input type="text" name="nombre" id="nomb" value="'.$datos['name'].'" size="15" maxlength="10" />
		<label>Apellido</label>
		<input type="text" name="apellido" value="'.$datos['apellido'].'" id="apel" size="15" maxlength="10" />
		<label>Email</label>
		<input type="text" name="email" id="emai" value="'.$datos['email'].'" size="15" maxlength="50" />
		<label>Telefono</label>
		<input type="text" id="tell" name="telefono" value="'.$datos['telefono'].'" size="15" maxlength="15"/>
		<label>Contrase&ntilde;a</label>
		<input type="password" name="contrasena" id="contrasenya1" value="" size="15" maxlength="8" onkeyup="return verifica1();" />
		<label>Repite Contrase&ntilde;a</label>
		<input type="password" name="rcontrasena" id="contrasenya2" value="" size="15" maxlength="8" onkeyup="return verifica2();" />
		<input type="submit" class="boton_registro" value="enviar" id="btnenvia"/>
		<input type="reset" class="boton_registro" value="limpiar"  />

	</form>';

	if(count($datacontent['errores']) > 0){
		echo '<div class="divErrores">';
		foreach ($datacontent['errores'] as $err) {
			echo '<p>'.$err.'</p>';
		}
		echo '</div>';
	}
	echo '<div style="clear: both;"></div>';

	
}
else{
	echo '<div class="registro_completado"><h1>Registro completado con &eacute;xito</h1>
	<h3>Verifica tu correo electronico para activar tu cuente. Tanto la Bandeja de entrada como correo electronico no desado</h3>
	<p><a href="areaclientes.php">Loggearse</a></p></div>';
}
echo '</div>'; // divide principalpal

include 'headfoot/foot.php';
?>