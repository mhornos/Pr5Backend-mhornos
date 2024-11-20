<?php
// Constants referents a la base de dades
define("DB_HOST", "bbdd.eldomini.cat");
define("DB_NAME", "ddb237xxx");
define("DB_DSN", sprintf('mysql:host=%s;dbname=%s', DB_HOST, DB_NAME));
define("DB_USER", "ddb237xxx");
define("DB_PASSWORD", "vostre_psw");  //psw que us proporciona dondominio >> Hosting y Correo > Base de datos > desplegar menu phpmyadmin (3 botons verticals) > Editar > Generar contrasenya
define("DB_ERROR_MSG", "No es pot establir connexió amb la base de dades");
?>