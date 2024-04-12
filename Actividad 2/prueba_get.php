<?php

function comprovar_acc_get() {
	$options = getopt('o:i::t::d::', ['option:', 'id::', 'tarea::', 'descripción::']);
	var_dump($options);
	if (isset($options['o'])) {
		$value = $options['o'];
		return $value; #Queremos que retorne el valor para poder usarlo en el swich
	}
	else{
		return help();
	}
}

function change_value () {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
	$titulo = $options['t'];
	$descripción = $argv[3];
	mysqli_query($con, "INSERT INTO task.Todas (Titulo, Descripción, Estado) VALUES ('$titulo', '$descripción', 'incompleto')");
	echo "Tarea añadida.\n";
	$con->close();
}

?>	