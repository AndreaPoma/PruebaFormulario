<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "formulario_fs";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: ". $conn->connect_error);
}

// Recibir datos del formulario
$nombres = $_POST['nomb'];
$apellidos = $_POST['ape'];
$dni = $_POST['dniEstu'];
$imagen = $_FILES['image'];
$edad = $_POST['edades'];

// Mover la imagen a una carpeta temporal
$target_dir = "BoletasEstudiantes/";
$target_file = $target_dir. basename($imagen["name"]);
move_uploaded_file($imagen["tmp_name"], $target_file);

// Convertir la imagen a base64
$image_base64 = base64_encode(file_get_contents($target_file));

// Insertar datos en la base de datos
$sql = "INSERT INTO estudiantes (nombres, apellidos, DNI, boletas, edad) VALUES ('$nombres', '$apellidos', '$dni', '$image_base64', '$edad')";

if ($conn->query($sql) === TRUE) {
  echo "Registro exitoso";
  header("Location: exito.html");
exit();
} else {
  echo "Error: ". $sql. "<br>". $conn->error;
}

$conn->close();
?>