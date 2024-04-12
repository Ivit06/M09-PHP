<?php

function eliminar_errores() {
error_reporting(0);	
}

eliminar_errores();

function comprovarCLI() {
	$aviso_cli = null;
	if (php_sapi_name() != 'cli') {
        	$aviso_cli = "Aquest script només es pot executar des del CLI.\n";
	}
	return $aviso_cli; 
}

if( $aviso_cli = comprovarCLI() ) { echo $aviso_cli; return true;}

function help() {
echo "Error: No s'han proporcionat suficients arguments.\n";
echo "Uso: php task_manager.php [opción]\n";
echo "Opciones:\n";
echo "  add 'tarea' 'descripción'	Añade una tarea\n";
echo "  show				Muestra todas las tareas\n";
echo "  complete id			Marca una tarea como completada\n";
echo "  delete id			Elimina una tarea\n";
echo "  help				Muestra este mensaje de ayuda\n";
}

function comprovar_parametros($argc) {
if ($argc<2) {
	help();
	exit();
}
}

comprovar_parametros($argc);

$action = trim( $argv[1] );

const ACTION_1= "add";
const ACTION_2= "show";
const ACTION_3= "complete";
const ACTION_4= "delete";

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

connectDatabase(); 

function add_to_bd($argv) {
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

function read_to_bd() {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
	$result = mysqli_query($con,"SELECT * FROM task.Todas");
	while ($row = $result->fetch_assoc()) {   
		echo $row['task_id'] , ' --- ' , $row['Titulo'] , ' --- ' , $row['Descripción'] ,' --- ', $row['Estado'], "\n";
	}
	$con->close();
}

function complete_to_bd($argv) {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
	$id = $argv[2];
	mysqli_query($con,"UPDATE task.Todas SET Estado='complete' WHERE task_id = $id");
	echo "Tarea completada.\n";
	$con->close();
}

function delete_to_bd($argv) {
	$servername = "localhost";
	$username = "task_manager";
	$password = "mysql12345";
	$dbname = "task";
	$con = new mysqli($servername, $username, $password, $dbname);
        $id = $argv[2];
	mysqli_query($con,"DELETE FROM task.Todas WHERE task_id = $id");
	echo "Tarea eliminada.\n";
	$con->close();
}

switch ($action) {
	case ACTION_1:
		add_to_bd($argv);
		break;
	case ACTION_2:
		read_to_bd();
		break;
	case ACTION_3:
		complete_to_bd($argv);
		break;
	case ACTION_4:
		delete_to_bd($argv);
		break;
	default:
		help(); 
}

?>