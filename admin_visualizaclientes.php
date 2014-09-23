<?php session_start();
	if(empty($_SESSION)){
		header("Location: http://ushauri.hol.es/areaclientes.php");
		$_SESSION = array();
		session_destroy();
	}
	else{
		if($_SESSION["rol"] == 1){
			$usua = $_SESSION["usuario"];
			require_once('./init.php');
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Aportando mi granito">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Eduardo">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Admin | Visualiza Clientes</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="css/clienteregis.css" />
		<link rel="stylesheet" type="text/css" href="css/registro_respon.css" />
		<link type="image/x-icon" href="./images/cliente.ico" rel="shortcut icon"/>
		<script type="text/javascript" src="./javascript/comunicaciones.js"></script>
		
		<!–[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]–>
		<link type="image/x-icon" href="./images/admin.ico" rel="shortcut icon"/>
		<script type="text/javascript" src="./javascript/jquery-1.7.1.js"></script>
	</head>
	<body>';	
		include './menus/page_mobile_regis.php';
			
			global $conexion;
			
			if(mysqli_connect_errno()){
				$_SESSION = array();
				session_destroy();
			}
			else{
				$sentencia = "SELECT * FROM clientes;";
				$resultado = $conexion->query($sentencia);
				echo '<div class="contenedor_tabla_clientes">';
				if($resultado->num_rows > 0){//existe el usuario
					echo '<table><thead>';
					echo '<tr class="table_titles">';
						echo "<th>Nombre</th>";
						echo "<th>Apellidos</th>";
						echo "<th>Email</th>";
						echo "<th>Telefono</th>";
						echo "<th>Rol</th>";
						echo "<th>Activo</th>";
					echo '</tr></thead><tbody>';
					for($i=0;$i<$resultado->num_rows;$i++){
						$fila= $resultado->fetch_assoc();
						if( ($i%2) == 0 ){
							$class="tr_par";
						}
						else{
							$class="tr_impar";
						}
						echo '<tr class="tabla_clientes">';
						echo "<td class=$class>
							<p class='titulo_table_clientes_movil'>Nombre: <p/>
							<p class='data_table_clientes_movil'>".$fila["nombre"]."<p/>
						</td>";
						echo "<td class=$class>
							<p class='titulo_table_clientes_movil'>Apellidos: <p/>
							<p class='data_table_clientes_movil'>".$fila["apellidos"]."</td>";
						echo "<td class=$class>
							<p class='titulo_table_clientes_movil'>Email: <p/>
							<p class='data_table_clientes_movil'>".$fila["email"]."<p/></td>";
						echo "<td class=$class>
							<p class='titulo_table_clientes_movil'>Telefono: <p/>
							<p class='data_table_clientes_movil'>".$fila["telefono"]."<p/></td>";
						if ($fila["tipo_rol"] == 1){
							echo "<td class=$class ><p class='titulo_table_clientes_movil'>Tipo: <p/>
							<p class='data_table_clientes_movil'>Administrador<p/></td>";
						}
						else{
							echo "<td class=$class><p class='titulo_table_clientes_movil'>Tipo: <p/>
							<p class='data_table_clientes_movil'>Cliente<p/></td>";
						}
						$activo = "";
						if($fila["active"] == 1){
							$activo = "Si";
						}
						else{
							$activo = "No";
						}
						echo "<td class=$class>
							<p class='titulo_table_clientes_movil'>Activo: <p/>
							<p class='data_table_clientes_movil'>".$activo."<p/></td>";
						echo '</tr>';
					}
					echo "</tbody></table></div>
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
				}
				else{//no hay clientes
					echo '<p>No hay clientes</p></div>';
				}

				$resultado->close();
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
