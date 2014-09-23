<div class="menu_mobile">
	<div class="bar_display">
		<div class="bar_display_text"><p>Ushauri</p></div>
		<div class="bar_display_menu"><a class="show_main_menu" href="#"><img src="./images/menu.png" /></a></div>
	</div>
	<?php 
		if($_SESSION["rol"] == 1){
			include './menus/mnu_adm.php';
		}
		else{
			include './menus/mnu_cli.php';
		}
	?>
	<div id="limpia" style="clear:left"></div>
</div>
<div class="container_principal">
	<div class="menu_page">

		<?php 
			if($_SESSION["rol"] == 1){
				include './menus/mnu_adm.php';
			}
			else{
				include './menus/mnu_cli.php';
			}
		?>

	</div>



