<?php
include_once "CFormateadorMensajes.php";

if ($NumError != 0)
{
    if ($NumError == 1)
        $MensajeXDesglosar = CFormateadorMensajes::FormatearMensajeError($MensajeOtroError);
} // if ($NumError != 0)
?>
<!DOCTYPE html>
<html>
<?php
$IncluirEncabezadosFecha = 1; // Este es un parámetro que recibe "encabezados.php"
include "encabezados.php";
?>
<body>
<?php
$FormularioActivo = "ConsultaArchivosSubidos"; // Este es un parámetro que recibe "menuApp.php"
include "menuApp.php";

include_once "FuncionesUtiles.php";
?>
<form method="get">
    <div class="container mt-4">
        <div class="form-row justify-content-center">
            <div class="form-group col-8 col-md-6 col-lg-4">
                <input type="hidden" name="FechaInicial" id="FechaInicial"></text>
                <label for="ControlFechaInicial">Fecha Inicial</label>
                <div id="ControlFechaInicial" name="ControlFechaInicial"></div>
            </div>
        </div>    
        <div class="form-row justify-content-center">
            <div class="form-group col-8 col-md-6 col-lg-4">
                <input type="hidden" name="FechaFinal" id="FechaFinal"></text>
                <label for="ControlFechaFinal">Fecha Final</label>
                <div id="ControlFechaFinal" name="ControlFechaFinal"></div>
            </div>
        </div>    
        <div class="form-row justify-content-center">
            <div class="form-group col-8 col-md-6 col-lg-4">
                <label for="IdUsuarioAutor">Usuario</label>
<?php
$PrimerItemListaSeleccion = [];
$ItemesListaSeleccion = $ListadoUsuarios;
$PrimerItemListaSeleccion[] = array($ID_ITEM_NO_SELECCIONADO_EN_LISTA_SELECCION, "Cualquier usuario...");
$ItemesListaSeleccion = array_merge($PrimerItemListaSeleccion, $ItemesListaSeleccion);
$IdItemSeleccionado = $IdUsuario;
// Los anteriores son parámetros que se le envían a la lista de selección
?>
                <?php $IdListaSeleccion="IdUsuario"; $NombreListaSeleccion="IdUsuario"; include "componenteListaSeleccion.php" ?>
            </div>
        </div>                
        <div class="form-row justify-content-center mt-4">
            <div class="form-group col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary">Consultar</button>
            </div>
        </div>
    </div>
<?php

$URLFormulario = "consultaArchivosSubidos.php";  // Este es un parámetro que recibe "AfinarParametrosListado.php"
$ParametrosURL = "?FechaInicial=" . $FechaInicial . "&FechaFinal=" . $FechaFinal . "&IdUsuario=" . $IdUsuario; // Este es un parámetro que recibe "AfinarParametrosListado.php"
$ListadoDatos = $ListadoArchivosSubidos; // Este es un parámetro que reciben "AfinarParametrosListado.php" y "DesglosarTablaDatos.php"
include_once "AfinarParametrosListado.php";
include_once "DesglosarTablaDatos.php";

$URL = "consultaArchivosSubidos.php";
$ParametrosURL = "?FechaInicial=" . $FechaInicial . "&FechaFinal=" . $FechaFinal . "&IdUsuario=" . $IdUsuario;
// Los anteriores son parámetros que recibe "componentePaginacion.php"

if ($NumPaginas > 0)
    include "componentePaginacion.php";
    
if ($MensajeXDesglosar != "")
    echo $MensajeXDesglosar;
    
?>    
</form>
</body>
<?php
$IdControl = "ControlFechaInicial"; $FormatoFecha = $FORMATO_FECHAS_CONTROLES_FECHA; $FechaInicial = $FechaInicial; $IdControlCopia="FechaInicial"; include "componenteFecha.php";
?>
<?php
$IdControl = "ControlFechaFinal"; $FormatoFecha = $FORMATO_FECHAS_CONTROLES_FECHA; $FechaInicial = $FechaFinal; $IdControlCopia="FechaFinal"; include "componenteFecha.php";
?>
</html>
