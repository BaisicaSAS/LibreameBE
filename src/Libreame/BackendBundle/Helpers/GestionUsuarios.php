<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Repository\ManejoDataRepository;

use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbSesiones;
/**
 * Description of Gestion Usuarios
 *
 * @author mramirez
 */
class GestionUsuarios {
    
    /*
     * ObtenerParametros 
     * Retorna la información del usuario que se encuentra logueado, para visualización
     * 
     */

    public function obtenerParametros($psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=ManejoDataRepository::validaSesionUsuario($psolicitud);
           //echo "<script>alert(' obtenerParametros :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Busca el usuario 
                $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
                $califica = ManejoDataRepository::getCalificaUsuarioRecibidas($usuario);
                //echo "<script>alert('RESP cali ".count($califica)." ')</script>";
                $grupos = ManejoDataRepository::getGruposUsuario($usuario);
                //echo "<script>alert('RESP grup ".count($grupos)." ')</script>";
                //echo "<script>alert('La sesion es ".$usuario->getTxusuemail()."')</script>";

                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //Guarda la actividad de la sesion:: 
                //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Datos de usuario ".$psolicitud->getEmail()." recuperados con éxito",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                $respuesta->setRespuesta(AccesoController::inExitoso);

                //echo "<script>alert('2 Validez de sesion ".$respuesta." ')</script>";
                //Ingresa el usuario en el arreglo de la Clase respuesta
                //echo "<script>alert('ALEX ')</script>";
                $respuesta->setArrUsuarios($usuario);
                //echo "<script>alert('ALEX ".$respuesta->RespUsuarios[0]->getTxusunombre()." ')</script>";

                $respuesta->setArrCalificaciones($califica);
                $respuesta->setArrGrupos($grupos);
                
            } else {
                $respuesta->setRespuesta($respSesionVali);
                $respuesta->setArrUsuarios($usuario);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
        } finally {
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $usuario);
        }
    }
}
