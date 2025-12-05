<?php
include_once("libreria/motor.php");
include_once("libreria/libro_impreso.php");

$datos = new Libro_impreso();
$libro_impreso = new Libro_impreso();

include("menu_bs.php");

$operacion = '';

if (!empty($_POST)) {
    $operacion = isset($_GET['operacion']) ? $_GET['operacion'] : 'alta' ;

    if ($operacion == 'alta' && !isset($_GET['id_imp'])) {
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
    if ($operacion == 'actualizar' && isset($_GET['id_imp'])) {
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

        $libro_impreso->actualizar($objConexion->enlace,$_GET['id_imp']);
        header("Location: ".$_SERVER['PHP_SELF']);
    }
    if ($operacion == 'borrar' && isset($_GET['id_imp'])) {
        $libro_impreso->borrar($objConexion->enlace,$_GET['id_imp']);
    }
}
?>
<script src="bootstrap/js/funciones_li.js"></script>

<div class="container-fluid">
   <nav class="navbar navbar-default " role="navigation" >
      <ul class="nav navbar-nav" style="padding-top: 10px;padding-bottom: 0px;">
          <span style="padding-right: 20px;font-weight: bold;">Material impreso</span>
          <?php 
            if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
                echo '<button type="button" class="btn btn-primary  btn-sm"   onclick="cargar(\'#capa_impreso\',\'alta_li.php\')">Alta</button>';
            }
          ?>
      </ul>

      <ul class="nav navbar-nav" style="padding-top: 10px;padding-bottom: 0px;">
        <input type="text"  id="txt_b_li" placeholder="Buscar" style="position: absolute;right: 100px;" >
        <button type="button" id="btn_b_li" class="btn btn-primary btn-sm" style="position: absolute;right: 20px;">Buscar</button>
      </ul>
   </nav>
</div>

<div class="row">
  <div class="col-sm-6">
      <div id="capa_impreso"></div>
  </div>
  <div class="col-sm-6">
      <div id="capa_lista_impreso"></div>
  </div>
</div>
</body>
</html>


