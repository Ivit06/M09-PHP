<?php
//Esto sin función porque me interesa que se ejecute cuando hago include en el principal
require_once '../vendor/autoload.php';
$mensajes = Symfony\Component\Yaml\Yaml::parseFile('mensajes.yaml'); 

function eliminar_errores() {
	error_reporting(0);	
}

function comprovarCLI($mensajes) {
	$aviso_cli = null;
	if (php_sapi_name() != 'cli') {
        	$aviso_cli = $mensajes['mensajes']['error']['cli'];
	}
	return  $aviso_cli; 
}

function get_config($mensajes) {
    $config_file = 'usuario.config';
    if (file_exists($config_file)) {
        $config = parse_ini_file($config_file);
    } else {
        // Pedir información de conexión al usuario si el archivo .config no existe
        echo $mensajes['mensajes']['config']['primera'];
        $method = strtoupper(trim(fgets(STDIN))); //convierte todos los caracteres de la cadena a mayúsculas. para eliminar cualquier espacio en blanco que el usuario pueda haber añadido antes o después de su entrada.
        if ($method !== 'MYSQL' && $method !== 'SQLITE') {
            die($mensajes['mensajes']['error']['almacenamiento']);
        }
        // Guardar la información de conexión en el archivo .config
        if ($method == 'MYSQL'){
        echo $mensajes['mensajes']['config']['ingrese'] ;
        $config = [];
        $config['method'] = $method;
        echo $mensajes['mensajes']['config']['host'];
        $config['host'] = trim(fgets(STDIN));    //QUITA LOS ESPACIOS Y LEE EN LINEA DESDE UN RECURSO DE ARCHIVO.
        echo $mensajes['mensajes']['config']['user'];
        $config['username'] = trim(fgets(STDIN));
        echo $mensajes['mensajes']['config']['passw'];
        $config['password'] = trim(fgets(STDIN));
        echo $mensajes['mensajes']['config']['dbname'];
        $config['dbname'] = trim(fgets(STDIN));
        echo $mensajes['mensajes']['config']['datosad']; //Quiero los datos del usuario admin para poder crear el usuario, bd, tabla en el caso de que no exista.
        echo $mensajes['mensajes']['config']['adminh'];
        $config['admin_host'] = trim(fgets(STDIN));
        echo $mensajes['mensajes']['config']['adminu'];
        $config['admin_username'] = trim(fgets(STDIN));
        echo $mensajes['mensajes']['config']['adminp'];
        $config['admin_password'] = trim(fgets(STDIN));
        }

        if ($method == 'SQLITE'){
            echo $mensajes['mensajes']['config']['ingrese'];
            $config = [];
            $config['method'] = $method;
            echo $mensajes['mensajes']['config']['dbfile'];
            $config['db_file'] = trim(fgets(STDIN)); //Para la conexion con el sqlite solo necesito este dato.
            }
    }
    $fp = fopen($config_file, 'w');
    foreach ($config as $key => $value) {
        fwrite($fp, "$key=$value\n");
    }
    fclose($fp);
    return $config;
}

function confi_getopt() {
    return getopt('o:i:t:d:', ['option:', 'id:', 'titulo:', 'descripción:']);
}

function comprobar_acc_get($options, $mensajes) {
    if (isset($options['o']) && isset($options['option'])) {
        die($mensajes['mensajes']['error']['parametro']);
    }
    if (isset($options['o'])) {
        return $options['o'];
    }
    if (isset($options['option'])) {
        return $options['option'];
    }
    else{
        die($mensajes['mensajes']['help']);
    }
}

function comprobar_id_get($options, $mensajes) {
    if (isset($options['i']) && isset($options['id'])) {
        die($mensajes['mensajes']['error']['parametro']);
    }
    if (isset($options['i'])) {
        return $options['i'];
    }
    if (isset($options['id'])) {
        return $options['id'];
    }
    else{
        die($mensajes['mensajes']['help']);
    }
}

function comprobar_titulo_get($options, $mensajes) {
    if (isset($options['t']) && isset($options['titulo'])) {
        die ($mensajes['mensajes']['error']['parametro']);
    }
    if (isset($options['t'])) {
        return $options['t'];
    }
    if (isset($options['titulo'])) {
        return $options['titulo'];
    }
    else{
        die($mensajes['mensajes']['help']);
    }
}

function comprobar_desc_get($options, $mensajes) {
    if (isset($options['d']) && isset($options['descripción'])) {
        die ($mensajes['mensajes']['error']['parametro']);
    }
    if (isset($options['d'])) {
        return $options['d'];
    }
    if (isset($options['descripción'])) {
        return $options['descripción'];
    }
    else{
        die($mensajes['mensajes']['help']);
    }
}

?>