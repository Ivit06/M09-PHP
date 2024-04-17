<?php

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

function more_than_one(){
    return "Estas utilizando más de un parámetro: \nEjemplo: Para determinar acción utilize -o o --option (NUNACA LAS DOS A LA VEZ)\n";
}

function aviso_cli() {
    return "Aquest script només es pot executar des del CLI.\n";
}
?>


