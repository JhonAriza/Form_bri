<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
</head>
<body>
    
</body>
</html>
<?php

include('conexion/conexion.php');

$usuario = $_POST['usuario'];
$contraseña = $_POST['contraseña'];
session_start();

$_SESSION['usuario'] = $usuario;

$conexion = mysqli_connect("localhost", "root", "", "brinsa_formulario");

$consulta = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND contraseña = '$contraseña'";
$resultado = mysqli_query($conexion, $consulta);

if ($resultado) {
    $rol = $resultado->fetch_object();
    $_SESSION['rol'] = $rol->admin;
}

$filas = mysqli_num_rows($resultado);

if ($filas) {
    header("location:index.php");
} else {
    echo '<script>alert(\'Las credenciales ingresadas son incorrectas\')</script>';
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=login.php'>";
    // header('location:login.php');
}

mysqli_free_result($resultado);
mysqli_close($conexion);
