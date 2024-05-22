<?php
include_once "ValidarIngresoApp.php"; // Aquí dentro se hace el redireccionamiento a la página de ingreso, en caso de fallar la validación
// La anterior debe ser la primera instrucción por ejecutar en el archivo web

$URLArchivoSubido = "";
$SePretendeGuardarInformacion = false;
$SeGuardoInformacionExitosamente = false;

if (isset($_POST["SubirArchivo"]))
{
    $SePretendeGuardarInformacion = true;
    $RutaOrigen = $_FILES['ArchivoXSubir']['tmp_name'];
    $NumErrorAlSubir = $_FILES['ArchivoXSubir']['error'];
    $TipoArchivoXSubir = $_FILES['ArchivoXSubir']['type'];
} // if (isset($_POST["SubirArchivo"]))

// A continuación el código fuente de la implementación
try
{
    $ObjArchivo = NULL;
    include_once "CArchivosSubidos.php";    
    include_once "CArchivoSubido.php";    

    if ($SePretendeGuardarInformacion)
    {
        if (CArchivoSubido::HayErrorAlSubir($NumErrorAlSubir, $TipoArchivoXSubir, $NumError))
            $NumError = $NumError + 1000;
                
        if ($NumError == 0)
        {
            $ArchivosSubidos = new CArchivosSubidos();
            $ArchivosSubidos->RegistrarArchivo($ObjArchivo);
        
            $ObjArchivo->CopiarArchivoEnCarpetaArchivos($RutaOrigen, $NumError);
            
            if ($NumError != 0)
                $NumError = $NumError + 2000;            
        } // if ($NumError == 0)
        
        if ($NumError == 0)
            $SeGuardoInformacionExitosamente = true;
    } // if ($SePretendeGuardarInformacion)
} // try
catch (Exception $e)
{
    $NumError = 1;
    $MensajeOtroError = $e->getMessage();
} // catch (Exception $e)
// El anterior fue el código fuente de la implementación

if ($ObjArchivo != NULL && $NumError == 0)
    $URLArchivoSubido = $ObjArchivo->DemeURLArchivo();

include "interfaz/subirArchivos.php";
?>
