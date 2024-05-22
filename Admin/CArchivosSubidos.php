<?php
include_once "CSQL.php";
include_once "CArchivoSubido.php";

class CArchivosSubidos extends CSQL
{
    function __construct()
    {
        parent::__construct();
    } // function __construct()

    public function ConsultarXTodosArchivosSubidos($FechaInicial, $FechaFinal, $IdUsuario)
    {
        include "constantesApp.php";   
        include_once "CNumeros.php";                 
        
        $Retorno = [];

        $Consulta = "SELECT a.IdUsuario, a.Usuario, b.ConsecutivoArchivo, DATE_FORMAT(b.FechaHoraEnvio, ?)";
        $Consulta = $Consulta . " FROM Usuarios a, ArchivosXUsuario b";
        $Consulta = $Consulta . " WHERE a.IdUsuario = b.IdUsuario";
        $Consulta = $Consulta . " AND DATE_FORMAT(b.FechaHoraEnvio, ?) >= ?";
        $Consulta = $Consulta . " AND DATE_FORMAT(b.FechaHoraEnvio, ?) <= ?";

        $TiposParametros = "sssss";
        $ArregloParametros = array($FORMATO_FECHAS_HORAS_DESGLOSE, $FORMATO_FECHAS_SQL, $FechaInicial, $FORMATO_FECHAS_SQL, $FechaFinal);
        
        if (CNumeros::EsNumeroEntero($IdUsuario) && $IdUsuario > 0)
        {
            $Consulta = $Consulta . " AND a.IdUsuario = ?";
            $TiposParametros = $TiposParametros . "i";
            $ArregloParametros[] = $IdUsuario;
        } // if (CNumeros::EsNumeroEntero($IdUsuario) && $IdUsuario > 0)
        
        $Consulta = $Consulta . " ORDER BY b.FechaHoraEnvio DESC";
        
        $ConsultaEjecutadaExitosamente = $this->EjecutarConsulta($Consulta, $TiposParametros, $ArregloParametros);
        
        if ($ConsultaEjecutadaExitosamente)
        {
            $ResultadoConsulta = $this->DemeSiguienteResultadoConsulta();

            while ($ResultadoConsulta != NULL)
            {
                $IdUsuario = $ResultadoConsulta[0];
                $Usuario = $ResultadoConsulta[1];                
                $ConsecutivoArchivo = $ResultadoConsulta[2];                
                $FechaHoraEnvio = $ResultadoConsulta[3];                                
                $ObjArchivo = new CArchivoSubido($IdUsuario, $Usuario, $ConsecutivoArchivo, $FechaHoraEnvio);
                $Retorno[] = $ObjArchivo;
                $ResultadoConsulta = $this->DemeSiguienteResultadoConsulta();
            } // while ($ResultadoConsulta != NULL)
        } // if ($ConsultaEjecutadaExitosamente)

        return $Retorno;
    } // public function ConsultarXTodosArchivosSubidos($FechaInicial, $FechaFinal, $IdUsuario)

    public function RegistrarArchivo(&$ObjArchivo)
    {
        include_once "CSession.php";                

        $Consulta = "CALL AltaArchivo(?, 1);";
        $IdUsuario = CSession::DemeIdUsuarioSesion();
        $ConsultaEjecutadaExitosamente = $this->EjecutarConsulta($Consulta, 'i', array($IdUsuario));

        $ObjArchivo = NULL;

        if ($ConsultaEjecutadaExitosamente)
        {
            $ResultadoConsulta = $this->DemeSiguienteResultadoConsulta();

            if ($ResultadoConsulta != NULL)
            {
                $ConsecutivoArchivo = $ResultadoConsulta[0];
                $ObjArchivo = new CArchivoSubido($IdUsuario, "", $ConsecutivoArchivo, "");
            } // if ($ResultadoConsulta != NULL)

            $this->LiberarConjuntoResultados();
        } // if ($ConsultaEjecutadaExitosamente)
    } // public function RegistrarArchivo(&$ObjArchivo)

    function __destruct()
    {
        parent::__destruct();
    } // function __destruct()
} // class CArchivosSubidos extends CSQL
?>
