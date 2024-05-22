<?php
include_once "CFormateadorMensajes.php";

$ErrorTipoArchivoInvalido = "Los archivos por subir debe ser del tipo '" . CArchivoSubido::TIPO_ARCHIVOS_X_SUBIR_ACEPTADO . "'.";
$ErrorAlSubir = "Ocurrió un error al intentar subir el archivo.";
  
if ($NumError != 0)
{
    if ($NumError == 1)
        $MensajeXDesglosar = CFormateadorMensajes::FormatearMensajeError($MensajeOtroError);
    elseif ($NumError == 1001)
        $MensajeXDesglosar = CFormateadorMensajes::FormatearMensajeError($ErrorAlSubir);
    elseif ($NumError == 1002)
        $MensajeXDesglosar = CFormateadorMensajes::FormatearMensajeError($ErrorTipoArchivoInvalido);
    elseif ($NumError == 2001)
        $MensajeXDesglosar = CFormateadorMensajes::FormatearMensajeError($ErrorAlSubir);
    elseif ($NumError != 0)
        $MensajeXDesglosar = CFormateadorMensajes::FormatearMensajeError("No se manejó el error número " . $NumError);
} // if ($NumError != 0)
elseif ($SeGuardoInformacionExitosamente)
    $MensajeXDesglosar = CFormateadorMensajes::FormatearMensajeOK("Se subió el archivo exitosamente.");
    
include_once "FuncionesUtiles.php"; // Esta inclusión se requiere para invocar posteriormente a la función 'FormatearTextoURL'.

?>
<!DOCTYPE html>
<html>
<?php
include "encabezados.php";
?>
<body>
<?php
$FormularioActivo = "SubirArchivos"; // Este es un parámetro que recibe "menuApp.php"
include "menuApp.php";
?>
<form method="post" enctype="multipart/form-data">
    <div class="container mt-4">
        <div class="form-row justify-content-center">
            <div class="form-group col-8 col-md-6 col-lg-4 custom-file">
                <input type="hidden" name="SubirArchivo" id="SubirArchivo" value="1"></text>
                <input type="file" class="custom-file-input" id="ArchivoXSubir" name="ArchivoXSubir">
                <label class="custom-file-label" for="ArchivoXSubir">Seleccione un archivo...</label>
            </div>
        </div>
        <div class="form-row justify-content-center mt-4">
            <div class="form-group col-8 col-md-6 col-lg-4">
                <button type="submit" class="btn btn-primary btn-block">Subir</button>
            </div>
        </div>
<?php if (trim($URLArchivoSubido) != "") { ?>
        <div class="form-row justify-content-center mt-4">
            <div class="form-group col-8 col-md-6 col-lg-4">
                <a class="btn btn-primary btn-block" href="<?php echo FormatearTextoURL($URLArchivoSubido)?>" target="_new">Descargar</a>
            </div>
        </div>
<?php } // if (trim($URLArchivoSubido) != "") { ?>        
    </div>
<?php
if ($MensajeXDesglosar != "")
    echo $MensajeXDesglosar;
?>
</form>
</body>
</html>
