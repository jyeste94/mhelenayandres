<?php

include 'db_connect.php';

// Obtener los datos del formulario
$asistencia = $_POST['asistencia'];
$nombre = $asistencia === 'si' ? $_POST['nombreSi'] : $_POST['nombreNo'];
$telefono = $asistencia === 'si' ? $_POST['telefonoSi'] : $_POST['telefonoNo'];
$email = $asistencia === 'si' ? $_POST['emailSi'] : $_POST['emailNo'];
$acompanante = isset($_POST['acompanante']) ? $_POST['nombre-acompanante'] : null;
$alergias = $_POST['alergias'] ?? null;
$comentarios = $_POST['comentarios'] ?? null;
$opcion_principal = $_POST['opcion_principal'] ?? null;

if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else if (isset($_SERVER['HTTP_X_REAL_IP'])) {
    $ip = $_SERVER['HTTP_X_REAL_IP'];
} else {
    // Utiliza REMOTE_ADDR si no hay cabeceras del proxy
    $ip = $_SERVER['REMOTE_ADDR'];
}


// Preparar la consulta SQL
$sql = "INSERT INTO andresymalena (asistencia, nombre, telefono, email, acompanante, alergias, comentarios, opcion_principal, ip) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssss", $asistencia, $nombre, $telefono, $email, $acompanante, $alergias, $comentarios, $opcion_principal, $ip);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Registro guardado exitosamente";

} else {
    echo "Error: " . $stmt->error;
}

// Cerrar conexión
$stmt->close();
$conn->close();
?>