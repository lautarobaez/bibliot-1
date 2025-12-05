<?php
include_once("libreria/motor.php");
include_once("libreria/prestamo_material.php");

$mensaje = '';

if (!empty($_POST)) {
    $accion = isset($_POST['accion']) ? $_POST['accion'] : '';
    if ($accion == 'registrar'){
        $prestamo = new Prestamo_material();
        $prestamo->id_libro_impreso = $_POST['selLibro'];
        $prestamo->id_persona = $_POST['selPersona'];
        $prestamo->fecha_prestamo = $_POST['txtFechaPrestamo'];
        $prestamo->fecha_vencimiento = $_POST['txtFechaVencimiento'];
        $prestamo->observaciones = $_POST['txtObservaciones'];
        $resultado = $prestamo->registrar($objConexion->enlace);
        if ($resultado){
            $mensaje = '<div class="alert alert-success">Préstamo registrado correctamente.</div>';
        }else{
            $mensaje = '<div class="alert alert-danger">No hay stock disponible para el material seleccionado.</div>';
        }
    }
}

$personas = mysqli_query($objConexion->enlace, "SELECT id, nombre, apellido FROM personas ORDER BY apellido");
$libros = Libro_impreso::mostrar_disponibles($objConexion->enlace);

include("menu_bs.php");
?>
<script src="bootstrap/js/funciones_prestamo.js"></script>

<div class="container-fluid">
    <nav class="navbar navbar-default " role="navigation" >
        <ul class="nav navbar-nav" style="padding-top: 10px;padding-bottom: 0px;">
            <span style="padding-right: 20px;font-weight: bold;">Gestión de préstamos</span>
        </ul>
        <ul class="nav navbar-nav" style="padding-top: 10px;padding-bottom: 0px;">
            <input type="text"  id="txt_b_prestamo" placeholder="Buscar préstamo" style="position: absolute;right: 100px;" >
            <button type="button" id="btn_b_prestamo" class="btn btn-primary btn-sm" style="position: absolute;right: 20px;">Buscar</button>
        </ul>
    </nav>
</div>

<div class="container">
    <?php echo $mensaje; ?>
    <div id="mensaje_prestamo_ajax"></div>
    <div class="row">
        <div class="col-sm-5">
            <div class="panel panel-default">
                <div class="panel-heading">Nuevo préstamo</div>
                <div class="panel-body">
                    <form method="POST" action="">
                        <input type="hidden" name="accion" value="registrar">
                        <div class="form-group">
                            <label>Socio</label>
                            <select class="form-control" name="selPersona" required>
                                <option value="">Seleccione socio</option>
                                <?php 
                                if ($personas){
                                    while($p = mysqli_fetch_assoc($personas)){
                                        echo '<option value="'.$p['id'].'">'.$p['apellido'].', '.$p['nombre'].'</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Material</label>
                            <select class="form-control" name="selLibro" required>
                                <option value="">Seleccione material</option>
                                <?php 
                                if ($libros){
                                    foreach($libros as $libro){
                                        echo '<option value="'.$libro['id_impreso'].'">'.$libro['titulo'].' ('.$libro['codigo_interno'].')</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Fecha préstamo</label>
                            <input type="date" class="form-control" name="txtFechaPrestamo" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Fecha devolución</label>
                            <input type="date" class="form-control" name="txtFechaVencimiento" value="<?php echo date('Y-m-d', strtotime('+7 day')); ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Observaciones</label>
                            <input type="text" class="form-control" name="txtObservaciones" placeholder="Notas">
                        </div>
                        <button type="submit" class="btn btn-primary">Registrar</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div id="capa_lista_prestamos"></div>
        </div>
    </div>
</div>
</body>
</html>

