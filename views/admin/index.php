<h1 class="nombre-pagina">Panel de Administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php'; ?>
<!--Importar barra.php de templates-->

<h2>Buscar Cita</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha </label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $fecha; ?>" />
        </div>
    </form>
</div>

<?php
if (count($citas) === 0) {      //count valida que el arreglo de citas, tenga algo
    echo "<h2>No Hay Citas En Esta Fecha</h2>";
}
?>

<div id="citas-admin">
    <ul class="citas">
        <?php
        $idCita = 0;
        foreach ($citas as $key => $cita) {        //Se usa para arreglos, recorre el arreglo de citas, key es la posicion que tiene el registro en el arreglo                   

            if ($idCita !== $cita->id) {
                $total = 0;
        ?>
                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span> </p>
                    <p>Hora: <span><?php echo $cita->hora; ?></span> </p>
                    <p>Cliente: <span><?php echo $cita->cliente; ?></span> </p>
                    <p>Email: <span><?php echo $cita->email; ?></span> </p>
                    <p>Telefono : <span><?php echo $cita->telefono; ?></span> </p>
                    <h3>Servicios</h3>
                <?php
                $idCita = $cita->id;
            } //Fin de IF;
            $total +=  $cita->precio;           //sumar cada precio y guardarlo, acumulador
                ?>
                <p class="servicio"><?php echo $cita->servicio . ": $" . $cita->precio; ?></p>

                <?php
                $actual = $cita->id;                    //retorna el id en el cual nos encontramos
                $proximo = $citas[$key + 1]->id ?? 0;    //indice en el arreglo de la base de datos, no se puede dejar como vacio

                if (esUltimo($actual, $proximo)) { ?>
                    <p class="total">Total: <span>$<?php echo $total; ?></span></p>
                    <!--Muestra el total, validando que sea el ultimo elemento con la funcion esUltimo q esta en /includes/funciones.php-->

                    <form action="/api/eliminar" method="POST">
                        <input 
                            type="hidden" 
                            name="id" 
                            value="<?php echo $cita->id; ?>">
                        <input 
                            type="submit"
                            class="boton-eliminar"
                            value="Eliminar">
                    </form>
            <?php }
            } //Fin Forrach;
            ?>
    </ul>
</div>


<?php
$script = "<script src='build/js/buscador.js'></script>"
?>