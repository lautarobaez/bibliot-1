<?php
include("libreria/motor.php");
include_once("libreria/libro_impreso.php");
session_start();
$str_b =  $_POST['b'];
$lib=Libro_impreso::buscar($objConexion->enlace,$str_b);
?>
<?php
if (isset($lib) && count($lib)>0){
?>
<div class="panel panel-default">
  <div class="panel-heading">Material impreso encontrado</div> 
  <div style="overflow: scroll;height: 350px;">  
      <table class="tabla_edicion table table-hover">
          <thead>
              <tr>
                  <th>Código</th>
                  <th>Título</th>
                  <th>Autor</th>
                  <th>Disponible</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
          <?php
              foreach($lib as $libros){
                echo "<tr>";
                echo "<td>$libros[codigo_interno]</td>";
                echo "<td>$libros[titulo]</td>";
                echo "<td>$libros[autor]</td>";
                echo "<td>$libros[stock_disponible] / $libros[stock_total]</td>";
                if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
                    echo '<td><button class="btn btn-primary btn-xs" onclick="editar_impreso(' . $libros['id_impreso'] . ')" >Editar</button></td>';
                    echo '<td><button class="btn btn-danger btn-xs" onclick="borrar_impreso(' . $libros['id_impreso'] . ')" >Borrar</button></td>';
                }else{
                    echo '<td><button class="btn btn-info btn-xs" onclick="ver_impreso(' . $libros['id_impreso'] . ')" >Info</button></td>';
                }
                echo "</tr>";
              }
          ?>
          </tbody>
      </table>
  </div>
</div>
<?php
}else{
    echo '<div class="alert alert-info">No se encontraron resultados</div>';
}
?>


