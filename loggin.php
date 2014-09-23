<?php session_start();
	if(empty($_POST)){
		header("Location: areaclientes.php");
		$_SESSION = array();
		session_destroy();
	}
	else{
		if(array_key_exists('names', $_POST) && array_key_exists('passe', $_POST)){

			require_once('./includes/include_classes.php');

			$datacontent = array(
		        'email' => $_POST["names"],
		        'password' => sha1($_POST["passe"]),
			);
			// check if the client exists
			$cliente = new NewCliente();
			$returndata = $cliente->logueandose($datacontent);
			if($returndata['form_ok'] == true){//existe el usuario
				$_SESSION["usuario"] = $datacontent['email'];
				$_SESSION["cliente"] = $returndata['data']['num_client'];
				$_SESSION["rol"] = $returndata['data']['rol_client'];
				$_SESSION["time"] = time();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Aportando mi granito">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Eduardo">
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		<title>Loggeado</title>
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

<?php include './menus/page_mobile_regis.php'; ?>

		<div class="bienvenido">
			<h1>Bienvenido <?php echo $_SESSION["usuario"]; ?></h1>
			<h5>Sessi&oacute;n iniciada</h5>
			<h3>Escoge una de las opciones del men&uacute;</h3>
			</div>

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
				include 'headfoot/foot.php';
				}
				else{
					unset($datacontent);
					$_SESSION = array();
					session_destroy();
					$_GET['data'] = $returndata['errores'];
					include 'areaclientes.php';
				}
		}
		else{
			$_SESSION = array();
			session_destroy();
			include 'areaclientes.php';
		}
	}
?>	