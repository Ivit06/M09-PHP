<?php

include 'funciones_Generales.php';
include 'funciones_MySQL.php';
include 'funciones_SQLITE.php';
include 'constantes.php';

eliminar_errores();

if( $aviso_cli = comprovarCLI($mensajes) ) { echo $aviso_cli; return true;}

$config = get_config($mensajes); //Genero el archivo de configuración del usuario

$options = confi_getopt(); //Analizo los parámetros que nos pasa

$action = comprobar_acc_get($options,$mensajes);

if ($config['method']=='MYSQL'){     //Si el método es MYSQL sigue los siguientes pasos
    comprobar_us_bd_MySQL($config,$mensajes);
    comprobar_tb_MySQL($config, $mensajes);
    switch ($action) {
        case ACTION_1:
            add_to_bd_MySQL($options, $mensajes, $config);
            break;
        case ACTION_2:
            read_to_bd_MySQL($mensajes, $config);
            break;
        case ACTION_3:
            complete_to_bd_MySQL($options, $mensajes, $config);
            break;
        case ACTION_4:
            delete_to_bd_MySQL($options, $mensajes, $config);
            break;
        default:
            echo $mensajes['mensajes']['help'];
    }
}

if ($config['method']=='SQLITE'){                    //Si el método es SQLITE sigue los siguientes pasos
    comprobar_bd_tb_SQLITE($config, $mensajes);
    switch ($action) {
        case ACTION_1:
            add_to_bd_SQLITE($options, $mensajes, $config);
            break;
        case ACTION_2:
            read_to_bd_SQLITE($config, $mensajes);
            break;
        case ACTION_3:
            complete_to_bd_SQLITE($config, $options, $mensajes);
            break;
        case ACTION_4:
            delete_to_bd_SQLITE($config, $options, $mensajes);
            break;
        default:
            echo $mensajes['mensajes']['help'];
    }
}

?>