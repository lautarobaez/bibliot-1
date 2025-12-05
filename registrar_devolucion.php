<?php
include_once("libreria/motor.php");

// Mensaje de resultado
$mensaje = "";

// Procesar devolución
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_prestamo = intval($_POST['id_prestamo']);
    $fecha_devolucion = mysqli_real_escape_string($con, $_POST['fecha_devolucion']); // usar $con

    // Actualizar la fecha de devolución
    $update = "UPDATE prestamos SET fecha_devolucion = '$fecha_devolucion' WHERE id_prestamo = $id_prestamo";
    if (mysqli_query($con, $update)) {
        // Obtener id_libro del préstamo
        $result = mysqli_query($con, "SELECT id_libro FROM prestamos WHERE id_prestamo = $id_prestamo");
        if ($row = mysqli_fetch_assoc($result)) {
            $id_libro = $row['id_libro'];

            // Cambiar estado del libro a 'disponible'
            mysqli_query($con, "UPDATE libros_d SET estado = 'disponible' WHERE id_libro = $id_libro");

            $mensaje = "✅ Devolución registrada correctamente.";
        } else {
            $mensaje = "❌ No se encontró el préstamo.";
        }
    } else {
        $mensaje = "❌ Error al registrar devolución: " . mysqli_error($con);
    }
}

// Obtener préstamos sin devolver
$query = "
    SELECT p.id_prestamo, l.id_libro, l.Titulo, per.nombre, per.apellido, p.fecha_prestamo
    FROM prestamos p
    JOIN libros_d l ON p.id_libro = l.id_libro
    JOIN personas per ON p.id_persona = per.id
    WHERE p.fecha_devolucion IS NULL
";

$result = mysqli_query($con, $query);
?>

<h2>Registrar Devolución</h2>

<?php if ($mensaje) echo "<p><strong>$mensaje</strong></p>"; ?>

<?php if (mysqli_num_rows($result) > 0): ?>
    <form method="POST">
        <label>Préstamo a Devolver:</label><br>
        <select name="id_prestamo" required>
            <?php while ($row = mysqli_fetch_assoc($result)) {
                $label = "{$row['Titulo']} - {$row['nombre']} {$row['apellido']} (prestado el {$row['fecha_prestamo']})";
                echo "<option value='{$row['id_prestamo']}'>{$label}</option>";
            } ?>
        </select><br><br>

        <label>Fecha de Devolución:</label><br>
        <input type="date" name="fecha_devolucion" required><br><br>

        <input type="submit" value="Registrar Devolución">
    </form>
<?php else: ?>
    <p>No hay préstamos pendientes de devolución.</p>
<?php endif; ?>

<br><a href="libros_imp.php">← Volver a Libros Impresos</a>

