<?php
require_once('./init.php');
class NewCom{
	private $conn = "";
	/* comu_no, id_clientes, tipo_con, titulo, descricion, fecha_crea*/
	function __construct($conexion){
		$this->conn = $conexion;
	}

	//crea nueva comunicacion
	function createNewCom($id = 1 ,$tipo = 1, $tit = "error", $text = "fallo"){
		$sql = "INSERT INTO comunicaciones (id_clientes, tipo_con, titulo) VALUES(".$id.",".$tipo.",'".$tit."');";
		$c = $this->conn;
		$c->query($sql);

		$sql = "INSERT INTO seguimiento (comu_no, who, texto) VALUES(".$c->insert_id.",".$id.",'".$text."');";
		$c->query($sql);
		return True;
	}

	function guardamosTextoenlaConversacion($arraypost = array()){
		$texto = $arraypost['new_text'];
		$who = $arraypost['who'];
		$comu_no = $arraypost['comu_no'];

		$sql = "INSERT INTO seguimiento (comu_no, who, texto) VALUES(".$comu_no.",".$who.",'".$texto."');";
		$c = $this->conn;
		$c->query($sql);
		return True;
	}
}

class NewCliente{

	function __construct(){	
		$this->date = date('Y-m-d H:i:s');
		$this->returndata = array(
			'errores' => array(),
			'form_ok' => true,
			'data' => array(
				'client_num' => '',
				'client_rol' => 100,
				)
		);
	}

	//crea nueva comunicacion
	function logueandose($datos){
		global $conexion;
		if ($datos['email'] =="" && $datos['password'] =="" || ($datos['email'] =="" || $datos['password'] =="")){
			array_push($this->returndata['errores'], 'No has introducido ningun dato');
			array_push($this->returndata['errores'], 'Por favor ingresa tus datos');
			$this->returndata['form_ok'] = false;
		}
		else{
			$sentencia = "SELECT * FROM clientes WHERE email='".$datos['email']."';"; //active=1
			$resultado = $conexion->query($sentencia);
			if($row = $resultado->fetch_assoc()){//existe el usuario
				if($row['active'] == 1){
					if($row['contrasena'] == $datos['password']){
						$this->returndata['data']['num_client'] = $row['client_no'];
						$this->returndata['data']['rol_client'] = $row['tipo_rol'];
					}
					else{
						array_push($this->returndata['errores'], 'el cliente '.$datos['email'].' y la contrase&ntilde;a no coinciden');
						array_push($this->returndata['errores'], 'Revisa los datos introducidos y vuelve a intentarlo');
						$this->returndata['form_ok'] = false;
					}
				}
				else{
					array_push($this->returndata['errores'], 'el cliente '.$datos['email'].' no esta activado');
					array_push($this->returndata['errores'], 'Revisa tu correo recibido en la bandeja de entrada y en el correo no desea para activar tu cuenta');
					$this->returndata['form_ok'] = false;
				}
			}
			else{// no existe el email
				array_push($this->returndata['errores'], 'el cliente '.$datos['email'].' no existe');
				array_push($this->returndata['errores'], 'Registrate en el area clientes');
				$this->returndata['form_ok'] = false;
			}			
		}
		return $this->returndata;
	}

	function creandoCliente($datos){
		global $conexion;
		$this->nom = mysql_real_escape_string($datos['name']);
		$this->ape = mysql_real_escape_string($datos['apellido']);
		$this->ema = mysql_real_escape_string($datos['email']);
		$this->pas = sha1(mysql_real_escape_string($datos['password']));
		$this->tel = mysql_real_escape_string($datos['telefono']);
		$this->hash = sha1( rand(0,1000) ); // Generate random 32 character hash and assign it to a local variable. 
		$this->buscaClienteEnBBDD($conexion);
		if($this->returndata['form_ok']){
			$sql = "INSERT INTO clientes (nombre, apellidos, email, contrasena, telefono, tipo_rol, hash) VALUES('"
				.$this->nom."','".$this->ape."','".$this->ema."','".$this->pas."','".$this->tel."','100', '".$this->hash."');";
			$conexion->query($sql);
			$this->enviandoMailVerificacion();

		}
		return $this->returndata;
	}


	function buscaClienteEnBBDD($conexion){
		$existe = false;
		$sentencia = "SELECT email FROM clientes WHERE email='".$this->ema."';";
		$resultado = $conexion->query($sentencia);
		if($resultado->num_rows > 0 ){
			array_push($this->returndata['errores'],'El email '.$this->ema.' que intentas insertar ya est&aacute; en nuestra base de datos');
			$sentencia1 = "SELECT email FROM clientes WHERE email='".$this->ema."' AND active=0;";
			$resultado1 = $conexion->query($sentencia1);
			if($resultado->num_rows > 0 ){
				array_push($this->returndata['errores'],'Revisa tu email, y activa tu cuenta');
				array_push($this->returndata['errores'],'Revisa los correos no deseados');
			}
			$this->returndata['form_ok'] = false;
		}
	}

	function enviandoMailVerificacion(){ 
		$subject    = 'Registro | Verificacion'; // Give the email a subject   
		$admin_email = 'admin@ushauri.hol.es'; // Set from headers  
		$admin_name  = 'Administrador de Ushauri';

		$message    = ' 
		<br />
		<br />Gracias '.$this->nom.' por registrarte! 
		<br />Tu cuenta ha sido activada. 
		<br />
		<br />------------------------ 
		<br />Usuario: '.$this->ema.' 
		<br />Fecha de creacion: '.$this->date.' 
		<br />Telefono: '.$this->tel.'
		<br />------------------------ 
		<br /> 
		<br /><a href="http://ushauri.hol.es/verify.php?cuchara='.
			$this->ema .'&tenedor='.
			$this->hash.'&cuchillo=jdaofidjajjksdaukhdashjsd&
			meta-data=345ikdsafjksd834h5rkjsdaf98342hjhcakdbda7y4ihdfajkhdasf98y4hfgafhjkahdfjhdasifghadskfh">
		Please click this link to activate your account</a>
		<br /> 
		<br />';

	    // To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		// Additional headers
		$headers .= 'To: '.$this->nom.' '. $this->ema . "\r\n";
		$headers .= 'From: '. $admin_name .' ' . $admin_email . "\r\n";
		$exito = mail($this->ema, $subject, $message, $headers);
		if (!$exito){
			$this->returndata['form_ok'] = false;
			array_push($this->returndata['errores'],'el mensaje no se enviado con exito, intentelo de nuevo mas tarde');
		}

	}
	function __destruct(){

	}

}