<?php

function connectDatabase_MS() {                    //Comprobamos conexión con la base de datos
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

function add_to_bd_MS($options,$mensajes) {	
	$servername = "localhost";
    $username = "task_manager";
    $password = "mysql12345";
    $dbname = "task";
    $con = new mysqli($servername, $username, $password, $dbname);
	$titulo = comprobar_titulo_get($options);		#Las funciones las llamo aquí por si hay error para que me retornen el help.
	$descripción = comprobar_desc_get($options);
	mysqli_query($con, "INSERT INTO task.Todas (Titulo, Descripción, Estado) VALUES ('$titulo', '$descripción', 'incompleto')");
	echo $mensajes['mensajes']['tarea']['añadida'];
	$con->close();
}

function read_to_bd_MS() {
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

function complete_to_bd_MS($options,$mensajes) { 
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
	$id = comprobar_id_get($options);
	mysqli_query($con,"UPDATE task.Todas SET Estado='complete' WHERE ID = $id");
	echo $mensajes['mensajes']['tarea']['completada'];
	$con->close();
}

function delete_to_bd_MS($options,$mensajes) {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
    $id = comprobar_id_get($options);
	mysqli_query($con,"DELETE FROM task.Todas WHERE ID = $id");
	echo $mensajes['mensajes']['tarea']['eliminada'];
	$con->close();
}

?>