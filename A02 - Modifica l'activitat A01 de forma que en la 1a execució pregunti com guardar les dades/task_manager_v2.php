<?php

include 'funciones_Generales.php';
include 'funciones_MySQL.php';
include 'funciones_SQLITE';

eliminar_errores();

if( $aviso_cli = comprovarCLI() ) { echo $aviso_cli; return true;}



?>