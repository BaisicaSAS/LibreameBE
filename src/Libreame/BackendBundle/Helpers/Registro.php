<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;

use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
/**
 * Description of Registro
 *
 * @author mramirez
 */
class Registro {
    
    /*
     * registro 
     * Esta es la funcion que genera el registro de un usuario en el sistema
     * guarda los datos básicos, genera una clave (url) dispara el envío de email de 
     * Confirmacion, retorna mensaje de exito o fracaso de operacion para el cliente 
     * y registra en la bitácora.
     * 
     * El sistema registra la sesión como finalizada, la cierra en horas y deja la traza en actividad de sesion.
     */

    public function registroUsuario($pSolicitud)
    {   
        $respuesta = new Respuesta();
        $objAcceso = $this->get('acceso_service');
        try {
            //echo "<script>alert('Ingresa Registro')</script>";
            $em = $this->getDoctrine()->getManager();
            $usuario = new LbUsuarios();
            $device = new LbDispusuarios();
            $membresia = new LbMembresias();
            $sesion = new LbSesiones();
            $actsesion = new LbActsesion();


            //Lugar por default (Es el de ID = 1)
            $Lugar = $em->getRepository('LibreameBackendBundle:LbLugares')->find(1);
            //Grupo por default (Es el de ID = 1)
            $Grupo = $em->getRepository('LibreameBackendBundle:LbGrupos')->find(1);
            //Valida que el usuario no existe
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->findOneBy(array('txusuemail' => $pSolicitud->getEmail()))){
                try {
                    //Guarda el usuario
                    //echo "<script>alert('Usuario [".$pSolicitud->getEmail()." ] NO existe')</script>";
                    $usuario=$usuario->creaUsuario($pSolicitud, $Lugar);

                    //Guarda el dispositivo si NO existe: debe existir el ID + Usuario 
                    //porque se pueden registrar y operar desde el mismo Dispositivo
                    //echo "<script>alert('Evalua si dispositivo existe')</script>";
                    $guardadevice=0;
                    if (!$em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                            'txdisid' => $pSolicitud->getDeviceMAC(), 
                            'indisusuario' => $usuario))){
                        //echo "<script>alert('Dispositivo [".$pSolicitud->getDeviceMAC()."-guardadevice".$guardadevice." ] NO existe')</script>";
                        $guardadevice=1;

                        $device=$device->creaDispusuario($usuario, $pSolicitud);
                    }

                    //Guarda la membresia al grupo default
                    $membresia->setInmemusuario($usuario);
                    $membresia->setInmemgrupo($Grupo);

                    //Guarda la información
                    //echo "<script>alert('Persiste usuario')</script>";
                    $em->persist($usuario);
                    $em->flush();
                    //Si el dispositivo existia no se guarda y se trae del repositorio
                    if($guardadevice===1){
                        //echo "<script>alert('Persiste device')</script>";
                        $em->persist($device);
                        $em->flush();
                    } else {
                        $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                            'txdisid' => $pSolicitud->getDeviceMAC(), 
                            'indisusuario' => $usuario));
                    }
                        
                    //echo "<script>alert('Persiste membresia')</script>";
                    $em->persist($membresia);
                    $em->flush();
                    //Guarda la sesion inactiva
                    //echo "<script>alert('Guardó usuario...va a generar sesion ')</script>";
                    setlocale (LC_TIME, "es_CO");
                    $fecha = date('c');
                    //echo "<script
                    //>alert('".$fecha."')</script>";
                    
                    $sesion = $objAcceso::generaSesion(AccesoController::inDatoCer,$fecha,$fecha,$device,$pSolicitud->getIPaddr());
                    //Guarda la actividad de la sesion:: Como finalizada
                    //echo "<script>alert('Guardó usuario...va a generar sesion ')</script>";
                    $actsesion = $objAcceso::generaActSesion($sesion,AccesoController::inDatoUno,AccesoController::txMensaje,$pSolicitud->getAccion(),$fecha,$fecha);
                    //echo "<script>alert('Generó actividad de sesion ')</script>";

                    //Envia email
                    $mailsent = $objAcceso::enviaMailRegistro($usuario);
                    //echo "<script>alert('Envió mail ')</script>";
                    
                    $respuesta->setRespuesta(AccesoController::inExitoso);
                    
                    //echo "<script>alert('Respuesta de registro NORMAL ".$respuesta->getRespuesta()." Error')</script>";
                    return Logica::generaRespuesta($respuesta, $pSolicitud, NULL);
                } catch (Exception $ex) {
                    $respuesta->setRespuesta(AccesoController::inDescone);
                    return Logica::generaRespuesta($respuesta, $pSolicitud, NULL);
                } 

            } else {
                //El usuario existe y no es posible registrarlo de nuevo:: el email.
                //echo "<script>alert('Usuario existe')</script>";
                $respuesta->setRespuesta(AccesoController::inFallido);
                return Logica::generaRespuesta($respuesta, $pSolicitud, NULL);
            }
            
        } catch (Exception $ex) {
            //echo "<script>alert('Respuesta de registro ERROR ".$respuesta->getRespuesta()." Error')</script>";
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            return Logica::generaRespuesta($respuesta, $pSolicitud, NULL);
        } 
        
        
    }
    
    
    
    
}
