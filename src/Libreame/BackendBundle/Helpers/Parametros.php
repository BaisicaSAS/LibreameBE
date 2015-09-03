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

    public function obtenerParametros($pSolicitud)
    {   
        $respuesta = new Respuesta();
        $objAcceso = $this->get('acceso_service');
        $usuario = new LbUsuarios();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            if ($objAcceso::validaSesionUsuario($pSolicitud)==$objAcceso::inULogged) 
            {    
                //Guarda la actividad de la sesion:: 
                //echo "<script>alert('Guardó usuario...va a generar sesion ')</script>";
                $actsesion = $objAcceso::generaActSesion($sesion,AccesoController::inDatoUno,AccesoController::txMensaje,$pSolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                $respuesta->setRespuesta(AccesoController::inExitoso);
                $em = $this->getDoctrine()->getManager();
                $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()));
                
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inDescone);
        } 
        
        return Logica::generaRespuesta($respuesta, $pSolicitud, $usuario);
            
    }
    
    
    
    
}
