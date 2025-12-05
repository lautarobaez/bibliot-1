<?php 
require_once __DIR__ . '/config.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($con->connect_errno) {
    // detener ejecución si la conexión falla para evitar estados inconsistentes
    die('Error de conexión a MySQL: ' . $con->connect_error);
}

function formatDate($date){
	return date('g:i a', strtotime($date));
}
?>