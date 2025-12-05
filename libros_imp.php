<?php
include_once("libreria/motor.php");

// Obtener libros impresos
$resultado = mysqli_query($con, "SELECT * FROM libros_d WHERE tipo = 'impreso' ORDER BY estado DESC, Titulo ASC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Libros Impresos</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f7f7f7; padding: 20px; }
        table { width: 100%; border-collapse: collapse; background-color: white; }
        th, td { padding: 10px; border: 1px solid #ccc; text-align: left; }
        th { background-color: #333; color: white; }
        .disponible { color: green; font-weight: bold; }
        .prestado { color: red; font-weight: bold; }
        .botones { margin-top: 20px; }
        a.boton { padding: 8px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px; }
        a.boton:hover { background-color: #0056b3; }
    </style>
</head>
<body>

    <h2>📚 Libros Impresos</h2>

    <table>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Año</th>
            <th>Área</th>
            <th>Estado</th>
        </tr>
        <?php while($libro = mysqli_fetch_assoc($resultado)): ?>
            <tr>
                <td><?php echo htmlspecialchars($libro['Titulo']); ?></td>
                <td><?php echo htmlspecialchars($libro['Autor']); ?></td>
                <td><?php echo htmlspecialchars($libro['año']); ?></td>
                <td><?php echo htmlspecialchars($libro['Area']); ?></td>
                <td class="<?php echo $libro['estado'] == 'disponible' ? 'disponible' : 'prestado'; ?>">
                    <?php echo ucfirst($libro['estado']); ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <div class="botones">
        <a href="registrar_prestamo.php" class="boton">➕ Registrar Préstamo</a>
        <a href="registrar_devolucion.php" class="boton">🔁 Registrar Devolución</a>
    </div>

</body>
</html>
