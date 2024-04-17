<?php

function eliminar_errores() {
	error_reporting(0);	
}

function comprovarCLI() {
	$aviso_cli = null;
	if (php_sapi_name() != 'cli') {
        	$aviso_cli = aviso_cli();
	}
	return $aviso_cli; 
}

function connectDatabase() {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname); 
	if ($con->connect_error) {
		die('Error de Conexión (' . $con->connect_errno . ') '. $con->connect_error);
	}
	else{
		$con->close(); 
	}
}

function confi_getopt(){
	$a = getopt('o:i::t::d::', ['option:', 'id::', 'tarea::', 'descripción::']);
	return $a;
}

function comprovar_acc_get($options) {
	if (isset($options['o']) && isset($options['option'])) { #comprovamos que el usuario no nos pase los dos parámetro para la acción. Si lo hace le damos la ayuda
		return more_than_one(); 
	}
	if (isset($options['o'])) {
		$value = $options['o'];
		return $value; #Queremos que retorne el valor para poder usarlo en el swich
	}
	if (isset($options['option'])) {
		$value = $options['option'];
		return $value; #Queremos que retorne el valor para poder usarlo en el swich
	}
	else{
		return help();
	}
}

function add_to_bd($argv) {	#ahora en estas funciones tendré que extraer los valores que me interesen con una función parecida a comprovar_acc_get y pasarlos como valor sustituyendo $argv
	$servername = "localhost";
    $username = "task_manager";
    $password = "mysql12345";
    $dbname = "task";
    $con = new mysqli($servername, $username, $password, $dbname);
	$titulo = $argv[2];
	$descripción = $argv[3];
	mysqli_query($con, "INSERT INTO task.Todas (Titulo, Descripción, Estado) VALUES ('$titulo', '$descripción', 'incompleto')");
	echo "Tarea añadida.\n";
	$con->close();
}

?>