<?php
$servername = "localhost";
$username = "root";
$password = "tamara11";
$dbname = "Skila";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Configurar el encabezado de respuesta como JSON
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Leer la entrada JSON
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Asignar los valores del JSON a variables
    $name_user = $input['nombre'] ?? '';
    $apellidoPat = $input['apellidoPat'] ?? '';
    $apellidoMar = $input['apellidoMar'] ?? '';
    $tipoSangre = $input['tipoSangre'] ?? '';
    $lateralidad = $input['lateralidad'] ?? '';
    $enfermedades = $input['enfermedades'] ?? '';
    $sexo = $input['sexo'] ?? '';
    $edad = $input['edad'] ?? '';
    $peso = $input['peso'] ?? '';
    $altura = $input['altura'] ?? '';

    // Preparar y ejecutar la declaración SQL
    $stmt = $conn->prepare("INSERT INTO deportistas (name_user, apellidoPat, apellidoMar, tipoSangre, lateralidad, enfermedades, sexo, edad, peso, altura) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $name_user, $apellidoPat, $apellidoMar, $tipoSangre, $lateralidad, $enfermedades, $sexo, $edad, $peso, $altura);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Nuevo atleta agregado correctamente"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Atleta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-3 mb-4">Agregar Nuevo Atleta</h1>
        <form method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="edad" class="form-label">Edad:</label>
                <input type="number" class="form-control" id="edad" name="edad" required>
            </div>
            <div class="mb-3">
                <label for="categoria" class="form-label">Categoría:</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Atleta</button>
        </form>
    </div>
</body>
</html>