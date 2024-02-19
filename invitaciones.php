<?php
include 'db_connect.php';

// Consulta SQL para obtener los datos de la tabla 'invitaciones'
$sql = "SELECT * FROM invitaciones";
$result = $conn->query($sql);

// Abrir el archivo CSV para escritura
$filename = "export_invitaciones.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="'.$filename.'"');

$fp = fopen('php://output', 'w');

// Opcional: Encabezados de las columnas
$headers = ['asistencia','nombre','telefono','email','acompanante','alergias','comentarios']; // Aquí debes agregar los nombres de las columnas
fputcsv($fp, $headers);

// Recorrer los resultados y escribir en el archivo CSV
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        fputcsv($fp, $row);
    }
} else {
    echo "0 results";
}

fclose($fp);

// Cerrar la conexión
$conn->close();
?>