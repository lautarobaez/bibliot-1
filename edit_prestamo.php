<?php
include("libreria/motor.php");
include_once("libreria/prestamo_material.php");

$operacion = isset($_POST['operacion']) ? $_POST['operacion'] : '';
$mensaje = '<div class="alert alert-warning">Operación no válida.</div>';

if ($operacion == 'devolver'){
    $id = isset($_POST['id_prestamo']) ? (int)$_POST['id_prestamo'] : 0;
    if ($id > 0){
        $resultado = Prestamo_material::devolver($objConexion->enlace, $id);
        if ($resultado){
            $mensaje = '<div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        Devolución registrada correctamente.
                        </div>';
        }else{
            $mensaje = '<div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        No fue posible registrar la devolución. El préstamo puede no existir o ya estar devuelto.
                        </div>';
        }
    }else{
        $mensaje = '<div class="alert alert-danger">Identificador de préstamo inválido.</div>';
    }
}

echo $mensaje;


