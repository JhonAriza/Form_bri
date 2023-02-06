<?php

session_start();
if (!isset($_SESSION['usuario'])) {
    header('location: login.php');
}


ob_start();

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Reporte PDF</title>
</head>

<body>


    <?php
    include('conexion/conexion.php');
    $sentencia = $pdo->prepare("SELECT * FROM `tb_formularios` WHERE 1");
    $sentencia->execute();
    $listaFormulario = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario
    ?>

    <h1>Reporte de Formularios</h1>

    <table class="table table-hover">

        <thead>
            <tr>
                <th>Fecha</th>
                <th>Foto1</th>
                <th>Foto2</th>
                <th>Foto3</th>
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

            </tr>
        </thead>
        <?php foreach ($listaFormulario as $fomulario) { ?>
            <tr>
                <td><?php echo explode('.', $fomulario['fecha'])[0]; ?></td>
                <td><img class="" width="200px" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/formulario_brinsa/Imagenes/<?php echo $fomulario['foto1']; ?>" width="100" alt="" srcset="" /> </td>
                <td><img class="" width="200px" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/formulario_brinsa/Imagenes/<?php echo $fomulario['foto2']; ?>" width="50" alt="" srcset="" /> </td>
                <td><img class="" width="200px" src="http://<?php echo $_SERVER['HTTP_HOST']; ?>/formulario_brinsa/Imagenes/<?php echo $fomulario['foto3']; ?>" width="50" alt="" srcset="" /> </td>
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

            </tr>
        <?php } ?>
    </table>

</body>

</html>

<?php

$html = ob_get_clean();
//echo $html;

require_once 'libreria/dompdf/autoload.inc.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->load_Html($html);
//$dompdf->setPaper('letter');

//$dompdf->setPaper('A4', 'landscape');

$paper_size = array(0, 0, 1660, 860);
$dompdf->set_paper($paper_size);


$dompdf->render();

$dompdf->stream("reporte.pdf", array("Attachment" => false));


?>