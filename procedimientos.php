<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
</head>

<body>

    <?php
     include('conexion/conexionDB.php');
     require_once('conexion/conexionDB.php');

    // SET NOCOUNT ON;
    // SET NOCOUNT OFF; 

    // $funcionalidad_qr=$_POST['funcionalidad_qr'];
    // if($accion){
    $result = $_POST['result'];
    $cedula = $_POST['cedula'];
    $imei = $_POST['celular'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $sentencia = "SET NOCOUNT ON; exec faros.dbo.sp_nodejs_conexion_SP 'funcionalidad_qr', '$result', '$cedula', '$imei', '$latitud','$longitud' ";
    $sentencia= $pdo->query($sentencia);

    // print $query;
    while ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
        //    print_r($row); 
        $var = $row;
    }
    
    ?> 
    <script>
    
        var x = '<?php echo json_encode($var); ?>';
    </script>
 <a  href="index.php">volver</a>
<link rel="stylesheet">
    <script src="./script.js"></script>

</body>

</html>