<?php
include 'db_connect.php';

$registros_por_pagina = 15;

$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($pagina_actual - 1) * $registros_por_pagina;


// Consulta SQL para obtener los datos de la tabla 'invitaciones'
$sql = "SELECT asistencia, nombre, telefono, email, acompanante, alergias, comentarios FROM `javieryiris`  LIMIT $offset, $registros_por_pagina";
$result = $conn->query($sql);


$sql_total = "SELECT COUNT(*) FROM javieryiris";
$result_total = $conn->query($sql_total);
$total_registros = $result_total->fetch_row()[0];
$total_paginas = ceil($total_registros / $registros_por_pagina);


// Preparar los datos para la tabla HTML
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    echo "No hay resultados para mostrar.";
}

// Cerrar la conexión
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Invitaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-3 mb-3">
    <h2>Lista de Invitaciones</h2>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Asistencia</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Email</th>
                <th>Acompañante</th>
                <th>Alergias</th>
                <th>Comentarios</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $row): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['asistencia']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['acompanante']); ?></td>
                    <td><?php echo htmlspecialchars($row['alergias']); ?></td>
                    <td><?php echo htmlspecialchars($row['comentarios']); ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <?php for ($pagina = 1; $pagina <= $total_paginas; $pagina++): ?>
                    <li class="page-item <?php echo $pagina == $pagina_actual ? 'active' : ''; ?>">
                        <a class="page-link" href="?pagina=<?php echo $pagina; ?>">
                            <?php echo $pagina; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <form method="POST" action="download_csv.php">
        <button type="submit" class="btn btn-primary btn-lg btn-block">Descargar CSV</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>