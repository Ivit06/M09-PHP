<?php

function connectDatabase_SQLITE($config, $mensajes) {
    $file = $config['db_file']; // Nombre del archivo de la base de datos SQLite
    $con = new SQLite3($file);
    if (!$con) {
        die($mensajes['mensajes']['error']['basedatos']);
    }
    return $con;
}

function comprobar_bd_tb_SQLITE($config, $mensajes) {

    $con = connectDatabase_SQLITE($config, $mensajes);
    $create_table_query = "CREATE TABLE IF NOT EXISTS Todas (
        ID INTEGER PRIMARY KEY AUTOINCREMENT,
        Titulo TEXT,
        Descripcion TEXT,
        Estado TEXT
    )";
    if (!$con->exec($create_table_query)) {
        die($mensajes['mensajes']['error']['creartab'] . $con->lastErrorMsg());
    }
    $con->close();
}

function add_to_bd_SQLITE($options, $mensajes, $config) {
    $con = connectDatabase_SQLITE($config, $mensajes);
    $titulo = comprobar_titulo_get($options, $mensajes);
    $descripcion = comprobar_desc_get($options, $mensajes);
    $insert_query = $con->prepare("INSERT INTO Todas (Titulo, Descripcion, Estado) VALUES (:titulo, :descripcion, 'Incompleto')");
    $insert_query->bindValue(':titulo', $titulo, SQLITE3_TEXT);
    $insert_query->bindValue(':descripcion', $descripcion, SQLITE3_TEXT);
    $result = $insert_query->execute();
    if ($result) {
        echo $mensajes['mensajes']['tarea']['añadida'];
    } else {
        echo $mensajes['mensajes']['error']['añadida'] . $con->lastErrorMsg();
    }

    $con->close();
}

function read_to_bd_SQLITE($config, $mensajes) {
    $con = connectDatabase_SQLITE($config, $mensajes);
    $query = "SELECT * FROM Todas";  ////PUEDE QUE EL ERROR ESTE AQUÍ
    $result = $con->query($query);
    if ($result) {
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            echo $row['ID'] . ' --- ' . $row['Titulo'] . ' --- ' . $row['Descripcion'] . ' --- ' . $row['Estado'] . "\n";
        }
    } 
    else {
        echo $mensajes['mensajes']['error']['leer'] . $con->lastErrorMsg();
    }
    $con->close();
}


function complete_to_bd_SQLITE($config, $options, $mensajes) {
    $con = connectDatabase_SQLITE($config, $mensajes);
    $id = comprobar_id_get($options,$mensajes);
    $update_query = $con->prepare("UPDATE Todas SET Estado = 'Completo' WHERE ID = :id");
    $update_query->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $update_query->execute();
    if ($result) {
        echo $mensajes['mensajes']['tarea']['completada'];
    } else {
        echo $mensajes['mensajes']['error']['completada'] . $con->lastErrorMsg();
    }
    $con->close();
}

function delete_to_bd_SQLITE($config, $options, $mensajes) {
    $con = connectDatabase_SQLITE($config, $mensajes);
    $id = comprobar_id_get($options,$mensajes);
    $delete_query = $con->prepare("DELETE FROM Todas WHERE ID = :id");
    $delete_query->bindValue(':id', $id, SQLITE3_INTEGER);
    $result = $delete_query->execute();
    if ($result) {
        echo $mensajes['mensajes']['tarea']['eliminada'];
    } else {
        echo $mensajes['mensajes']['error']['eliminada'] . $con->lastErrorMsg();
    }
    $con->close();
}

?>