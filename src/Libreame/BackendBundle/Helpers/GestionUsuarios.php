<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;

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
        $fecha = new \DateTime;
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=$objLogica::validaSesionUsuario($psolicitud);
           //echo "<script>alert(' obtenerParametros :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                $em = $this->getDoctrine()->getManager();
                //Busca el usuario 
                $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()));
                
                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = $objLogica::recuperaSesionUsuario($usuario,$psolicitud);
                //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                //$objLogica::generaActSesion($sesion,AccesoController::inDatoUno,"Datos de usuario ".$psolicitud->getEmail()." recuperados con éxito",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                $respuesta->setRespuesta(AccesoController::inExitoso);

                //echo "<script>alert('2 Validez de sesion ".$respuesta." ')</script>";
                //Ingresa el usuario en el arreglo de la Clase respuesta
                $respuesta->setArrUsuarios($usuario);
                
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
