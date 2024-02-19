<?php

include 'db_connect.php';

// Obtener los datos del formulario
$asistencia = $_POST['asistencia'];
$nombre = $asistencia === 'si' ? $_POST['nombreSi'] : $_POST['nombreNo'];
$telefono = $asistencia === 'si' ? $_POST['telefonoSi'] : $_POST['telefonoNo'];
$email = $asistencia === 'si' ? $_POST['emailSi'] : $_POST['emailNo'];
$acompanante = isset($_POST['acompanante']) ? $_POST['nombre-acompanante'] : null;
$alergias = isset($_POST['alergias']) ? $_POST['alergias'] : null;
$comentarios = isset($_POST['comentarios']) ? $_POST['comentarios'] : null;

// Preparar la consulta SQL
$sql = "INSERT INTO invitaciones (asistencia, nombre, telefono, email, acompanante, alergias, comentarios) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $asistencia, $nombre, $telefono, $email, $acompanante, $alergias, $comentarios);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo "Registro guardado exitosamente";
    // Enviar correo electrónico
    $serverDomain = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'];
    $to = $email;
    $subject = 'Nuevo registro de asistencia';
    $message = "Asistencia: $asistencia\nNombre: $nombre\nTeléfono: $telefono\nEmail: $email\nAcompañante: $acompanante\nAlergias: $alergias\nComentarios: $comentarios";
    $headers = 'From: webmaster@' . "\r\n" .
               'Reply-To: webmaster@$serverDomain' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    mail($to, $subject, $message, $headers);

} else {
    echo "Error: " . $stmt->error;
} 

// Cerrar conexión
$stmt->close();
$conn->close();
?>