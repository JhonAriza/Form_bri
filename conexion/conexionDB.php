
 <?php
$servidor2 = "192.168.0.31";
$usuario2 = "soportehelios";
$contrasena = "0nc0r19$";
$database = "faros";

try{
    $pdo2 = new PDO("sqlsrv:server=$servidor2;database=$database", $usuario2, $contrasena);
    $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexion exitosa a la base de datos  de faros produccion";
}catch(Exception $e){
    echo "No se a podido conectar con la base de datos".$e->getMessage();
}
?>