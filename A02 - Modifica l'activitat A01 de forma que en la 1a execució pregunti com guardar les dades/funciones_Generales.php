<?php

require_once '../vendor/autoload.php';
$mensajes = Symfony\Component\Yaml\Yaml::parseFile('mensajes.yaml');

function eliminar_errores() {
	error_reporting(0);	
}

function comprovarCLI() {
	$aviso_cli = null;
	if (php_sapi_name() != 'cli') {
        	$aviso_cli = $mensajes['mensajes']['error']['cli'];
	}
	return  $aviso_cli; 
}

function confi_getopt(){
	$a = getopt('o:i:t:d:', ['option:', 'id:', 'titulo:', 'descripción:']); 
	return $a;
}

function comprobar_acc_get($options) {
	if (isset($options['o']) && isset($options['option'])) { 
		return more_than_one(); 
	}
	if (isset($options['o'])) {
		$value = $options['o'];
		return $value;
	}
	if (isset($options['option'])) {
		$value = $options['option'];
		return $value;
	}
	else{
		return help();
	}
}

function comprobar_id_get($options) {
	if (isset($options['i']) && isset($options['id'])) {
		return more_than_one(); 
	}
	if (isset($options['i'])) {
		$value = $options['i'];
		return $value;
	}
	if (isset($options['id'])) {
		$value = $options['id'];
		return $value;
	}
	else{
		return help();
	}
}

function comprobar_titulo_get($options) {
	if (isset($options['t']) && isset($options['titulo'])) {
		return more_than_one(); 
	}
	if (isset($options['t'])) {
		$value = $options['t'];
		return $value;
	}
	if (isset($options['titulo'])) {
		$value = $options['titulo'];
		return $value;
	}
	else{
		return help();
	}
}

function comprobar_desc_get($options) {
	if (isset($options['d']) && isset($options['descripción'])) {
		return more_than_one(); 
	}
	if (isset($options['d'])) {
		$value = $options['d'];
		return $value;
	}
	if (isset($options['descripción'])) {
		$value = $options['descripción'];
		return $value;
	}
	else{
		return help();
	}
}

?>