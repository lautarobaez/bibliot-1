<?php
include_once("libreria/motor.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $autor = mysqli_real_escape_string($con, $_POST['autor']);
    $titulo = mysqli_real_escape_string($con, $_POST['titulo']);
    $edicion = mysqli_real_escape_string($con, $_POST['edicion']);
    $anio = mysqli_real_escape_string($con, $_POST['anio']);
    $origen = mysqli_real_escape_string($con, $_POST['origen']);
    $area = mysqli_real_escape_string($con, $_POST['area']);
    $materia = mysqli_real_escape_string($con, $_POST['materia']);
    $comentario = mysqli_real_escape_string($con, $_POST['comentario']);
    $archivo = mysqli_real_escape_string($con, $_POST['archivo']); // si no hay carga real de archivo, podés dejarlo como texto
    $tipo = 'impreso';
    $estado = 'disponible';

    $query = "INSERT INTO libros_d (Autor, Titulo, edicion, año, origen, Area, Materia, Comentario, Archivo, tipo, estado)
              VALUES ('$autor', '$titulo', '$edicion', '$anio', '$origen', '$area', '$materia', '$comentario', '$archivo', '$tipo', '$estado')";

    if (mysqli_query($con, $query)) {
        $mensaje = "✅ Libro impreso cargado correctamente.";
    } else {
        $mensaje = "❌ Error al cargar el libro: " . mysqli_error($con);
    }
}
?>

<h2>Cargar Libro Impreso</h2>

<?php if ($mensaje) echo "<p><strong>$mensaje</strong></p>"; ?>

<form method="POST">
    <label>Autor:</label><br>
    <input type="text" name="autor" required><br><br>

    <label>Título:</label><br>
    <input type="text" name="titulo" required><br><br>

    <label>Edición:</label><br>
    <input type="text" name="edicion" required><br><br>

    <label>Año:</label><br>
    <input type="text" name="anio" required><br><br>

    <label>Origen:</label><br>
    <input type="text" name="origen" required><br><br>

    <label>Área:</label><br>
    <input type="text" name="area" required><br><br>

    <label>Materia:</label><br>
    <input type="text" name="materia" required><br><br>

    <label>Comentario:</label><br>
    <input type="text" name="comentario"><br><br>

    <label>Archivo (nombre del archivo PDF si aplica):</label><br>
    <input type="text" name="archivo"><br><br>

    <input type="submit" value="Cargar Libro Impreso">
</form>

<br><a href="libros_imp.php">← Volver a Libros Impresos</a>
