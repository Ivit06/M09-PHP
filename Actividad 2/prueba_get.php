<?php

include 'funciones.php'; #Al declararlo aquí todas ya se leen entre ellas no hace falta hacerlo de nuevo
include 'mensajes.php';
include 'constantes.php';

eliminar_errores();

if( $aviso_cli = comprovarCLI() ) { echo $aviso_cli; return true;}

connectDatabase(); 

$options = confi_getopt(); #Lo quiero así porque estas opciones las voy a pasar mas de una vez a diferentes cosas

$value = comprovar_acc_get($options);

print ($value)

#Ahora quiero continuar con el tema del switch. Entrando con el $valor y luego tengo que cambiar la función de add, save, show para utilizar los parámetros -i,-t ...

?>	