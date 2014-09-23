function verifica1(){
	var $comprobar = document.getElementById("contrasenya2").value;
	var $input = document.getElementById("contrasenya1");
	var $texto = document.getElementById("contrasenya1").value;
	if($texto.length > 4){
		$input.style.borderColor = "green";
		
	}
	else{
		$input.style.borderColor = "yellow";
		if($texto == ""){
			document.getElementById("contrasenya2").style.borderColor="red";
		}
		if($comprobar == ""){
			document.getElementById("contrasenya2").style.borderColor="none";
		}
	}
}

function verifica2(){
	var $input = document.getElementById("contrasenya2");
	var $texto = document.getElementById("contrasenya1").value;
	var $comprobar = document.getElementById("contrasenya2").value;
	if($texto == $comprobar){
		$input.style.borderColor = "green";
	}
	else
		$input.style.borderColor = "red";
}
