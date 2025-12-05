<?php
include_once("libreria/motor.php");
include_once("libreria/libro_impreso.php");

$libro_impreso = new Libro_impreso();

if (!empty($_POST)) {
    $libro_impreso->autor=$_POST['txtAutor'];
    $libro_impreso->titulo=$_POST['txtTitulo'];
    $libro_impreso->edicion=$_POST['txtEdicion'];
    $libro_impreso->anio=$_POST['txtAnio'];
    $libro_impreso->origen=$_POST['txtOrigen'];
    $libro_impreso->tipo=$_POST['txtTipo'];
    $libro_impreso->area=$_POST['txtArea'];
    $libro_impreso->materia=$_POST['txtMateria'];
    $libro_impreso->comentario=$_POST['txtComentario'];
    $libro_impreso->codigo_interno=$_POST['txtCodigo'];
    $libro_impreso->ubicacion=$_POST['txtUbicacion'];
    $libro_impreso->stock_total=$_POST['txtStockTotal'];
    $libro_impreso->stock_disponible=$_POST['txtStockDisponible'];
    $libro_impreso->estado=$_POST['txtEstado'];
    $libro_impreso->guardar($objConexion->enlace);
}
?>

<div class="container">
<div class="row">
  <div class="col-sm-12">
  <div id="capa_impreso">
    <form role="form" method="POST" action="">
      <legend>Registro de material impreso</legend>
      <div class="row">
        <div class="form-group">
            <div class="col-xs-6">
                <label>Autor</label>
                <input type="text" name="txtAutor" class="form-control" placeholder="Autor">
            </div>
            <div class="col-xs-6">
                <label>Título</label>
                <input type="text" name="txtTitulo" class="form-control" placeholder="Título del material">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-4">
                <label>Edición</label>
                <input type="text" name="txtEdicion" class="form-control" placeholder="Edición">
            </div>
            <div class="col-xs-4">
                <label>Idioma / Origen</label>
                <input type="text" name="txtOrigen" class="form-control" placeholder="Idioma">
            </div>
            <div class="col-xs-4">
                <label>Año</label>
                <input type="text" name="txtAnio" class="form-control" placeholder="Año de publicación">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-4">
                <label>Tipo</label>
                <select class="form-control" name="txtTipo">
                    <option>Libro</option>
                    <option>Revista</option>
                    <option>Guía</option>
                    <option>Material de referencia</option>
                </select>
            </div>
            <div class="col-xs-4">
                <label>Área</label>
                <input type="text" name="txtArea" class="form-control" placeholder="Área temática">
            </div>
            <div class="col-xs-4">
                <label>Materia</label>
                <input type="text" name="txtMateria" class="form-control" placeholder="Materia">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-6">
                <label>Código interno</label>
                <input type="text" name="txtCodigo" class="form-control" placeholder="Ej: IMP-0004">
            </div>
            <div class="col-xs-6">
                <label>Ubicación</label>
                <input type="text" name="txtUbicacion" class="form-control" placeholder="Estantería / sala">
            </div>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
            <div class="col-xs-4">
                <label>Stock total</label>
                <input type="number" name="txtStockTotal" class="form-control" min="0" value="1">
            </div>
            <div class="col-xs-4">
                <label>Disponible</label>
                <input type="number" name="txtStockDisponible" class="form-control" min="0" value="1">
            </div>
            <div class="col-xs-4">
                <label>Estado</label>
                <select class="form-control" name="txtEstado">
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
                <input type="text" name="txtComentario" class="form-control" placeholder="Notas adicionales">
            </div>
        </div>
      </div>

      <button method="post" type="submit" class="btn btn-default">Agregar</button>
    </form>
  </div>
  </div>
</div>
</div>


