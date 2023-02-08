<div class="d-flex justify-content-center">
    <div class="pregunta1-1">

        <?php
     // WHERE id=:id"
         $sentencia = $pdo2->prepare("select Imei_FK  from qr where 'Codigo' = 'result'");
        //  $sentencia = $pdo2->prepare("select Imei_FK  from qr");
        $sentencia->execute();
        $imei = $sentencia->fetchAll(PDO::FETCH_ASSOC); //ASIGNAR LISTA A LA VARIABLE $listaFormulario

        ?> <div class="col-md-8">
        <select class="form-control"  required>
        <?php foreach ($imei  as $celular): ?>
            <option><?php echo $celular['Imei_FK']; ?></option>
        <?php endforeach; ?>
        </select>
    </div>

    </div>
</div>