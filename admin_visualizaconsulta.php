<?php session_start(); 
	require_once('./init.php');
	if(empty($_SESSION)){
		header("Location: areaclientes.php");
		$_SESSION = array();
		session_destroy();
	}
	else{
		if($_SESSION["rol"] == 1){
			$usua = $_SESSION["usuario"];
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Aportando mi granito">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Eduardo">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Admin | Visualiza consultad</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/clienteregis.css" />
		<link rel="stylesheet" type="text/css" href="css/registro_respon.css" />
		<link type="image/x-icon" href="./images/cliente.ico" rel="shortcut icon"/>
		<script type="text/javascript" src="./javascript/comunicaciones.js"></script>
		
		<!–[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]–>
		<link type="image/x-icon" href="./images/cliente.ico" rel="shortcut icon"/>
		<script type="text/javascript" src="./javascript/jquery-1.7.1.js"></script>
	</head>
	<body>';
		include './menus/page_mobile_regis.php';


			global $conexion; 
			
			if(mysqli_connect_errno()){
				$_SESSION = array();
				session_destroy();
				echo '<p>Intentelo de nuevo</p></div>';
			}
			else{
				
				$sentencia = "SELECT nombre, email, telefono, tipo_con, descripcion, fecha FROM consulta order by fecha desc;";
				$resultado = $conexion->query($sentencia);
				
				echo '<div class="contenedor_tabla_clientes">';
				if(empty($resultado)){
					echo"no hay resultados";
				}
				else{
					if($resultado->num_rows > 0){//existe el usuario
						for($i=0;$i<$resultado->num_rows;$i++){
							$fila= $resultado->fetch_assoc();
							echo '<div class="consulta1">';
							echo "<p>Nombre: ".$fila["nombre"]."</p>";
							echo "<p>Email: ".$fila["email"]."</p>";
							echo "<p>Telefono: ".$fila["telefono"]."</p>";
							$sentencia = "SELECT nombre_con FROM tipoconsulta where tipo_con=".$fila["tipo_con"].";";
							$resultado1 = $conexion->query($sentencia);
							$fila1 = $resultado1->fetch_assoc();
							$resultado1->close();
							echo "<p>Tipo de consulta: ".$fila1["nombre_con"]."</p>";
							echo "<p>Descripcion consulta: ".$fila["descripcion"]."</p>";
							echo '</div><br /><br />';
						}
						$resultado->close();
					}
					else{/*no hay clientes*/echo '<p>No hay consultas</p>';}
				}
				echo '</div>'."
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
</script> ";
			}
			$conexion->close();
			include './headfoot/foot.php';
		}
		else{
			$_SESSION = array();
			session_destroy();
			header ("Location: areaclientes.html");
		}
	}
?>	