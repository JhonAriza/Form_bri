<?php

include('conexion/conexion.php');
include('conexion/conexionDB.php');

date_default_timezone_set('America/Bogota');

$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$radio_preg1 = (isset($_POST['radio_preg1'])) ? $_POST['radio_preg1'] : "";
$radio_preg2 = (isset($_POST['radio_preg2'])) ? $_POST['radio_preg2'] : "";
$radio_preg3 = (isset($_POST['radio_preg3'])) ? $_POST['radio_preg3'] : "";
$radio_preg4 = (isset($_POST['radio_preg4'])) ? $_POST['radio_preg4'] : "";
$radio_preg5 = (isset($_POST['radio_preg5'])) ? $_POST['radio_preg5'] : "";
$radio_preg6 = (isset($_POST['radio_preg6'])) ? $_POST['radio_preg6'] : "";
$radio_preg7 = (isset($_POST['radio_preg7'])) ? $_POST['radio_preg7'] : "";
$radio_preg8 = (isset($_POST['radio_preg8'])) ? $_POST['radio_preg8'] : "";
$cedula = (isset($_POST['cedula'])) ? $_POST['cedula'] : "";

$punto_recoleccion = (isset($_POST['punto_recoleccion'])) ? $_POST['punto_recoleccion'] : "";
$foto1 = (isset($_FILES['foto1']["name"])) ? $_FILES['foto1']["name"] : "";
$foto2 = (isset($_FILES['foto2']["name"])) ? $_FILES['foto2']["name"] : "";
$foto3 = (isset($_FILES['foto3']["name"])) ? $_FILES['foto3']["name"] : "";
$observaciones = (isset($_POST['observaciones'])) ? $_POST['observaciones'] : "";
$result = (isset($_POST['result'])) ? $_POST['result'] : "";
$latitud = (isset($_POST['latitud'])) ? $_POST['latitud'] : "";
$longitud = (isset($_POST['longitud'])) ? $_POST['longitud'] : "";
$celular = (isset($_POST['celular'])) ? $_POST['celular'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";


session_start();
if (!isset($_SESSION['usuario'])) {
    header('location: login.php');
}


// procedimiento almacenado
if ($accion) {
    $result = $_POST['result'];
    $cedula = $_POST['cedula'];
    $celular = $_POST['celular'];
    $latitud = $_POST['latitud'];
    $longitud = $_POST['longitud'];

    $sentencia = "SET NOCOUNT ON; exec faros.dbo.sp_nodejs_conexion_SP 'funcionalidad_qr', '$result', '$cedula', '$celular', '$latitud','$longitud' ";
    $sentencia = $pdo2->query($sentencia);

    //   print $query;
    if ($row = $sentencia->fetch(PDO::FETCH_ASSOC)) {
        // print_r($row);
        
          $var = $row;
        //   echo json_encode($row);
        //   echo  $row[""];
// aca se pasa la respuesta a un json y se valida para que no guarde todas las respuestas
        if ($row[""] === "RONDA CON QR GRABADA EXITOSAMENTE") {
// formulario para guardar
switch ($accion) {
    case "Agregar":

        $sentencia = $pdo->prepare("INSERT INTO tb_formularios(pregunta_1,pregunta_2,pregunta_3,pregunta_4,pregunta_5,pregunta_6,pregunta_7,pregunta_8,cedula,punto_recoleccion,foto1,foto2,foto3,observaciones,fecha,result,latitud,longitud,celular)
                    VALUES (:pregunta_1,:pregunta_2,:pregunta_3,:pregunta_4,:pregunta_5,:pregunta_6,:pregunta_7,:pregunta_8,:cedula,:punto_recoleccion,:foto1,:foto2,:foto3,:observaciones,:fecha,:result,:latitud,:longitud,:celular)");

        $sentencia->bindParam(':pregunta_1', $radio_preg1);
        $sentencia->bindParam(':pregunta_2', $radio_preg2);
        $sentencia->bindParam(':pregunta_3', $radio_preg3);
        $sentencia->bindParam(':pregunta_4', $radio_preg4);
        $sentencia->bindParam(':pregunta_5', $radio_preg5);
        $sentencia->bindParam(':pregunta_6', $radio_preg6);
        $sentencia->bindParam(':pregunta_7', $radio_preg7);
        $sentencia->bindParam(':pregunta_8', $radio_preg8);
        $sentencia->bindParam(':cedula', $cedula);

        $sentencia->bindParam(':punto_recoleccion', $punto_recoleccion);

        $Fecha = new DateTime();
        $nombreArchivo = ($foto1 != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto1"]["name"] : "perfil.png";
        $nombreArchivo2 = ($foto2 != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto2"]["name"] : "perfil.png";
        $nombreArchivo3 = ($foto3 != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto3"]["name"] : "perfil.png";

        $tmpFoto = $_FILES["foto1"]["tmp_name"];
        $tmpFoto2 = $_FILES["foto2"]["tmp_name"];
        $tmpFoto3 = $_FILES["foto3"]["tmp_name"];

        if ($tmpFoto != "" || $tmpFoto2 != "" ||  $tmpFoto3 != "") {

            move_uploaded_file($tmpFoto, "Imagenes/" . $nombreArchivo);
            move_uploaded_file($tmpFoto2, "Imagenes/" . $nombreArchivo2);
            move_uploaded_file($tmpFoto3, "Imagenes/" . $nombreArchivo3);
        }


        $date = new DateTime('now');
        $formatted = date('Y-m-d h:i:s a', $date->getTimestamp());

        $sentencia->bindParam(':foto1', $nombreArchivo);
        $sentencia->bindParam(':foto2', $nombreArchivo2);
        $sentencia->bindParam(':foto3', $nombreArchivo3);
        $sentencia->bindParam(':observaciones', $observaciones);
        $sentencia->bindParam(':fecha', $formatted);
        $sentencia->bindParam(':result', $result);
        $sentencia->bindParam(':latitud', $latitud);
        $sentencia->bindParam(':longitud', $longitud);
        $sentencia->bindParam(':celular', $celular);
        $sentencia->execute();

        // echo '<script>alert(\'Registrado con éxito\')</script>';
        // echo "<META HTTP-EQUIV='Refresh' CONTENT='0; url=index.php'>";


        //echo $radio_preg1;
        // echo "agregaste la primera pregunta";
        break;


    case "Modificar":

        echo "presionaste el boton modificar";

        $sentencia = $pdo->prepare("UPDATE tb_formularios SET 
        pregunta_1=:pregunta_1,
        pregunta_2=:pregunta_2,
        pregunta_3=:pregunta_3,
        pregunta_4=:pregunta_4,
        pregunta_5=:pregunta_5,
        pregunta_6=:pregunta_6,
        pregunta_7=:pregunta_7,
        pregunta_8=:pregunta_8,
        cedula=:cedula,
        punto_recoleccion=:punto_recoleccion,
        observaciones=:observaciones,
        result=:result,        
        latitud=:latitud,
        longitud=:longitud,
        celular=:celular
         WHERE id=:id");


        $sentencia->bindParam(':pregunta_1', $radio_preg1);
        $sentencia->bindParam(':pregunta_2', $radio_preg2);
        $sentencia->bindParam(':pregunta_3', $radio_preg3);
        $sentencia->bindParam(':pregunta_4', $radio_preg4);
        $sentencia->bindParam(':pregunta_5', $radio_preg5);
        $sentencia->bindParam(':pregunta_6', $radio_preg6);
        $sentencia->bindParam(':pregunta_7', $radio_preg7);
        $sentencia->bindParam(':pregunta_8', $radio_preg8);
        $sentencia->bindParam(':cedula', $cedula);
        $sentencia->bindParam(':punto_recoleccion', $punto_recoleccion);
        $sentencia->bindParam(':observaciones', $observaciones);
        $sentencia->bindParam(':result', $result);
        $sentencia->bindParam(':latitud', $latitud);
        $sentencia->bindParam(':longitud', $longitud);
        $sentencia->bindParam(':celular', $celular);
        $sentencia->execute();
        $sentencia->bindParam(':id', $id);

        $sentencia->execute();

        $Fecha = new DateTime();
        $nombreArchivo = ($foto1 != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto1"]["name"] : "perfil.png";
        $nombreArchivo2 = ($foto2 != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto2"]["name"] : "perfil.png";
        $nombreArchivo3 = ($foto3 != "") ? $Fecha->getTimestamp() . "_" . $_FILES["foto3"]["name"] : "perfil.png";

        $tmpFoto = $_FILES["foto1"]["tmp_name"];
        $tmpFoto2 = $_FILES["foto2"]["tmp_name"];
        $tmpFoto3 = $_FILES["foto3"]["tmp_name"];

        if ($tmpFoto != "" || $tmpFoto2 != "" ||  $tmpFoto3 != "") {

            move_uploaded_file($tmpFoto, "Imagenes/" . $nombreArchivo);
            move_uploaded_file($tmpFoto2, "Imagenes/" . $nombreArchivo2);
            move_uploaded_file($tmpFoto3, "Imagenes/" . $nombreArchivo3);

            $sentencia = $pdo->prepare("UPDATE tb_formularios SET foto1=:foto1,
            foto2=:foto2,
            foto3=:foto3 WHERE id=:id");

            $sentencia->bindParam(':foto1', $nombreArchivo);
            $sentencia->bindParam(':foto2', $nombreArchivo2);
            $sentencia->bindParam(':foto3', $foto3);
            $sentencia->bindParam(':id', $nombreArchivo3);

            $sentencia->execute();
        }

        header('Location: index.php');
        break;

    case "Eliminar":

        $sentencia = $pdo->prepare("SELECT foto1,foto2,foto3 FROM tb_formularios WHERE id=:id");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();
        $formulario = $sentencia->fetch(PDO::FETCH_LAZY);
        print_r($formulario);


        if (isset($formulario["foto1"])) {
            if (file_exists("Imagenes/" . $formulario["foto1"])) {
                unlink("Imagenes/" . $formulario["foto1"]);
            }
        }

        if (isset($formulario["foto2"])) {
            if (file_exists("Imagenes/" . $formulario["foto2"])) {
                unlink("Imagenes/" . $formulario["foto2"]);
            }
        }

        if (isset($formulario["foto3"])) {
            if (file_exists("Imagenes/" . $formulario["foto3"])) {
                unlink("Imagenes/" . $formulario["foto3"]);
            }
        }

        $sentencia = $pdo->prepare("DELETE FROM tb_formularios WHERE id=:id");
        $sentencia->bindParam(':id', $id);
        $sentencia->execute();

        header('Location: index.php');
        break;
}


$sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE 1 ");
$sentencia->execute();
$listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario

if (isset($_GET["id"]) && isset($_GET["fd"])) {
    $sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE fecha BETWEEN '" . $_GET["id"] . "' AND '" . $_GET["fd"] . "'");
    $sentencia->execute();
    $listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario
}

// no guarda
        } else {
 
        }
    }
    
}






//print_r($listaFormulario);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous"> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"> -->
    </script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    <link rel="stylesheet" href="estilos.css">

    <!-- Custom fonts for this template-->
    <!-- <link href="sistema/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    <!-- Custom styles for this template-->
    <link href="sistema/css/sb-admin-2.min.css" rel="stylesheet">


    <title>Formulario</title>
    <style>
        /* div#reader {
            background-color: darkturquoise;
        } */

        .result {
            background-color: rgb(67, 243, 67);
            color: #fff;
            padding: 20px;
        }

        .row {
            display: flex;
        }

        .custom-file-input::-webkit-file-upload-button {
            visibility: hidden;
        }

        .custom-file-input::before {
            content: 'Selecciona un archivo';
            display: inline-block;
            background: linear-gradient(top, #f9f9f9, #e3e3e3);
            border: 1px solid #999;
            border-radius: 3px;
            padding: 5px 8px;
            outline: none;
            white-space: nowrap;
            -webkit-user-select: none;
            cursor: pointer;
            text-shadow: 1px 1px #fff;
            font-weight: 700;
            font-size: 10pt;
        }

        .custom-file-input:hover::before {
            border-color: black;
        }

        .custom-file-input:active::before {
            background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
        }

        .dataTables_filter {
            margin-right: 30px;
        }
    </style>
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> -->
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css"> -->
</head>

<body>
    <div class="shadow mb-4">
        <div class="p-3 container navigator">
            <img class="img-fluid ml-2" id="oncor_img" src="Imagenes/imagen_oncor.png">

        </div>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="btn btn-primary" class="text-center"> <?php echo $_SESSION['usuario']; ?> </div>
            <div class="btn btn-primary" class="text-center"> <?php echo $_SESSION['contraseña']; ?></div>
            <div class="btn btn-primary" class="text-center"> <?php echo $_SESSION['cedula']; ?></div>


        </div>
    </div>

    <div class="p-3 container navigator">
        <a href="login.php" class="btn btn-danger">Cerrar Sesión</a>
    </div>

    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <div class="encabezado">

                <h3 class="title">INSPECCIONES AMBIENTALES MAKRO RECICLAJES <br></h3>
                <h3 id="preg1-1" class="text-center">Gestion de recorridos Makro reciclajes</h3><br>

            </div>
        </div>

        <script src="{{ asset('js/html5-qrcin.jode.ms') }}"></script>
        <!-- <script>
            var html5QrcodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: 250
                });

            // Stop scanning after the code is scanned
            function onScanSuccess(decodedText, decodedResult) {
                console.clear();
                // Handle on success condition with the decoded text or result.
                console.log(`Scan result: ${decodedText}`, decodedResult);
                // ...
                window.location.href = decodedText
                html5QrcodeScanner.clear();
                // ^ this will stop the scanner (video feed) and clear the scan area.
            }

            html5QrcodeScanner.render(onScanSuccess);
        </script> -->

        <hr>


        <!-- se llama jquery action="procedimientos.php"-->
        <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous">
        </script>

        <form method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>

            <h5 class="d-flex justify-content-center"> ubicación del dispositivo</h5>
            <div class="d-flex justify-content-center">
                <label for="">
                    <h6>Latitud:</h6>
                </label>
                <input class="btn btn-info" name="latitud" id="latitud" readonly>
            </div><br>
            <div class="d-flex justify-content-center">
                <label for="">
                    <h6>Longitd: </h6>
                </label>
                <input class="btn btn-primary" name="longitud" id="longitud" readonly>
            </div>

            <!-- final prueba   <div id="result">Resultado AQUI</div> aca muestra la informacion que contiene el QR -->

            <div class="d-flex justify-content-center">
                <div class="pregunta1">
                    <h4 id="preg1">
                        ANTES DE LA RECOLECCIÓN Se evidencia incorrecta clasificación <br> de residuos de reciclaje.
                        ¿Cuales?
                    </h4>
                    <hr>
                    <div class="text-center">
                        <input class="form-control" type="text" name="id" id="id" disabled value="<?php echo $id; ?>">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>Residuos biosanitarios<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg1" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg1" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>Residuos peligrosos<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg2" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg2" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>Residuos ordinarios<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg3" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg3" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>Escombro<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg4" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg4" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>Lodo<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg5" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg5" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>DESPUES DE LA RECOLECCIÓN Se realizó adecuadamente la recolección en el punto ecológico<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg6" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg6" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>El área se encuentra en óptimas condiciones de orden y aseo<span style="color: red;">*</span>
                    </h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg7" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg7" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>La canastilla está en óptimas condiciones<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="radio" type="radio" name="radio_preg8" value="SI" required> Si <br>
                    <input class="radio" type="radio" name="radio_preg8" value="NO" required> No
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario marcar una opcion</div>
                </div>

            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>Registrar CEDULA de la Persona que diligencia la inspección<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="form-control" type="text" name="cedula" id="cedula" placeholder="Tu respuesta" required>
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario registrar el celular</div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5> CELULAR de la Persona que diligencia la inspección<span style="color: red;">*</span></h5>
                    <hr>
                    <input class="form-control" name="celular" id="celular" placeholder="celular" required type="tel" name="celular" required>
                    <div class="valid-feedback">Cargando...</div>
                    <div class="invalid-feedback">es necesario registrar el celular</div>
                </div>
            </div>


            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <h5>Nombre del Punto de Recolección</h5>
                    <hr>
                    <select name="punto_recoleccion" class="form-select" class="seleccion" required>
                        <option selected hidden value="">-- Seleccione el punto de recolección --</option>
                        <option value="Zona  Contratistas ">Zona Contratistas</option>
                        <option value="Control Acceso Porteria">Control Acceso Porteria</option>
                        <option value=" Vestier Planta Químicos "> Vestier Planta Químicos </option>
                        <option value=" Malla Perimetral Porteria Norte a sur "> Malla Perimetral Porteria Norte a sur
                        </option>
                        <option value=" Muelle Exportación Cloro "> Muelle Exportación Cloro </option>
                        <option value=" Casa Prefabricada Salgado Meléndez "> Casa Prefabricada Salgado Meléndez
                        </option>
                        <option value="Planta Sulfonación"> Planta Sulfonación </option>
                        <option value=" Ingreso empaque sal "> Ingreso empaque sal s</option>
                        <option value=" Despacho Químicos "> Despacho Químicos </option>
                        <option value=" Compresores Empaque Sal "> Compresores Empaque Sal </option>
                        <option value=" Zona Perimetral 1 (Muro A Perímetro Santana) "> Zona Perimetral 1 (Muro A
                            Perímetro Santana) </option>
                        <option value=" Puerta Acceso Yodo flúor "> Puerta Acceso Yodo flúor </option>
                        <option value=" Bodega(k) Empaque Exportación "> Bodega(k) Empaque Exportación </option>
                        <option value="Bombas Sesquilé ">Bombas Sesquilé </option>
                        <option value="Reservorio ">Reservorio </option>
                        <option value=" Molienda Carbonato "> Molienda Carbonato </option>
                        <option value="Despacho Aseo Exportación ">Despacho Aseo Exportación </option>
                        <option value=" Carpa (CU) "> Carpa (CU) </option>
                        <option value="Bodega J">Bodega J</option>
                        <option value="Alistamiento exportación aseo">Alistamiento exportación aseo</option>
                        <option value=" Parqueadero Externo"> Parqueadero Externo</option>
                        <option value="control acceso Transportadora Vigía">control acceso Transportadora Vigías
                        </option>
                        <option value=" Bodega Almacenamiento Carbonato "> Bodega Almacenamiento Carbonato </option>
                        <option value="Punto Critico">Punto Critico</option>
                        <option value="Petar Sulfonación ">Petar Sulfonación </option>
                        <option value="Carpa (CUA) ">Carpa (CUA) </option>
                        <option value="Cendis Carpa ">Cendis Carpa </option>
                        <option value=" Vestier Femenino "> Vestier Femenino </option>
                        <option value="Recepción Porteria norte ">Recepción Porteria norte </option>
                        <option value="Pasillo Empaque Sal Desmercurizacion">Pasillo Empaque Sal Desmercurizacion
                        </option>
                        <option value="analisis">Vestier Planta Sal s</option>
                        <option value="Carpa (CUC) ">Carpa (CUC) </option>
                        <option value="Muelle Exportación Sal">Muelle Exportación Sal</option>
                        <option value="Recepción Porteria Sur ">Recepción Porteria Sur </option>
                        <option value="Subestación Bogotá">Subestación Bogotá</option>
                        <option value="Parqueadero Exportación e Importación">Parqueadero Exportación e Importación
                        </option>
                        <option value="Malla Perimetral oficinas almacén">Malla Perimetral oficinas almacén</option>
                        <option value=" Muelle Acido Exportación "> Muelle Acido Exportación </option>
                        <option value="Caldera#6 ">Caldera#6 </option>
                        <option value="Bombas Turbogenerador Central Termica">Bombas Turbogenerador Central Termica
                        </option>
                        <option value="Reprocesos">Reprocesoss</option>
                        <option value=" Recorredor Norte "> Recorredor Norte </option>
                        <option value=" Sal Base Ganado"> Sal Base Ganado</option>
                        <option value="Puerta Acceso Estación gas Refinerías ">Puerta Acceso Estación gas Refinerías
                        </option>
                        <option value=" Cuarto Eléctrico Planta Sal "> Cuarto Eléctrico Planta Sal </option>
                        <option value="Taller Electricidad">Taller Electricidad</option>
                        <option value=" Planta Soplado "> Planta Soplado </option>
                        <option value="Operador Bascula ">Operador Bascula </option>
                        <option value=" Cuarto Activos Dados Baja "> Cuarto Activos Dados Baja </option>
                        <option value="Despacho Cloro Exportación ">Despacho Cloro Exportación </option>
                        <option value="Gestión humana ">Gestión humana </option>
                        <option value="Centro de Computo ">Centro de Computo </option>
                        <option value=" Brinsa Cajicá oficina cartera "> Brinsa Cajicá oficina cartera s</option>
                        <option value="Carbonato purificación salmuera ">Carbonato purificación salmuera </option>
                        <option value=" Patio Carbón"> Patio Carbón</option>
                        <option value="Laboratorio">Laboratorio</option>
                        <option value="Seguridad proveedores ">Seguridad proveedores </option>
                        <option value="Central Termica">Central Termicas</option>
                        <option value="Subestación Gas ">Subestación Gas </option>
                        <option value="Cuarto Preparación Yodo flúor">Cuarto Preparación Yodo flúors</option>
                        <option value="Cerca Perimetral Makro Reciclaje ">Cerca Perimetral Makro Reciclaje </option>
                        <option value="Cendis">Cendis</option>
                        <option value="Despacho Acido Exportación ">Despacho Acido Exportación </option>
                        <option value=" Control Bodegas Externas "> Control Bodegas Externas </option>
                        <option value=" Servicio al cliente "> Servicio al cliente </option>
                        <option value=" Electrolizadores "> Electrolizadores </option>
                        <option value=" Bodega ME Exportación  "> Bodega ME Exportación </option>
                        <option value=" Control Procesos "> Control Procesos </option>
                        <option value="ALMACEN">ALMACEN</option>
                        <option value=" Oficinas Calidad "> Oficinas Calidad </option>
                        <option value="Oficina comercio exterior ">Oficina comercio exterior </option>
                        <option value=" Tanque Saturador "> Tanque Saturador </option>
                        <option value=" Ingreso a Silos "> Ingreso a Silos </option>
                        <option value="Alistamiento Sal Exportación">Alistamiento Sal Exportación</option>
                        <option value="Malla Muro Perimetral ">Malla Muro Perimetral </option>

                    </select>
                </div>
            </div>

            <!-- libreria  para escanear QR-->

            <h2 class="d-flex justify-content-center">Lectura QR</h2>

            <div class="20203 d-flex justify-content-center"> <img src="imagenes/q.png" style="width:300px;" style="height:100%;" class="position-absolute">
                <div style="width:300px;" style="height:96px;" id="reader">
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <h4>Código:</h4>

                <div id="result" name="result" style="background-color: black;"></div>
                <div class="valid-feedback">qr</div>
                <div class="invalid-feedback">es necesario registrar el qr</div>

            </div>



            <div class="d-flex justify-content-center mt-4 mb-4">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <label for="">Foto 1</label>
                        <div class="mt-1">
                            <label for="foto1" class="btn btn-primary">
                                Selecciona un archivo
                            </label>
                        </div>

                        <input class="custom-file-input" type="file" id="foto1" name="foto1" accept="image/*" hidden required>
                        <div class="valid-feedback">cargando...</div>
                        <div class="invalid-feedback">es necesario adjuntar imagen 1</div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <label for="">Foto 2</label>
                        <div class="mt-1">
                            <label for="foto2" class="btn btn-primary">
                                Selecciona un archivo
                            </label>
                        </div>

                        <input class="custom-file-input" type="file" id="foto2" name="foto2" accept="image/*" hidden required>
                        <div class="valid-feedback">cargando...</div>
                        <div class="invalid-feedback">es necesario adjuntar imagen 2</div>
                    </div>

                    <div class="col-lg-4 col-sm-12">
                        <label for="">Foto 3</label>
                        <div class="mt-1">
                            <label for="foto3" class="btn btn-primary">
                                Selecciona un archivo
                            </label>
                        </div>
                        <input class="custom-file-input" type="file" id="foto3" name="foto3" accept="image/*" hidden required>
                        <div class="valid-feedback">cargando...</div>
                        <div class="invalid-feedback">es necesario adjuntar imagen 3</div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <div class="pregunta1-1">
                    <textarea class="observaciones form-control" cols="10" name="observaciones" placeholder="Observaciones" required></textarea>
                </div>
            </div>

            <input type="hidden" name="registro_id" value="0">

            <div class="container_button">
                <input class="btn-enviar" id="Agregar" type="submit" value="Agregar" name="accion">
            </div>

            <hr>
            <!-- <input class="btn-enviar" id="Modificar" type="submit" value="Modificar" name="accion"> -->
        </form>
    </div>

    <?php if ($_SESSION['rol'] == 1) { ?>
        <div class="container">
            <form class="row">
                <div class="col-lg-4">
                    <label>Fecha Inicial</label>
                    <input name="id" type="date" class="form-control">
                </div>
                <div class="col-lg-4">
                    <label>Fecha Final</label>
                    <input name="fd" type="date" class="form-control">
                </div>
                <div class="col-lg-4">
                    <?php if (!(isset($_GET["id"]) && isset($_GET["fd"]))) { ?>
                        <label> </label>
                    <?php } ?>
                    <input type="submit" class="form-control btn btn-success mt-2" value="Filtrar">
                    <?php if (isset($_GET["id"]) && isset($_GET["fd"])) { ?>
                        <a class="form-control btn btn-danger mt-1" href="index.php">Quitar Filtros</a>
                    <?php } ?>
                </div>
            </form>
            <hr>
        </div>
        <div>
            <div style="margin-left:5%; margin-right:5%; ">
                <div class="table-responsive mt-4 pb-2  ">
                    <table id="dataTable" class="table table-hover table-bordered">
                        <thead>
                            <tr class="bg-oncor text-light">
                                <th class="align-middle">Fecha</th>
                                <th class="align-middle">Foto 1</th>
                                <th class="align-middle">Foto 2</th>
                                <th class="align-middle">Foto 3</th>
                                <th class="align-middle">Residuos biosanitarios</th>
                                <th class="align-middle">Residuos peligrosos</th>
                                <th class="align-middle">Residuos ordinarios</th>
                                <th class="align-middle">Escombro</th>
                                <th class="align-middle">Lodo</th>
                                <th class="align-middle">Se realizó adecuadamente la recolección en el punto ecológico</th>
                                <th class="align-middle">El área se encuentra en óptimas condiciones de orden y aseo</th>
                                <th class="align-middle">La canastilla está en óptimas condiciones</th>
                                <th class="align-middle">Persona que diligencia la inspección</th>
                                <th class="align-middle">Punto de Recoleccion</th>
                                <th class="align-middle">Observaciones</th>
                                <th class="align-middle">result codigo</th>
                                <th class="align-middle">Latitud</th>
                                <th class="align-middle">Longitud</th>
                                <th class="align-middle">Accion</th>
                            </tr>
                        </thead>
                        <?php foreach ($listaFormulario as $fomulario) { ?>
                            <tr>
                                <td><?php echo explode('.', $fomulario['fecha'])[0]; ?></td>
                                <td><img class="img-thumbnail" width="100px" src="Imagenes/<?php echo $fomulario['foto1']; ?>" /> </td>
                                <td><img class="img-thumbnail" width="100px" src="Imagenes/<?php echo $fomulario['foto2']; ?>" /> </td>
                                <td><img class="img-thumbnail" width="100px" src="Imagenes/<?php echo $fomulario['foto3']; ?>" /> </td>
                                <td><?php echo $fomulario['pregunta_1']; ?></td>
                                <td><?php echo $fomulario['pregunta_2']; ?></td>
                                <td><?php echo $fomulario['pregunta_3']; ?></td>
                                <td><?php echo $fomulario['pregunta_4']; ?></td>
                                <td><?php echo $fomulario['pregunta_5']; ?></td>
                                <td><?php echo $fomulario['pregunta_6']; ?></td>
                                <td><?php echo $fomulario['pregunta_7']; ?></td>
                                <td><?php echo $fomulario['pregunta_8']; ?></td>
                                <td><?php echo $fomulario['cedula']; ?></td>
                                <td><?php echo $fomulario['punto_recoleccion']; ?></td>
                                <td><?php echo $fomulario['observaciones']; ?></td>
                                <td><?php echo $fomulario['result']; ?></td>
                                <td><?php echo $fomulario['latitud']; ?></td>
                                <td><?php echo $fomulario['longitud']; ?></td>
                                <td>


                                    <form action="" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $fomulario['id']; ?>">
                                        <button class="btn btn-danger" value="Eliminar" type="submit" name="accion" onclick="return Confirmar('¿ Esta seguro que desea eliminar el registro ?');">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
            </div>
            <div class="container_button pb-4" style="display: flex; justify-content:center;">
                <?php if (!(isset($_GET["id"]) && isset($_GET["fd"]))) { ?>
                    <a class="btn btn-success" href="excel.php" style="margin-right: 10px;">Descargar en Excel</a>
                <?php } ?>
                <?php if (isset($_GET["id"]) && isset($_GET["fd"])) { ?>
                    <a class="btn btn-success" href="<?php echo 'excel.php?id=' . $_GET['id'] . '&fd=' . $_GET['fd'] ?>" style="margin-right: 10px;">Descargar en Excel</a>
                <?php } ?>


                <div class="row_button">
                    <?php if (!(isset($_GET["id"]) && isset($_GET["fd"]))) { ?>
                        <a class="btn btn-success" href="reportes_pdf.php" style="margin-right: 10px;">Descargar en Excel</a>
                    <?php } ?>
                    <?php if (isset($_GET["id"]) && isset($_GET["fd"])) { ?>
                        <a class="btn btn-success" href="<?php echo 'reportes_pdf.php?id=' . $_GET['id'] . '&fd=' . $_GET['fd'] ?>" style="margin-right: 10px;">Descargar en Excel</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="html-qrcode.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        function onScanSuccess(qrCodeMessage) {

            document.getElementById('result').innerHTML = '<input value="' + qrCodeMessage +
                '" class="form-control" type="placeholder" name="result" id="result">';

            Swal.fire('success',
                ' CODIGO QR CARGADO'
            )
            //      document.getElementById("result").innerHTML =
            // '<span class="result">' + qrCodeMessage + "</span>";
        }

        function onScanError(errorMessage) {
            //handle scan error
        }

        var html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 10,
                qrbox: 250
            });
        html5QrcodeScanner.render(onScanSuccess, onScanError);
    </script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "language": {
                    "lengthMenu": "Ver _MENU_ registros",
                    "zeroRecords": "Sin registros",
                    "info": "Viendo la página _PAGE_ de _PAGES_",
                    "infoEmpty": "Sin registros",
                    "infoFiltered": "(filtrado de un total de _MAX_ registros.)",
                    "search": "Buscar:",
                    "pageLength": {
                        "-1": "Mostrar todas las filas",
                        "_": "Mostrar %d filas"
                    },
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            });
        });
    </script>
    <script>
        function Confirmar(Mensaje) {
            return (confirm(Mensaje)) ? true : false;
        }
    </script>

</body>

</html>

<script>
    var latitud = document.getElementById("latitud");
    var longitud = document.getElementById("longitud");
    navigator.geolocation.getCurrentPosition(function(position) {
        latitud.setAttribute("value", position.coords.latitude);
        longitud.setAttribute("value", position.coords.longitude);
    });
</script>

<script>
    // validacion de campos del formulario BOOSTRAP
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<Script>
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            console.log(position);
        });
    }
</Script>
<script>
    var x = '<?php echo json_encode($row[""]); ?>';
</script>

<link rel="stylesheet">
<script src="./script.js"></script>