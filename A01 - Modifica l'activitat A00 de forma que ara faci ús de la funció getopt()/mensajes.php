<?php

function help() {
    echo "Error: No s'han proporcionat suficients arguments.\n";
    echo "Uso: php task_manager_get.php (-o or --option)\n";
    echo "Opciones:\n";
    echo " add (-t or --titulo) 'titulo' (-d or --descripción) 'descripción'    Añade una tarea\n";
    echo " show                                                                 Muestra todas las tareas\n";
    echo " complete (-i or --id) id.tarea                                       Marca una tarea como completada\n";
    echo " delete (-i or --id) id.tarea                                         Elimina una tarea\n";
    echo " help                                                                 Muestra este mensaje de ayuda\n";
    }

function more_than_one(){
    return "Estas utilizando más de un parámetro: \nEjemplo: Para determinar acción utilize -o or --option (NUNACA LAS DOS A LA VEZ)\n";
}

function aviso_cli() {
    return "Este script solo se puede ejecutar en cli.\n";
}

function tarea_a(){
    return "Tarea añadida.\n";
}

function tarea_c(){
    return "Tarea completada.\n";
}

function tarea_e(){
    return "Tarea eliminada.\n";
}

?>


