<?php
header('Content-Encoding: UTF-8');
header("Content-Type: application/xls; charset=UTF-8'");
header("Content-Disposition: attachment; filename= reporte.xls");
echo "\xEF\xBB\xBF";
?>

<?php

$id = (isset($_POST['id'])) ? $_POST['id'] : "";
$radio_preg1 = (isset($_POST['radio_preg1'])) ? $_POST['radio_preg1'] : "";
$radio_preg2 = (isset($_POST['radio_preg2'])) ? $_POST['radio_preg2'] : "";
$radio_preg3 = (isset($_POST['radio_preg3'])) ? $_POST['radio_preg3'] : "";
$radio_preg4 = (isset($_POST['radio_preg4'])) ? $_POST['radio_preg4'] : "";
$radio_preg5 = (isset($_POST['radio_preg5'])) ? $_POST['radio_preg5'] : "";
$radio_preg6 = (isset($_POST['radio_preg6'])) ? $_POST['radio_preg6'] : "";
$radio_preg7 = (isset($_POST['radio_preg7'])) ? $_POST['radio_preg7'] : "";
$radio_preg8 = (isset($_POST['radio_preg8'])) ? $_POST['radio_preg8'] : "";
$diligente = (isset($_POST['diligente'])) ? $_POST['diligente'] : "";
$punto_recoleccion = (isset($_POST['punto_recoleccion'])) ? $_POST['punto_recoleccion'] : "";
$foto1 = (isset($_FILES['foto1']["name"])) ? $_FILES['foto1']["name"] : "";
$foto2 = (isset($_FILES['foto2']["name"])) ? $_FILES['foto2']["name"] : "";
$foto3 = (isset($_FILES['foto3']["name"])) ? $_FILES['foto3']["name"] : "";
$observaciones = (isset($_POST['observaciones'])) ? $_POST['observaciones'] : "";

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include('conexion/conexion.php');

$sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE 1");
$sentencia->execute();
$listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario

if (isset($_GET["id"]) && isset($_GET["fd"])) {
    $sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE fecha BETWEEN '" . $_GET["id"] . "' AND '" . $_GET["fd"] . "'");
    $sentencia->execute();
    $listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario
}
?>

<table class="table table-hover">

    <thead>
        <tr>
            <th class="align-middle">Fecha</th>
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
            <th class="align-middle">Foto 1</th>
            <th class="align-middle">Foto 2</th>
            <th class="align-middle">Foto 3</th>
        </tr>
    </thead>
    <?php foreach ($listaFormulario as $fomulario) { ?>
        <tr>
            <td><?php echo explode('.', $fomulario['fecha'])[0]; ?></td>
            <td><?php echo $fomulario['pregunta_1']; ?></td>
            <td><?php echo $fomulario['pregunta_2']; ?></td>
            <td><?php echo $fomulario['pregunta_3']; ?></td>
            <td><?php echo $fomulario['pregunta_4']; ?></td>
            <td><?php echo $fomulario['pregunta_5']; ?></td>
            <td><?php echo $fomulario['pregunta_6']; ?></td>
            <td><?php echo $fomulario['pregunta_7']; ?></td>
            <td><?php echo $fomulario['pregunta_8']; ?></td>
            <td><?php echo $fomulario['persona_inspeccion']; ?></td>
            <td><?php echo $fomulario['punto_recoleccion']; ?></td>
            <td><?php echo $fomulario['observaciones']; ?></td>
            <td><?php echo $_SERVER['HTTP_HOST']; ?>/formulario_brinsa/Imagenes/<?php echo $fomulario['foto1']; ?></td>
            <td><?php echo $_SERVER['HTTP_HOST']; ?>/formulario_brinsa/Imagenes/<?php echo $fomulario['foto2']; ?></td>
            <td><?php echo $_SERVER['HTTP_HOST']; ?>/formulario_brinsa/Imagenes/<?php echo $fomulario['foto3']; ?></td>
        </tr>
    <?php } ?>
</table>