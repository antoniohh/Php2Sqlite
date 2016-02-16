<?php

/* 
 * Copyright (C) 2016 Antonio Horrillo Horrillo
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Conexión con base de datos SQLite.
 */
try {

    // Abrimos la conexión a sqlite con PDO.
    $db = new PDO('sqlite:pdo_php.db');

    // Creamos la tabla si no existe.
    $db->exec("CREATE TABLE IF NOT EXISTS usuarios (
      Nombre TEXT PRIMARY KEY,
      email TEXT,
      clave TEXT)");

    // En un array escribimos las filas que vamos a insertar en la tabla.
    $datos = array(
        array('Nombre' => 'Antonio',
            'email' => 'antoniohh@outlook.com',
            'clave' => '1327301464hh'),
        array('Nombre' => 'Juan',
            'email' => 'juangg@outlook.com',
            'clave' => '1339428612gg'),
        array('Nombre' => 'Felipe',
            'email' => 'felipegh@outlook.com',
            'clave' => '1327214268gh')
    );

    // Preparamos las variables con la sentencia sql y el statement.
    $sql = "INSERT INTO usuarios (Nombre,email,clave)
      VALUES (:Nombre,:email,:clave)";
    $stmt = $db->prepare($sql);

    // Asociamos las variables con los campos al statement.
    $stmt->bindParam(':Nombre', $nombre);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':clave', $clave);

    // Con un ciclo foreach recorremos el array $datos y asociamos el valor de
    // los campos a las variables y ejecutamos el statement.
    foreach ($datos as $d) {
        $nombre = $d['Nombre'];
        $email = $d['email'];
        $clave = $d['clave'];
        $stmt->execute();
    }

    // Realizamos la consulta a la base de datos.
    $result = $db->query('SELECT * FROM usuarios');

    // Preparamos la salida. Dibujamos una tabla con los datos de la consulta.
    print "<table border=1>";
    print "<tr><td>Usuario</td><td>Email</td><td>Clave</td></tr>";

    // Con un ciclo foreach recorremos la variable $result y obtenemos las
    // columnas de la tabla.
    foreach ($result as $row) {
        print "<tr><td>" . $row['Nombre'] . "</td>";
        print "<td>" . $row['email'] . "</td>";
        print "<td>" . $row['clave'] . "</td></tr>";
    }

    // Cerramos la tabla.
    print "</table>";

    // Eliminamos la tabla.
    $db->exec("DROP TABLE usuarios");

    // Cerramos la conexion a la base de datos.
    $db = NULL;
} catch (PDOException $e) {
    print 'Excepción : ' . $e->getMessage();
}
?>