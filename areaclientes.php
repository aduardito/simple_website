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
		<script type="text/javascript" src="./javascript/jquery-1.7.1.js"></script>


		<title>Ushuari | LogIn</title>
		<link type="image/x-icon" href="./images/webhelp.ico" rel="shortcut icon"/>
	</head>
	<body onload(); >
		<?php include './menus/page_mobile.php';?>
			<div class="divide">
				<div class="user_login">
					<fieldset>
						<legend>Loggeate</legend>
							<form class="formulario" action="loggin.php" method="post">
								<label>Email</label><br />
								<input type="text" name="names" size="15" /><br />
								<label>Contrase&ntilde;a</label><br />
								<input type="password" name="passe" size="15" /><br />
								<input type="submit" class="boton" value="enviar">
							</form>
					</fieldset>
				</div>
				<div class="user_signin">
					<fieldset>
						<legend>Reg&iacute;strate</legend>
							<p class="link_registro"><a href="registro.php">Reg&iacute;strate</a></p>
						</fieldset>
				</div>
<?php
	//comprobamos si el email esta o no activado
	if(!empty($_GET)){
		$returndata = $_GET['data'];
		echo '<div id="errores_login">';
		echo '<h2>Errores</h2>';
		foreach ($returndata as $err) {
			echo '<p">'.$err.'</p>';
		}
		echo '</div>';
	}				
	echo'	</div>';//divide
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
			
	include 'headfoot/foot.php';
?>