<?php
class CArchivoSubido
{
    private const URL_ARCHIVOS = "http://localhost:8080/Archivos";
    private const CARPETA_DISCO_ARCHIVOS = "/home/manuel/Documentos/Código Fuente/PHP/ReporteArchivosTrabajoRealizado/Admin/Archivos";
    public const EXTENSION_ARCHIVOS = "zip";
    public const TIPO_ARCHIVOS_X_SUBIR_ACEPTADO = "application/zip";

    private $IdUsuario = NULL;
    private $Consecutivo = NULL;
    private $FechaHoraEnvio = NULL;

    function __construct($IdUsuario, $Usuario, $Consecutivo, $FechaHoraEnvio)
    {
        $this->IdUsuario = $IdUsuario;
        $this->Usuario = $Usuario;        
        $this->Consecutivo = $Consecutivo;
        $this->FechaHoraEnvio = $FechaHoraEnvio;
    } // function __construct($IdUsuario, $Usuario, $Consecutivo, $FechaHoraEnvio)

    private function DemeNombreArchivo()
    {
        return $this->DemeIdUsuario() . "_" . $this->DemeConsecutivo() . "." . $this::EXTENSION_ARCHIVOS;
    } // private function DemeNombreArchivo()

    private function DemeRutaArchivoDisco()
    {
        return $this::CARPETA_DISCO_ARCHIVOS . "/" . $this->DemeNombreArchivo();
    } // private function DemeRutaArchivoDisco()

    public function DemeUrlArchivo()
    {
        $URL = $this::URL_ARCHIVOS . "/" . $this->DemeNombreArchivo();
        return $URL;
    } // public function DemeUrlArchivo()

    public static function HayErrorAlSubir($NumErrorAlSubir, $TipoArchivoXSubir, &$NumError)
    {
        $NumError = 0;

        if ($NumErrorAlSubir != UPLOAD_ERR_OK)
            $NumError = 1;
        elseif (self::TIPO_ARCHIVOS_X_SUBIR_ACEPTADO != $TipoArchivoXSubir)
            $NumError = 2;
     
        if ($NumError == 0)
            return false;
        else
            return true;
    } // public static function HayErrorAlSubir($NumErrorAlSubir, $TipoArchivoXSubir, &$NumError)
    
    public function CopiarArchivoEnCarpetaArchivos($RutaOrigen, &$NumError)
    {
        $NumError = 0;

        if (!move_uploaded_file($RutaOrigen, $this->DemeRutaArchivoDisco()))
            $NumError = 1;
    } // public function CopiarArchivoEnCarpetaArchivos($RutaOrigen, &$NumError)

    public function DemeIdUsuario()
    {
        return $this->IdUsuario;
    } // public function DemeIdUsuario()

    public function DemeUsuario()
    {
        return $this->Usuario;
    } // public function DemeUsuario()

    public function DemeConsecutivo()
    {
        return $this->Consecutivo;
    } // public function DemeConsecutivo()
  
    public function DemeFechaHoraEnvio()
    {
        return $this->FechaHoraEnvio;
    } // public function DemeFechaHoraEnvio()

    public static function DemeTitulares()
    {
        return array("Usuario", "Fecha y Hora de Envío");
    } // public static function DemeTitulares()
    
    public function DemeArregloDatos()
    {
        include_once "interfaz/FuncionesUtiles.php";
        $URLArchivoSubido = FormatearTextoJS($this->DemeUrlArchivo());
    
        return array("javascript:AbrirURLAbsoluta('" . $URLArchivoSubido . "')", $this->DemeUsuario(), $this->DemeFechaHoraEnvio());
    } // public function DemeArregloDatos()    
} // class CArchivoSubido
?>
