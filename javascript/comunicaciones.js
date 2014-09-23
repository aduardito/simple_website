function abrePopUp(){
	if (!document.getElementById('formularioComunicacion')){
	//div principal
		var $div = document.createElement('div');
		$div.style.position = "absolute";
		$div.style.width = "100%";
		$div.style.height = "100%";
		$div.style.top = "0%";
		$div.style.left = "0%";
		$div.id = "formularioComunicacion";
		$div.style.backgroundColor = "grey";
		$div.style.opacity = "0.8";

		//div secundario
			$div_ce = document.createElement('div');
			$div_ce.style.position = "relative";
			$div_ce.style.width = "36%";
			$div_ce.style.height = "44%";
			$div_ce.style.left="32%";
			$div_ce.style.top="28%";
			$div_ce.style.textAlign="center";
			$div_ce.style.backgroundColor = "white";
			$div_ce.style.borderRadius = "15px";
			$div.appendChild($div_ce);

				var $p = document.createElement('p');
				$p.style.textAlign = "right";
				$p.setAttribute('onclick','cerrarPopUp();');
				$p.appendChild(document.createTextNode('Close Window'));
				$p.style.textDecoration="underline";
				$p.style.marginRight="5px";
				$p.style.marginTop = "5px";
				$div_ce.appendChild($p);

			//formulario
				var $form = document.createElement('form');
				$form.setAttribute('action','creacomucliente.php');
				$form.setAttribute('method','post');
				$form.setAttribute('onsubmit','return validate()');
				$form.style.textAlign = "center";
				$form.style.position = "relative";
				$form.style.padding = "3%";
				$form.style.paddingTop = "0%";

				//label titulo
					$p = document.createElement('p');
					$text = document.createTextNode('T\u00EDtulo');
					$p.appendChild($text);
					$p.style.clear = "both";
					$form.appendChild($p);


				//input para escribir texto
					var $input = document.createElement('input');
					$input.setAttribute('name','titulo');
					$input.setAttribute('type', 'text');
					$input.style.clear='both';
					$form.appendChild($input);


				//label
					var $p = document.createElement('p');
					$p.style.clear="both";
					var $text = document.createTextNode('Tipo de Consulta');
					$p.appendChild($text);
					$form.appendChild($p);

				//option tipo consulta
					var $select = document.createElement('select');
					$select.setAttribute('name','tipo');

					var $option = document.createElement('option');
					$option.setAttribute('value','1');
					$option.appendChild(document.createTextNode('ASESORAMIENTO COMPRA'));
					$select.appendChild($option);

					$option = document.createElement('option');
					$option.setAttribute('value','2');
					$option.appendChild(document.createTextNode('REPARACION DE ORDENADORES'));
					$select.appendChild($option);

					$option = document.createElement('option');
					$option.setAttribute('value','3');
					$option.appendChild(document.createTextNode('DESARROLLO APP ANDROID'));
					$select.appendChild($option);

					$option = document.createElement('option');
					$option.setAttribute('value','4');
					$option.appendChild(document.createTextNode('DESARROLLO WEB'));
					$select.appendChild($option);

					$option = document.createElement('option');
					$option.setAttribute('value','5');
					$option.appendChild(document.createTextNode('USO DISPOSITIVO'));
					$select.appendChild($option);

					$form.appendChild($select);

				//label
					$p = document.createElement('p');
					$text = document.createTextNode('Mensaje');
					$p.appendChild($text);
					$form.appendChild($p);

				//escribe mensaje 
					var $textarea = document.createElement('textarea');
					$textarea.setAttribute('name','descrip');
					$textarea.setAttribute('rows','4');
					$textarea.setAttribute('cols','30');
					$textarea.setAttribute('maxlength','1024');
					$textarea.id="empiezaCom";
					$form.appendChild($textarea);

					var $br = document.createElement('br');
					$form.appendChild($br);

				//boton de enviar
					var $input = document.createElement('input');
					$input.setAttribute('value','Enviar');
					$input.setAttribute('type', 'submit');
					$input.style.clear='both';

					$form.appendChild($input);

					$div_ce.appendChild($form);

		document.body.appendChild($div);		
	}
}

function cerrarPopUp(){
	var $div = document.getElementById('formularioComunicacion');
	$div.parentNode.removeChild($div);
}

function validate() {
    if (document.getElementById("empiezaCom").value == "") {
    	alert("all fields are empty");
        return false;
    } else {
        return true;
    }
}