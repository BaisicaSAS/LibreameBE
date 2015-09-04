<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;

use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
/**
 * Description of Parametros
 *
 * @author mramirez
 */
class Parametros {
    
    /*
     * registro 
     * Esta es la funcion que genera el registro de un usuario en el sistema
     * guarda los datos básicos, genera una clave (url) dispara el envío de email de 
     * Confirmacion, retorna mensaje de exito o fracaso de operacion para el cliente 
     * y registra en la bitácora.
     * 
     * El sistema registra la sesión como finalizada, la cierra en horas y deja la traza en actividad de sesion.
     */

    public function obtenerParametros($psolicitud)
    {   
        $fecha = new \DateTime;
        $respuesta = new Respuesta();
        $objAcceso = $this->get('acceso_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=$objAcceso::validaSesionUsuario($psolicitud);
           //echo "<script>alert(' obtenerParametros :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==$objAcceso::inULogged) 
            {    
                $em = $this->getDoctrine()->getManager();
                //Busca el usuario 
                $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()));
                
                //Busca y recupera el objeto de la sesion:: 
                $sesion = $objAcceso::recuperaSesionUsuario($usuario,$psolicitud);
               //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                $actsesion = $objAcceso::generaActSesion($sesion,AccesoController::inDatoUno,"Datos de usuario ".$psolicitud->getEmail()." recuperados con éxito",$psolicitud->getAccion(),$fecha,$fecha);
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
            $respuesta->setRespuesta(AccesoController::inDescone);
        } 
        
        return Logica::generaRespuesta($respuesta, $psolicitud, $usuario);
            
    }
}
