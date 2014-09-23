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
			require_once('./includes/include_classes.php');
			global $conexion;
?>
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
	<body>
<?php
	include './menus/page_mobile_regis.php';

			echo '<div class="enlace_back">
				<a href="admin_clienteConComunicaciones.php">&lt;&lt;  Back to || Ver Clientes con Comunicaciones
				</a></div>';
			echo '<div class="conversaciones_cliente">';

			if(isset($_POST['who'])){
				$comunicacion1 = new NewCom($conexion);
				$nuevotexto = $comunicacion1->guardamosTextoenlaConversacion($_POST);
				if ( $nuevotexto ){
					echo '<p class="texto_introducido">Texto Guardado</p>';
					unset($_POST['new_text']);
					unset($_POST['who']);
					unset($_POST['comu_no']);
				}
			}
			if(isset($_GET['client_idd'])){
				$idc = $_GET['client_idd'];
				$idadmin = $_SESSION['cliente'];
				$sql = "SELECT * FROM comunicaciones WHERE id_clientes=".$idc." ORDER BY fecha_crea";
				$resultado = $conexion->query($sql);
				if ($resultado){
					while($row = $resultado->fetch_assoc()){
						$num = 0;
						echo '<div class="comunicacion_individual">';
						$num++;
						$tip = $row['tipo_con'];
						$sql_tconsulta = "SELECT nombre_con FROM tipoconsulta WHERE tipo_con=".$tip.";";
						$resultado_tconsulta = $conexion->query($sql_tconsulta);
						if ($resultado_tconsulta){
							$nombr_con = "";
							if($row_tipocon = $resultado_tconsulta->fetch_assoc()){
								$nombr_con = $row_tipocon['nombre_con'];
							}
							else{
								$nombr_con = "error";
							}
							echo '<h3><a href="#">Titulo-&gt;<strong>' . ucfirst($row['titulo']) . '.</strong> || tipo consulta-&gt;<strong>'. ucfirst(mb_strtolower($nombr_con)) .'</strong></a></h3>';
							if ($num <= 1){
								//creamos un formulario con un cuadro de texto donde escribira el administrador
								//ademas un campo oculto con el id del administrador que escribe.
								//otro campo oculto con el numero de comunicacion
								echo '<div class="comun_part"><form action="#" method="post"><textarea class="writing_new_question" 
									name="new_text"></textarea>
									<input class="escribe_texto_conversacion" type="hidden" name="who" value="' . $idadmin . 
									'" /><input type="hidden" name="comu_no" value="' . $row['comu_no'] . '" />
									<input type="submit" value="enviar"></form>';
							}
							$com_id = $row['comu_no'];
							//buscamos todas las conversaciones que se han tenido en la misma comunicacion
							$sql1 = "SELECT * FROM seguimiento WHERE comu_no=$com_id ORDER BY fecha DESC";
							$resultado1 = $conexion->query($sql1);
							if($resultado1){
								while($row1 = $resultado1->fetch_assoc()){
									$client_idd = $row1['who'];
									$sql2 = "SELECT tipo_rol, nombre FROM clientes WHERE client_no=$client_idd";
									$resultado2 = $conexion->query($sql2);
									if ($resultado2){
										$esadmin = false;
										if ($row2 = $resultado2->fetch_assoc()){
											//comprobamos si es o no administrador para darle otro estilo a la conversacion
											if ($row2['tipo_rol'] == 1){
												echo "<div class='admin_writing'><p class='conversation_name'>Admin => ".$row1['fecha']."</p><p>".$row1['texto']."</p></div>";
											}
											else{
												echo "<div  class='client_writing'><p class='conversation_name'>".$row2['nombre']." => ".$row1['fecha']."</p><p >".$row1['texto']."</p></div>";
											}
										}	
										$resultado2->close();							
									}
									echo '<div style="clear:both;"></div>';

								}
								$resultado1->close();
							}
							
							echo '</div>'; //comun_part
							echo '</div>'; // comunicacion_individual
							$resultado_tconsulta->close();
						}
					}
					$resultado->close();	
				}
			}
			echo '</div>';//fin '<div class="conversaciones_cliente">';
?>
<script>                                                                                                
	(function() {                                                                                        
		$('div.conversaciones_cliente div.comunicacion_individual div.comun_part').addClass('ocultando');  
	})();                                                                                                
</script>                                                                                                                                                                                             
<script>                                                                                                
	(function() {                                                                                        
		$('div.conversaciones_cliente div.comunicacion_individual h3').bind('click', function() {      
			if ($(this).siblings('div.comun_part').is(':visible')){     
				$(this)
					.siblings('div.comun_part')                                                    
						.slideUp(500) 
			}
			else{
				$(this)                                                                                      
					.siblings('div.comun_part')                                                              
						.slideDown(500)                                                                      
					.closest('div.comunicacion_individual')                                                  
						.siblings('div.comunicacion_individual')                                             
							.children('div.comun_part')                                                      
								.slideUp(500) 
			}   
			                                                               
		});                                                                                              
	})();                                                                                                
</script>  
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

<?php

			include './headfoot/foot.php';
		}
		else{
			$_SESSION = array();
			session_destroy();
			header ("Location: areaclientes.html");
		}
	}
?>