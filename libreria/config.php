<?php
// Datos de conexión a la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Usar '' si estás en XAMPP por defecto
define('DB_NAME', 'biblio-t1');

// Conexión con MySQLi
$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Verificación de conexión
if ($con->connect_error) {
    die("Error de conexión: " . $con->connect_error);
}

// Función para formatear la hora del chat
function formatDate($date){
    return date('g:i a', strtotime($date));
}

// Nombre de la sesión
$usuarios_sesion = "pwd";

// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
