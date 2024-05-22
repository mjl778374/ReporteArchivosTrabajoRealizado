<?php
$ValidarUsuarioSesionEsAdmin = 1; // Este es un parámetro que recibe "ValidarIngresoApp.php"
include_once "ValidarIngresoApp.php"; // Aquí dentro se hace el redireccionamiento a la página de ingreso, en caso de fallar la validación
// La anterior debe ser la primera instrucción por ejecutar en el archivo web

$FechaInicial = "";
$FechaFinal = "";
$IdUsuario = "";

if (isset($_GET["FechaInicial"]) || isset($_GET["FechaFinal"]) || isset($_GET["IdUsuario"]))
{
    $SePretendeConsultarInformacion = true;
    $FechaInicial = $_GET["FechaInicial"];
    $FechaFinal = $_GET["FechaFinal"];    
    $IdUsuario = $_GET["IdUsuario"];    
} // if (isset($_GET["FechaInicial"]) || isset($_GET["FechaFinal"]) || isset($_GET["IdUsuario"]))

// A continuación el código fuente de la implementación
try
{
    include "constantesApp.php";
    
    include_once "CUsuarios.php";
    $Usuarios = new CUsuarios();
    $ListadoUsuarios = $Usuarios->DemeTodosUsuarios();

    include_once "CFechasHoras.php";
    $FechasHoras = new CFechasHoras();

    $FechaHoy = $FechasHoras->DemeFechaHoy($FORMATO_FECHAS_SQL);
    
    if (!$FechasHoras->EsFechaValida($FechaInicial))
        $FechaInicial = $FechasHoras->AgregarMesesAFechaHora($FechaHoy, -1);

    if (!$FechasHoras->EsFechaValida($FechaFinal))
        $FechaFinal = $FechaHoy;

    if ($SePretendeConsultarInformacion)
    {
        include_once "CArchivosSubidos.php";        
        $ArchivosSubidos = new CArchivosSubidos();    
        $ListadoArchivosSubidos = $ArchivosSubidos->ConsultarXTodosArchivosSubidos($FechaInicial, $FechaFinal, $IdUsuario);
    } // if ($SePretendeConsultarInformacion)
} // try
catch (Exception $e)
{
    $NumError = 1;
    $MensajeOtroError = $e->getMessage();
} // catch (Exception $e)
// El anterior fue el código fuente de la implementación

include "interfaz/consultaArchivosSubidos.php";
?>
