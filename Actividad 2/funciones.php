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
	$a = getopt('o:i:t:d:', ['option:', 'id:', 'titulo:', 'descripción:']); #He tenido que poner todo con solo : porque si no me obligaba a poner el valor a continuación del parámetro (-iHola)
	return $a;
}

function comprobar_acc_get($options) {
	if (isset($options['o']) && isset($options['option'])) { #comprobamos que el usuario no nos pase los dos parámetro para la acción. Si lo hace le damos la ayuda
		return more_than_one(); 
	}
	if (isset($options['o'])) {
		$value = $options['o'];
		return $value;
	}
	if (isset($options['option'])) {
		$value = $options['option'];
		return $value;
	}
	else{
		return help();
	}
}

function comprobar_id_get($options) {
	if (isset($options['i']) && isset($options['id'])) {
		return more_than_one(); 
	}
	if (isset($options['i'])) {
		$value = $options['i'];
		return $value;
	}
	if (isset($options['id'])) {
		$value = $options['id'];
		return $value;
	}
	else{
		return help();
	}
}

function comprobar_titulo_get($options) {
	if (isset($options['t']) && isset($options['titulo'])) {
		return more_than_one(); 
	}
	if (isset($options['t'])) {
		$value = $options['t'];
		return $value;
	}
	if (isset($options['titulo'])) {
		$value = $options['titulo'];
		return $value;
	}
	else{
		return help();
	}
}

function comprobar_desc_get($options) {
	if (isset($options['d']) && isset($options['descripción'])) {
		return more_than_one(); 
	}
	if (isset($options['d'])) {
		$value = $options['d'];
		return $value;
	}
	if (isset($options['descripción'])) {
		$value = $options['descripción'];
		return $value;
	}
	else{
		return help();
	}
}

function add_to_bd($options) {	
	$servername = "localhost";
    $username = "task_manager";
    $password = "mysql12345";
    $dbname = "task";
    $con = new mysqli($servername, $username, $password, $dbname);
	$titulo = comprobar_titulo_get($options);		#Las funciones las llamo aquí por si hay error para que me retornen el help.
	$descripción = comprobar_desc_get($options);
	mysqli_query($con, "INSERT INTO task.Todas (Titulo, Descripción, Estado) VALUES ('$titulo', '$descripción', 'incompleto')");
	$m = tarea_a();
	echo $m;
	$con->close();
}

function read_to_bd() {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
	$result = mysqli_query($con,"SELECT * FROM task.Todas");
	while ($row = $result->fetch_assoc()) {   
		echo $row['ID'] , ' --- ' , $row['Titulo'] , ' --- ' , $row['Descripción'] ,' --- ', $row['Estado'], "\n";
	}
	$con->close();
}

function complete_to_bd($options) { 
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
	$id = comprobar_id_get($options);
	mysqli_query($con,"UPDATE task.Todas SET Estado='complete' WHERE ID = $id");
	$m = tarea_c();
	echo $m;
	$con->close();
}

function delete_to_bd($options) {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
    $id = comprobar_id_get($options);
	mysqli_query($con,"DELETE FROM task.Todas WHERE ID = $id");
	$m = tarea_e();
	echo $m;
	$con->close();
}

?>