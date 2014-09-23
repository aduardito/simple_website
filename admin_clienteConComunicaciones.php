<?php session_start(); 

	if(empty($_SESSION)){
		header("Location: areaclientes.php");
		$_SESSION = array();
		session_destroy();
	}
	else{
		if($_SESSION["rol"] == 1 && $_SESSION['cliente']){
			$usua = $_SESSION["usuario"];
			require_once('init.php');
			global $conexion;

			echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Aportando mi granito">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Eduardo">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Admin | Comunicaciones</title>
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
			echo '<div class="c_c_com">';
			//buscando comunicaciones
			$sql = "SELECT DISTINCT(id_clientes) FROM comunicaciones";
			$resultado = $conexion->query($sql);
			if ($resultado){
				$i = 0;
				while($row = $resultado->fetch_assoc()){
					$i++;
					$idc=$row['id_clientes'];
					echo '<form method="get" action="admin_com_de_cliente.php">';
					echo '<input type="hidden" name="client_idd" value="'.$idc.'" />';
					$sql1 = "SELECT nombre FROM clientes WHERE client_no=$idc";
					$resultado1 = $conexion->query($sql1);
					if ($resultado1){
						if ($row1 = $resultado1->fetch_assoc()){
							// buscamos el nombre del cliente
							if ($i%2 == 0){
								$class_bo= "boton_par_c_c_com";
							}
							else{
								$class_bo= "boton_impar_c_c_com";
							}
							echo '<input class="boton_cliente '.$class_bo.'" type="submit" value="' . $row1['nombre'] . '" /></form>';
						}	
						$resultado1->close();					
					}
					
					echo '</form>';
				}
					
			}
			$resultado->close();
			echo '</div>'./*div class="c_c_com*/"
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