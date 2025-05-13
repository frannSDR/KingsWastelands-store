<?php
// Verificamos si el formulario fue enviado

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtenemos los datos del formulario
    $email = $_POST["email"];
    $nombre = $_POST["nombre"];
    $contraseña = $_POST["contraseña"];
    $repetir = $_POST["repetir"];

    // Validamos que las contraseñas coincidan
    if ($contraseña !== $repetir) {
        echo "Las contraseñas no coniciden";
        exit;
    }

    // Hasheamos la contraseña (por medida de seguridad)
    $contraseña_hash = password_hash($contraseña, PASSWORD_DEFAULT);

    // Conectamos a la base de datos
    $conexion = new mysqli("localhost", "root", "", "KingsWastelands-store");

    if ($conexion->connect_error) {
        die("Error de conexion: " . $conexion->connect_error);
    }

    // Verificamos que el mail no este registrado
    $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verificar->bind_param("s", $email);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        echo "Este corre ya esta registrado.";
    } else {
        // Insertamos nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, email, contraseña) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $email, $contraseña_hash);

        if ($stmt->execute()) {
            echo "Registro exitoso. Ya podes iniciar sesion.";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $verificar->close();
    $conexion->close();
}
