<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<meta name="description" content="Free Web tutorials">
		<meta name="keywords" content="HTML,CSS,XML,JavaScript">
		<meta name="author" content="Ståle Refsnes">
		<meta charset="UTF-8">

		<title>Ushuari | Aportando mi granito de arena</title>
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!–[if lt IE 9]>
			<script type="text/javascript" src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]–>
		<link type="image/x-icon" href="./images/webhelp.ico" rel="shortcut icon"/>
		<link rel="stylesheet" type="text/css" href="css/retocando.css" />
		<link rel="stylesheet" type="text/css" href="css/retocando_respon.css" />
		<script type="text/javascript" src="./javascript/modi_principal.js"></script>
		<script type="text/javascript" src="./javascript/jquery-1.7.1.js"></script>
	</head>
	<body onload="cambiandoParrafos()">
		<?php include './menus/page_mobile.php';?>
			<div class="container_img">
				<img id="img_prin" src="" />
			</div>
			<div class="cont_inf">
				<div class="cont_inf_lef">
					<h3>&Uacute;ltimo linkedin</h3>
					<p>Estoy residiendo en Guadalajara, haciendo un curso de inform&aacute;tica. Aprendiendo lenguages varios como Java, Visual Studio, SQL, PHP, CSS/HTML </p>
				</div>
				<div class="cont_inf_cen">
					<h3>Por qu&eacute; realizo esta p&aacute;gina?</h3>
					<div id="ppp"></div>
				</div>
				<div class="cont_inf_rig">
					<h3>Trabajos en proceso</h3>
					<p><b>Edu</b> p&aacute;gina web para su empresa privada.PHP</p>
					<p><b>Mar&iacute;a Jesus </b>Software de Gesti&oacute;n de la base de datos de una empresa. HIBERNATE/Java</p>
					<p><b>Cesar </b>Desarrollando una aplicaci&oacute;n para Android SDK</p>
				</div>

			</div>

<script> 
	(function() { 
		var $ancho = $(window).width();
		if ($ancho < 480){
			$('div.container_menu').addClass('ocultando');
		}
	})(); 
</script>
<script>
	(function() {
		$('a#show_main_menu').bind('click', function() {
			if ($('div.container_menu').is(':visible')){ 
				$('div.container_menu').slideUp(600);
			}
			else{
				$('div.container_menu').slideDown(600); 
			}
		});
	})();
</script>  
<script> 
	$(document).ready(function(){
		var $ancho = $(window).width();
		if ($ancho < 480){
			$('img#img_prin').attr('src','./images/pmobile.jpg');
		}
		else{
			$('img#img_prin').attr('src','./images/pscreen.jpg');
		}
	});	
</script>
  
<?php include './headfoot/foot.php';?>