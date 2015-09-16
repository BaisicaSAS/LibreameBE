<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;

use Libreame\BackendBundle\Repository\ManejoDataRepository;
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
        $objLogica = $this->get('logica_service');
        //echo "<script>alert('Ingresa Registro')</script>";
        //$em = $this->getDoctrine()->getManager();
        $usuario = new LbUsuarios();
        $device = new LbDispusuarios();
        $membresia = new LbMembresias();
        $sesion = new LbSesiones();
        $actsesion = new LbActsesion();


        //Lugar por default (Es el de ID = 1)
        $Lugar = ManejoDataRepository::getLugar(1);
        //Grupo por default (Es el de ID = 1)
        $Grupo = ManejoDataRepository::getGrupo(1);
        //Valida que el usuario no existe
        if (!ManejoDataRepository::getUsuarioByEmail($pSolicitud->getEmail()) and 
            !ManejoDataRepository::getUsuarioByTelefono($pSolicitud->getTelefono())){
            try {
                //Guarda el usuario
                //echo "<script>alert('Usuario [".$pSolicitud->getEmail()." ] NO existe')</script>";
                $usuario=$usuario->creaUsuario($pSolicitud, $Lugar);

                //Guarda el dispositivo si NO existe: debe existir el ID + Usuario 
                //porque se pueden registrar y operar desde el mismo Dispositivo
                //echo "<script>alert('DISPOSITIVO')</script>";
                $guardadevice=0;
                if (!ManejoDataRepository::getDispositivoUsuario($pSolicitud->getDeviceMAC(), $usuario)){
                    //echo "<script>alert('Dispositivo [".$pSolicitud->getDeviceMAC()."-guardadevice".$guardadevice." ] NO existe')</script>";
                    $guardadevice=1;

                    $device=$device->creaDispusuario($usuario, $pSolicitud);
                }

                //Guarda la membresia al grupo default
                $membresia->setInmemusuario($usuario);
                $membresia->setInmemgrupo($Grupo);
                //echo "<script>alert('MEMBRESIA')</script>";
                
                //throw $this->createNotFoundException('Error de registros');
                //Guarda la información
                //$em->persist($usuario);
                //$em->flush();
                ManejoDataRepository::persistEntidad($usuario);
                //echo "<script>alert('Persiste usuario')</script>";
                //Si el dispositivo existia no se guarda y se trae del repositorio
                if($guardadevice===1){
                    //echo "<script>alert('Persiste device')</script>";
                    ManejoDataRepository::persistEntidad($device);
                    //$em->persist($device);
                    //$em->flush();
                } else {
                    $device = ManejoDataRepository::getDispositivoUsuario($pSolicitud->getDeviceMAC(), $usuario);
                }

                //echo "<script>alert('Persiste membresia')</script>";
                ManejoDataRepository::persistEntidad($membresia);
                //$em->persist($membresia);
                //$em->flush();
                //Guarda la sesion inactiva
                //echo "<script>alert('Guardó usuario...va a generar sesion ')</script>";
                setlocale (LC_TIME, "es_CO");
                $fecha = new \DateTime('c');
                //echo "<script>alert('fecha ')</script>";

                $sesion = ManejoDataRepository::generaSesion(AccesoController::inDatoCer,$fecha,$fecha,$device,$pSolicitud->getIPaddr());
                //echo "<script>alert('Generó sesion ')</script>";
                //Guarda la actividad de la sesion:: Como finalizada
                ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,AccesoController::txMensaje,$pSolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";

                //Envia email
                $objLogica::enviaMailRegistro($usuario);
                //echo "<script>alert('Envió mail ')</script>";

                $respuesta->setRespuesta(AccesoController::inExitoso);
                
                //echo "<script>alert('Respuesta de registro NORMAL ".$respuesta->getRespuesta()." Error')</script>";
                return $objLogica::generaRespuesta($respuesta, $pSolicitud, NULL);

            } catch (Exception $ex) {
                //echo "<script>alert('Respuesta de registro ERROR ".$respuesta->getRespuesta()." Error')</script>";
                $respuesta->setRespuesta(AccesoController::inPlatCai);
                return $objLogica::generaRespuesta($respuesta, $pSolicitud, NULL);
            } 
        } else {
            //El usuario existe y no es posible registrarlo de nuevo:: el email.
            //echo "<script>alert('Usuario existe')</script>";
            $respuesta->setRespuesta(AccesoController::inFallido);
            return $objLogica::generaRespuesta($respuesta, $pSolicitud, NULL);
        }
            
    }
    
    
    
    
}
