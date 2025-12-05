<?php
include("libreria/motor.php");
include_once("libreria/libro_impreso.php");

$libro = new Libro_impreso();

$operacion = '';
$id_impreso = '';
$autor = '';
$titulo = '';
$edicion = '';
$anio = '';
$origen = '';
$tipo = '';
$area = '';
$materia = '';
$comentario = '';
$codigo = '';
$ubicacion = '';
$stock_total = 0;
$stock_disponible = 0;
$estado = 'activo';

if (!empty($_POST)) {
    $operacion = isset($_POST['operacion']) ? $_POST['operacion'] : 'actualizar' ;

    if ($operacion == 'edicion' || $operacion == 'ver'){
        $id=$_POST['id_imp'];
        $A=Libro_impreso::traer_datos($objConexion->enlace,$id);
        if ($A){
            $autor=$A['autor'];
            $titulo=$A['titulo'];
            $edicion=$A['edicion'];
            $anio=$A['anio_publicacion'];
            $origen=$A['origen'];
            $tipo=$A['tipo'];
            $area=$A['area'];
            $materia=$A['materia'];
            $comentario=$A['comentario'];
            $codigo=$A['codigo_interno'];
            $ubicacion=$A['ubicacion'];
            $stock_total=$A['stock_total'];
            $stock_disponible=$A['stock_disponible'];
            $estado=$A['estado'];
        }

        $accion=$_SERVER['HTTP_REFERER'].'?operacion=actualizar&id_imp='. $id;
        $btn_txt='Actualizar';
        $leyenda='Modificar datos ';
        if ($operacion == 'ver'){
            $leyenda='Datos del material ';
        }
    }

    if ($operacion == 'baja'){
        $id=$_POST['id_imp'];
        $A=Libro_impreso::traer_datos($objConexion->enlace,$id);
        if ($A){
            $autor=$A['autor'];
            $titulo=$A['titulo'];
            $edicion=$A['edicion'];
            $anio=$A['anio_publicacion'];
            $origen=$A['origen'];
            $tipo=$A['tipo'];
            $area=$A['area'];
            $materia=$A['materia'];
            $comentario=$A['comentario'];
            $codigo=$A['codigo_interno'];
            $ubicacion=$A['ubicacion'];
            $stock_total=$A['stock_total'];
            $stock_disponible=$A['stock_disponible'];
            $estado=$A['estado'];
        }
        $accion=$_SERVER['HTTP_REFERER'].'?operacion=borrar&id_imp='. $id;
        $btn_txt='Borrar';
        $leyenda='Eliminar material';
    }
}
?>

<div class="container">
<div class="row">
  <div class="col-sm-12">
    <form role="form" method="POST" action="<?php echo $accion;?>">
      <legend><?php echo $leyenda;?></legend>
      <?php 
        if (isset($operacion) && ($operacion == 'edicion' || $operacion == 'baja' )) {
            echo '<label for="id_impreso" >ID:</label>';
            echo '<input id="id_imp" name="id_imp" type="text" class="form-control" disabled value="'.$id.'" />';
        }
      ?> 

      <div class="row">
        <div class="form-group">
            <div class="col-xs-6">
                <label>Autor</label>
                <input type="text" name="txtAutor" class="form-control" value="<?php echo $autor; ?>">
            </div>
            <div class="col-xs-6">
                <label>Título</label>
                <input type="text" name="txtTitulo" class="form-control" value="<?php echo $titulo; ?>">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-4">
                <label>Edición</label>
                <input type="text" name="txtEdicion" class="form-control" value="<?php echo $edicion; ?>">
            </div>
            <div class="col-xs-4">
                <label>Idioma / Origen</label>
                <input type="text" name="txtOrigen" class="form-control" value="<?php echo $origen; ?>">
            </div>
            <div class="col-xs-4">
                <label>Año</label>
                <input type="text" name="txtAnio" class="form-control" value="<?php echo $anio; ?>">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-4">
                <label>Tipo</label>
                <select class="form-control" name="txtTipo">
                    <option><?php echo $tipo; ?></option>
                    <option>Libro</option>
                    <option>Revista</option>
                    <option>Guía</option>
                    <option>Material de referencia</option>
                </select>
            </div>
            <div class="col-xs-4">
                <label>Área</label>
                <input type="text" name="txtArea" class="form-control" value="<?php echo $area; ?>">
            </div>
            <div class="col-xs-4">
                <label>Materia</label>
                <input type="text" name="txtMateria" class="form-control" value="<?php echo $materia; ?>">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-6">
                <label>Código interno</label>
                <input type="text" name="txtCodigo" class="form-control" value="<?php echo $codigo; ?>">
            </div>
            <div class="col-xs-6">
                <label>Ubicación</label>
                <input type="text" name="txtUbicacion" class="form-control" value="<?php echo $ubicacion; ?>">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-4">
                <label>Stock total</label>
                <input type="number" name="txtStockTotal" class="form-control" value="<?php echo $stock_total; ?>">
            </div>
            <div class="col-xs-4">
                <label>Disponible</label>
                <input type="number" name="txtStockDisponible" class="form-control" value="<?php echo $stock_disponible; ?>">
            </div>
            <div class="col-xs-4">
                <label>Estado</label>
                <select class="form-control" name="txtEstado">
                    <option><?php echo $estado; ?></option>
                    <option value="activo">Activo</option>
                    <option value="baja">Baja</option>
                    <option value="mantenimiento">Mantenimiento</option>
                </select>
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-12">
                <label>Comentario</label>
                <input type="text" name="txtComentario" class="form-control" value="<?php echo $comentario; ?>">
            </div>
        </div>
      </div>

      <?php
        if ($operacion != 'ver'){
            echo '<button method="post" type="submit" class="btn btn-default">'.$btn_txt.'</button>';
        }
      ?>
    </form>
  </div>
</div>
</div>


