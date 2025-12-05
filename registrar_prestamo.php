<?php
include_once("libreria/motor.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_libro = intval($_POST['id_libro']);
    $id_persona = intval($_POST['id_persona']);
    $fecha_prestamo = mysqli_real_escape_string($con, $_POST['fecha_prestamo']);

    // Registrar el préstamo
    $query = "INSERT INTO prestamos (id_libro, id_persona, fecha_prestamo)
              VALUES ($id_libro, $id_persona, '$fecha_prestamo')";

    if (mysqli_query($conn, $query)) {
        // Cambiar estado del libro a "prestado"
        mysqli_query($conn, "UPDATE libros_d SET estado = 'prestado' WHERE id_libro = $id_libro");
        $mensaje = "✅ Préstamo registrado correctamente.";
    } else {
        $mensaje = "❌ Error al registrar el préstamo: " . mysqli_error($con);
    }
}

// Obtener libros disponibles
$libros = mysqli_query($con, "SELECT id_libro, Titulo FROM libros_d WHERE tipo = 'impreso' AND estado = 'disponible'");

// Obtener personas
$personas = mysqli_query($con, "SELECT id, nombre, apellido FROM personas");
?>

<h2>Registrar Préstamo</h2>

<?php if ($mensaje) echo "<p><strong>$mensaje</strong></p>"; ?>


