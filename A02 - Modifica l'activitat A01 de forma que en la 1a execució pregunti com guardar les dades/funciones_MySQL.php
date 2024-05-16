<?php

function connectMySQL($config, $mensajes) {
    $con = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);
    if ($con->connect_error) {
        die( $mensajes['mensajes']['error']['conexión'] . $con->connect_error);
    }
    return $con;
}

function connectMySQLroot($config, $mensajes) {
    $con = new mysqli($config['admin_host'], $config['admin_username'], $config['admin_password']);
    if ($con->connect_error) {
        die( $mensajes['mensajes']['error']['conexión'] . $con->connect_error);
    }
    return $con;
}

function comprobar_us_bd_MySQL($config, $mensajes) {
    $adminCon = connectMySQLroot($config, $mensajes);
    $create_user_query = "CREATE USER IF NOT EXISTS '" . $config['username'] . "'@'" . $config['host'] . "' IDENTIFIED BY '" . $config['password'] . "'";
    if (!$adminCon->query($create_user_query)) {
        die($mensajes['mensajes']['error']['crearusuario'] . $adminCon->error);
    }
    $create_db_query = "CREATE DATABASE IF NOT EXISTS " . $config['dbname'];
    if (!$adminCon->query($create_db_query)) {
        die($mensajes['mensajes']['error']['crearbd'] . $adminCon->error);
    }
    // Otorgar todos los privilegios sobre la base de datos al nuevo usuario
    $grant_db_privileges_query = "GRANT ALL PRIVILEGES ON " . $config['dbname'] . ".* TO '" . $config['username'] . "'@'" . $config['host'] . "'";
    if (!$adminCon->query($grant_db_privileges_query)) {
        die($mensajes['mensajes']['error']['grantdbpriv'] . $adminCon->error);
    }
    if (!$adminCon->query("FLUSH PRIVILEGES")) {
        die($mensajes['mensajes']['error']['flushpriv'] . $adminCon->error);
    }
    $adminCon->close();
}

function comprobar_tb_MySQL($config, $mensajes){
    // Conectar usando el usuario con los nuevos privilegios
    $con = connectMySQL($config, $mensajes);
    // Crear la tabla 'Todas'
    $create_table_query = "CREATE TABLE IF NOT EXISTS Todas (
        ID int NOT NULL AUTO_INCREMENT,
        Titulo varchar(255) DEFAULT NULL,
        Descripción text,
        Estado varchar(255) DEFAULT NULL,
        PRIMARY KEY (ID)
    )";
    if (!$con->query($create_table_query)) {
        die($mensajes['mensajes']['error']['creartab'] . $con->error);
    }
    $con->close();  
}

function add_to_bd_MySQL($options, $mensajes, $config) {
    $con = connectMySQL($config, $mensajes);
    $titulo = comprobar_titulo_get($options, $mensajes);
    $descripcion = comprobar_desc_get($options, $mensajes);
    $query = "INSERT INTO " . $config['dbname'] . ".Todas (Titulo, Descripción, Estado) VALUES ('$titulo', '$descripcion', 'Pendiente')";
    if (!mysqli_query($con, $query)) {
        echo $mensajes['mensajes']['error']['añadida'] . mysqli_error($con);
    } else {
        echo $mensajes['mensajes']['tarea']['añadida'];
    }
    $con->close();
}

function read_to_bd_MySQL($mensajes, $config) {
    $con = connectMySQL($config, $mensajes);
    $result = mysqli_query($con, "SELECT * FROM " . $config['dbname'] . ".Todas");
    if (!$result) {
        echo $mensajes['mensajes']['error']['leer'] . mysqli_error($con);
    } else {
        while ($row = $result->fetch_assoc()) {
            echo $row['ID'], ' --- ', $row['Titulo'], ' --- ', $row['Descripción'], ' --- ', $row['Estado'], "\n";
        }
    }
    $con->close();
}

function complete_to_bd_MySQL($options, $mensajes, $config) {
    $con = connectMySQL($config, $mensajes);
    $id = comprobar_id_get($options, $mensajes);
    $query = "UPDATE " . $config['dbname'] . ".Todas SET Estado='Completada' WHERE ID = $id";
    if (!mysqli_query($con, $query)) {
        echo $mensajes['mensajes']['error']['completada'] . mysqli_error($con);
    } else {
        echo $mensajes['mensajes']['tarea']['completada'];
    }
    $con->close();
}

function delete_to_bd_MySQL($options, $mensajes, $config) {
    $con = connectMySQL($config, $mensajes);
    $id = comprobar_id_get($options, $mensajes);
    $query = "DELETE FROM " . $config['dbname'] . ".Todas WHERE ID = $id";
    if (!mysqli_query($con, $query)) {
        echo $mensajes['mensajes']['error']['eliminada'] . mysqli_error($con);
    } else {
        echo $mensajes['mensajes']['tarea']['eliminada'];
    }
    $con->close();
}

?>