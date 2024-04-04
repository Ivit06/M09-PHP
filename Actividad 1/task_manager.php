<?php

function eliminar_errores() {
error_reporting(0);		//Nos elimina los warning de php para que el usuario no los vea
}

eliminar_errores();

function comprovarCLI() {
	$aviso_cli = null;
	if (php_sapi_name() != 'cli') {
        	$aviso_cli = "Aquest script només es pot executar des del CLI.\n";
	}
	return $aviso_cli; //Es interesante que las funciones retornen algo como una frase o valor y luego decidir si mostrarlo o no
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
	return help();
}
}

comprovar_parametros($argc); //Comprovamos la cantidad de argumentos que nos han puesto

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
	$con = new mysqli($servername, $username, $password, $dbname); //Las variiables solo afectan en la función
	if ($con->connect_error) {
		die('Error de Conexión (' . $con->connect_errno . ') '. $con->connect_error);
	}
	else{
		$con->close(); //Abriremos y cerraremos conexion con la base de datos para hacer las acciones.
	}
}

connectDatabase(); //Aquí pruebo la conexión a la base de datos si no va me lo dice y se cierra

function add_to_bd($argv) {
	$servername = "localhost";
        $username = "task_manager";
        $password = "mysql12345";
        $dbname = "task";
        $con = new mysqli($servername, $username, $password, $dbname);
	$titulo = $argv[2];             //OJOOO ESTO LO PUEDO HACER PORQUE A LA FUNCIÓN LE PASO LA VARIABLE $ARGV
	$descripción = $argv[3];
	//var_dump($con);
	//die() ASI PODEMOS PROBAR LAS COSAS QUE VAMOS HACIENDO.
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
	while ($row = $result->fetch_assoc()) {   //ANTES DE NADA PROBAR A PRINTAR ROW A VER QUE TENEMOS
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
        $id = $argv[2]; // if $id = 'all' que lo borre todo estaría bien
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
