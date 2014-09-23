var $par1 = "Vivimos en una sociedad en la que nos llama la atencion la tecnologia. Por lo que nos sumergimos en la compra de productos con numerosas funciones, y en la que no podemos invertir el tiempo necesario para llegar a conocerlas. ";
var $par2 = "Hoy en dia, internet es, si no me equivoco, una de las herramientas mas utilizadas, cada dia las empresas o incluso los individuos necesatamos nuevos medios donde expresarnos, o darnos a conocer, es decir, paginas WEB";
var $par3 = "Debemos reconocer que el uso dia a dia de nuestro ordenador personal lo ralentiza, ya sea demasiada informacion, o que el software requiere mayor capacidad de estos.El asesoramiento en la compra o reparacion de estos ordenadores es necesaria";

var $num = 0;
function cambiandoParrafos(){
	setTimeout(cambia, 1);
}

function cambia(){
	$num += 1;
	if ($num > 3){
		$num = 0;
	}
	switch($num){
		case 1:
			insertaParrafo($par1);
		break;
		case 2:
			insertaParrafo($par2);
		break;
		case 3:
			insertaParrafo($par3);
		break;
		default:
		break;
	}
	setTimeout(cambia, 5000);
}

function insertaParrafo(par){
	var $padre = document.getElementById('ppp');
	while( $padre.hasChildNodes() ){
	    $padre.removeChild($padre.lastChild);
	}

	var $text = document.createTextNode(par);
	var $p = document.createElement('p');
	$p.appendChild($text);
	$padre.appendChild($p);
}