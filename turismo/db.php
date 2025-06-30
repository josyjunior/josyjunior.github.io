<?php
$host = "localhost"; // Corregido para XAMPP
$user = "root";
$pass = "";
$db = "turismo"; // Asegúrate de que esta base de datos exista en phpMyAdmin

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>