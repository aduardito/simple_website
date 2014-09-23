<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Free Web tutorials">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Ståle Refsnes">
		<meta charset="UTF-8">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!–[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]–>
		<link rel="stylesheet" type="text/css" href="css/retocando.css" />
		<link rel="stylesheet" type="text/css" href="css/retocando_respon.css" />
		<script type="text/javascript" src="./javascript/jquery-1.7.1.js"></script>

		<title>Ushuari | Servicios</title>
			<link type="image/x-icon" href="./images/webhelp.ico" rel="shortcut icon"/>
	</head>
	<body>
		<?php include './menus/page_mobile.php';?>
			<div class="container_texto">

				<div class="cambia_texto">
					<h2>
						Web design
					</h2>
				</div>
				<div class="texto">
					<dl>
						<dt>Reparaci&oacute;n de ordenadores</dt>
						<dd>Cuando un ordenador se estropea, puede ser que haya muerto o simplemente tenga un problema de funcionamiento. Dependiendo del problema que posea necesitar&aacute; una soluci&oacute;n u otra totalmente diferente. </dd>

						<dt>Desarrollo de Aplicaciones Android</dt>
						<dd>Son cada d&iacute;a m&aacute;s comunes los smartphone, o telefonos inteligentes, y cada d&iacute;a nos puede ser m&aacute;s necesario la utilizaci&oacute;n de las dichosas aplicaciones de &eacute;stos, que nos facilitan el uso del mismo.</dd>

						<dt>Desarrollo Web</dt>
						<dd>La competencia en el mundo laboral es hoy en d&iacute;a un asunto pendiente para los desempleados. El uso de las tecnolog&iacute;as de la infromaci&oacute;n facilitan el traspaso de datos, y con eso la posibilidad de que el empresario nos contrate. </dd>

						<dt>Uso de Dispositivos u Ordenadores</dt>
						<dd>No todo el mundo sabe utilizar su tel&eacute;fono o tiene problemas para realizar una funci&oacute;n que otros ven sencilla. </dd>						
					</dl>	

				</div>
			</div>

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

<?php include './headfoot/foot.php';?>