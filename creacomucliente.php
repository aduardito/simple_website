<?php session_start();
	if(empty($_SESSION)){
		header("Location: areaclientes.php");
		$_SESSION = array();
		session_destroy();
	}
	else{
		require_once('init.php');
		require_once('./includes/include_classes.php');
		global $conexion;
		echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Aportando mi granito">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Eduardo">
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Cliente | Comunicaciones</title>
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

		include './menus/page_mobile_regis.php'; //onclick="abrePopUp()
		echo '<div class="situaboton" style="clear:both;"><p class="botonGenera" ><a href="#">Crea Comunicacion</a></p></div>
		<div class="ocultando  creaconversacion"><form class="crea_con" action="" method="post">
<label>Titulo</label>
<input type="text" name="titulo" /><br/>
<label>Descripcion</label>
<select name="tipo">';
		if(!mysqli_connect_errno()){
			$sentencia = "SELECT tipo_con,nombre_con FROM tipoconsulta";
			$resultado = $conexion->query($sentencia);
				while($row = $resultado->fetch_assoc()){
					echo "<option value=".$row['tipo_con'].">".$row['nombre_con']."</option>";
				}	
		}
		else{echo 'error de conexion';}
		$resultado->close();
echo '
</select><br/>
<label>Descripcion</label>
<textarea name="descrip"></textarea><br/>
<input type="submit" id="envia_datos" value="enviar" />
';
		echo '</form></div>';
		echo '<div class="todas_comunicaciones"><hr />';
		//guardamos la comunicacion que acabamos de crear con javascript
		if(isset($_POST['descrip'])){
			$comunicacion = new NewCom($conexion);
			$creacom = $comunicacion->createNewCom($_SESSION['cliente'], $_POST['tipo'], $_POST['titulo'], $_POST['descrip']);
			if ($creacom){
				echo 'Comunicacion creada';
				$_POST = array();
			}

		}

		//guardamos el texto enviado por el cliente en la conversacion dicha
		if (isset($_POST['new_text'])){
			$comunicacion1 = new NewCom($conexion);
			$nuevotexto = $comunicacion1->guardamosTextoenlaConversacion($_POST);
			if ( $nuevotexto ){
				echo '<p class="texto_introducido">Texto Guardado</p>';
				unset($_POST['new_text']);
				unset($_POST['who']);
				unset($_POST['comu_no']);
			}
		}


		
		//buscando comunicaciones
		if($_SESSION['cliente']){
			$cliente = $_SESSION['cliente'];
			$sql = "SELECT * FROM comunicaciones WHERE id_clientes=".$cliente." ORDER BY fecha_crea DESC";
			$resultado = $conexion->query($sql);
			if ($resultado){
				while($row = $resultado->fetch_assoc()){
					$num = 0;
					echo '<div class="comunicacion_individual">';
					$num++;
					//buscamos el tipo de consulta que se lleva a cabo
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
							echo '<div class="comun_part"><form action="" method="post"><textarea class="writing_new_question" name="new_text"></textarea>'.
								'<input class="escribe_texto_conversacion" type="hidden" name="who" value="' . $cliente . 
								'" /><input type="hidden" name="comu_no" value="' . $row['comu_no'] . '" /><input type="submit" value="enviar"></form>';
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
											$esadmin = true;
										}
									}
									if ( $esadmin ){
										echo "<div class='admin_writing'><p class='conversation_name'>Admin => ".$row1['fecha']."</p><p>".$row1['texto']."</p></div>";
									}
									else{//escliente
										echo "<div  class='client_writing'><p class='conversation_name'>".$_SESSION['usuario']." => ".$row1['fecha']."</p><p >".$row1['texto']."</p></div>";
									}	
									$resultado2->close();							
								}
							}
							$resultado1->close();
						}
						
						echo '</div>'; //
						echo '</div>'; // coonversacion individual
						$resultado_tconsulta->close();
					}
				}
				$resultado->close();				
			}
		}
		$conexion->close();

		echo '</div>';//<div class="todas_comunicaciones">
					//u jquery para oculta conversaciones en el boton

echo "
	<script> 
		(function() { 
			$('div.todas_comunicaciones div.comunicacion_individual div.comun_part').addClass('ocultando'); 
		})(); 
	</script>  
	<script> 
		(function() { 
			$('div.todas_comunicaciones div.comunicacion_individual h3').bind('click', function() {
				if ($(this).siblings('div.comun_part').is(':visible')){     
					$(this)
						.siblings('div.comun_part')                                                    
							.slideUp(600) 
				}
				else{
					$(this)                                                                                      
						.siblings('div.comun_part')                                                              
							.slideDown(400)                                                                      
						.closest('div.comunicacion_individual')                                                  
							.siblings('div.comunicacion_individual')                                             
								.children('div.comun_part')                                                      
									.slideUp(600) 
				}                                                             
			});                                                                                             
		})();  
	</script>  
	<script >
	(function(){
		$('p.botonGenera').bind('click', function(){
			$('div.creaconversacion').toggle();
			if($('div.creaconversacion').is(':visible')){
				$('div.todas_comunicaciones').fadeOut();
			}
			else{
				$('div.todas_comunicaciones').fadeIn();
			}
			
		})
	})();
	</script>";

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
/*
<script>
	(function() {
		$('input#envia_conversacion').bind('click', function() {
			if ($('input.conver_des').val() == ""){ 
				return true;
			}
			else{
				return false;
			}
		});
	})();
</script>  ";
*/

		include './headfoot/foot.php';
	}
?>