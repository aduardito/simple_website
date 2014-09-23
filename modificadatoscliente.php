<?php session_start(); 
	require_once('./init.php');
	if(empty($_SESSION)){
		header("Location: areaclientes.php");
		$_SESSION = array();
		session_destroy();
	}
	else{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Aportando mi granito">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Eduardo">
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<title>Cliente | Modificando Usuario</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/clienteregis.css" />
		<link rel="stylesheet" type="text/css" href="css/registro_respon.css" />
		<link type="image/x-icon" href="./images/cliente.ico" rel="shortcut icon"/>
		
		<!–[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]–>
		<link type="image/x-icon" href="./images/webhelp.ico" rel="shortcut icon"/>
		<script type="text/javascript" src="./javascript/jquery-1.7.1.js"></script>

	</head>
	<body>	
<?php
		include './menus/page_mobile_regis.php';
		//@ $conexion = new mysqli('localhost','eduardo','123456','paginaweb');
		global $conexion;
		
		if(mysqli_connect_errno()){
			$_SESSION = array();
			session_destroy();
			include("areaclientes.php");
		}
		else{
			$sentencia = "SELECT * FROM clientes WHERE client_no=".$_SESSION['cliente'].";";
			$resultado = $conexion->query($sentencia);
			if($resultado->num_rows > 0){//existe el usuario
				$row = $resultado->fetch_assoc();
				$modificado = false;

				//comprobamos si se han mandado datos 
				if (isset($_POST['telefono'])){
					//si las contrasnas son iguales
					if ($_POST['contrasena'] == $_POST['rcontrasena'] && $_POST['contrasena'] != ""){
						$n = $_POST['nombre'];
						$a = $_POST['apellido'];
						$t = $_POST['telefono'];
						$co = sha1($_POST['contrasena']);
						$c = $_SESSION['cliente'];
						$sentencia = "UPDATE clientes SET nombre='".$n."', apellidos='".
						$a."', telefono='".$t."', contrasena='".
						$co."' WHERE client_no=".$c.";";
						$conexion->query($sentencia);
						$modificado = true;
					}
				}
				if (!$modificado){
					echo '<div class="fRegistro">

						<form class="formulario_registro" method="post" action="registro.php">
							<h4>MODIFICANDO DATOS USUARIO</h4>
							<label>Nombre</label><br />
							<input type="text" name="nombre" id="nomb" value="'.$row["nombre"].'" size="15" maxlength="10" /><br />
							<label>Apellido</label><br />
							<input type="text" name="apellido" value="'.$row["apellidos"].'" id="apel" size="15" maxlength="10" /><br />
							<label>Email</label><br />
							<input type="text" name="email" id="emai" readonly="readonly" value="'.$row["email"].'" size="15" maxlength="50" /><br />
							<label>Contrase&ntilde;a</label><br />
							<input type="password" name="contrasena" required id="contrasenya1" value="" size="15" maxlength="8" onkeyup="return verifica1();" /><br />
							<label>Repite Contrase&ntilde;a</label><br />
							<input type="password" name="rcontrasena" required id="contrasenya2" value="" size="15" maxlength="8" onkeyup="return verifica2();" /><br />
							<label>Telefono</label><br />
							<input type="text" id="tell" name="telefono" value="'.$row["telefono"].'" size="15" maxlength="15"/><br />
							<input type="submit" class="boton_registro" value="enviar" id="btnenvia"/>
							<input type="reset" class="boton_registro" value="limpiar"  /><br />

						</form>
					</div>
					';
				}
				else{
					echo '<h1 style="margin-top:180px;text-align:center">datos modificados con exito</h1>';
				}
				
			}

		}
	};
echo"
<script> 
	(function() { 
		console.log($(window).width());
		if ($(window).width() < 480){
			
			$('div.container_menu').addClass('ocultando');
		}
	})(); 
</script>
<script>
	(function() {
		$('a.show_main_menu').bind('click', function() {
			if ($('div.container_menu').is(':visible')){ 
				$('div.container_menu').slideUp(600);
			}
			else{
				$('div.container_menu').slideDown(600); 
			}
		});
	})();
</script>  
";
	include 'headfoot/foot.php';
?>
