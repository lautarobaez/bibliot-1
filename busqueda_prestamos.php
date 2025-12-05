<?php
include("libreria/motor.php");
include_once("libreria/prestamo_material.php");
session_start();

$str_b = isset($_POST['b']) ? $_POST['b'] : '';
$estado = isset($_POST['estado']) ? $_POST['estado'] : '';
$prestamos = Prestamo_material::buscar($objConexion->enlace,$str_b,$estado);
?>
<?php
if (isset($prestamos) && count($prestamos)>0){
?>
<div class="panel panel-default">
  <div class="panel-heading">Préstamos encontrados</div> 
  <div style="overflow: scroll;height: 350px;">  
      <table class="tabla_edicion table table-hover">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Socio</th>
                  <th>Material</th>
                  <th>Retiro</th>
                  <th>Vencimiento</th>
                  <th>Estado</th>
                  <th></th>
              </tr>
          </thead>
          <tbody>
          <?php
              foreach($prestamos as $item){
                echo "<tr>";
                echo "<td>$item[id_prestamo]</td>";
                echo "<td>$item[apellido], $item[nombre]</td>";
                echo "<td>$item[titulo] ($item[codigo_interno])</td>";
                echo "<td>$item[fecha_prestamo]</td>";
                echo "<td>$item[fecha_vencimiento]</td>";
                echo "<td>$item[estado]</td>";
                if (isset($_SESSION['username']) && $_SESSION['rol']=='administrador'){
                    if ($item['estado'] != 'devuelto'){
                        echo '<td><button class="btn btn-success btn-xs" onclick="devolver_prestamo(' . $item['id_prestamo'] . ')" >Registrar devolución</button></td>';
                    }else{
                        echo '<td>-</td>';
                    }
                }else{
                    echo '<td>-</td>';
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
    echo '<div class="alert alert-info">No se encontraron préstamos</div>';
}
?>


