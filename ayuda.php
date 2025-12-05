<?php
include("menu_bs.php");
echo '
<div class="container-fluid" id="capa_T">
  <div class="row">
    <div class="col-sm-12">
      <div id="capa_C">
        <h3>Cartelera de Ayuda</h3>
      </div>
    </div>
  </div>
</div>';
echo "<script>";
echo "cargar('#capa_C','mostrar_cartelera.php?b=Ayuda');";
echo "</script>";
?>


<div style="
    border: 2px solid #28a745;
    background-color: #e9fbe8;
    padding: 20px;
    border-radius: 10px;
    font-family: Arial, sans-serif;
    color: #155724;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
">
    <h4 style="color: #218838;"><i class="fas fa-info-circle"></i> ¿Cómo utilizar la biblioteca?</h4>
    <ul style="padding-left: 20px;">
        <li>Usá el menú superior para navegar entre las secciones disponibles.</li>
        <li>En <strong>Cartelera</strong> encontrarás novedades y comunicados importantes.</li>
        <li>En <strong>Libros</strong> podés consultar y gestionar el material impreso.</li>
        <li>La sección <strong>Publicaciones Digitales</strong> contiene documentos, audios y videos.</li>
    </ul>
    <p>Si tenés dudas, podés comunicarte con el administrador desde la sección <strong>Contacto</strong>.</p>
</div>
