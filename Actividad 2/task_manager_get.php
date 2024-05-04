<?php

include 'funciones.php'; #Al declararlo aquí todas ya se leen entre ellas no hace falta hacerlo de nuevo
include 'mensajes.php';
include 'constantes.php';

eliminar_errores();

if( $aviso_cli = comprovarCLI() ) { echo $aviso_cli; return true;}

connectDatabase(); #Siempre comprobamos tanto el cli como la conexión a la base de datos

$options = confi_getopt(); #Lo quiero así porque estas opciones las voy a pasar mas de una vez a diferentes cosas

$action = comprobar_acc_get($options); #Nos quedamos con la acción para poder entrar en el switch.

switch ($action) {
	case ACTION_1:
		add_to_bd($options);
		break;
	case ACTION_2:
		read_to_bd();
		break;
	case ACTION_3:
		complete_to_bd($options);
		break;
	case ACTION_4:
		delete_to_bd($options);
		break;
	default:
		help();
}

?>	