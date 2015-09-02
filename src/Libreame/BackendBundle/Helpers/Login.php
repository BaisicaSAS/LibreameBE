<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbMembresias;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;


class Login 
{   
    /*
     * Esta funcion ejecuta la aacion necesaria para crear/Cerrar una sesión de un usuario en la plataforma::: 
     * Login del usuario, Logout del usuario
     * 
     * Retorna: ***JSONData(IDSESION)*** = 1. Opción Solicitada=C02  -  2. Usuario=Usuario digitado  -  
     * 3.Sesión=NULL  -  4.IP=Del dispositivo  -  5.Dispositivo=Id del dispositivo: MAC  -  
     * 6.Marca=Marca del dispositivo  -  7.Modelo=Modelo del dispositivo  -  
     * 8. SO=Sistema operativo del dispositivo         
     * ***     JSONData (IDRESPUESTA)  ***  =  
     * 1.Respuesta: (0: si el usuario o la clave son inválidos; 
     *              Retorna -1: Si no se pudo loguear por disponibilidad de la plataforma;  == -1
     *              Retorna 1 : si se logró el login. El id de la sesión se persiste en la base de datos.  
     *              Retorna -2 Si el usuario tiene una sesión activa   
     *              Retorna -3 si la sesion es sospechosa de ser ataque, 
     *              Retorna -4 Si el usuario no está activo o esta en espera de confirmación de registro)  
     * 2. IdSesion La sesión de arriba no se utiliza, la sesión creada se envía en este campo, si se generó alguna
     * 3. nummensajes: Cantidad de mensajes nuevos
     *  
     * 
     * Estados del usuario: 0: Esperando confirmación 1: Activo 2: Cuarentena 3: Inactivo
     * Valida:
     *  1. Usuario existe y la clave es valida
     *  2. Si el usuario está activo (Solo puede estar en estado 1)
     *  2. DESPUES:::Dispositivo registrado??:::Se valida si el dispositivo es aquel que el usuario acostumbra a utilizar
     *  3. Usuario tiene sesión activa....si es así retorna -2 y aborta
     * 
     * 
     */
    
    //Constantes de la funcion
    const inUsClInv =  0;  //Usuario o clave inválidos
    const inULogged =  1;  //Usuario logeado exitosamente
    const inPlatCai = -1; //Proceso fallido por conexión de plataforma
    const inUSeActi = -2; //Usuario tiene sesion activa
    const inSosAtaq = -3; //Sesion sospechosa de ser ataque ::: AUN NO SE IMPLEMENTA
    const inUsInact = -4; //Usuario inactivo

    public function loginUsuario($pSolicitud)
    {   
        $respuesta = new Respuesta();
        $objAcceso = $this->get('acceso_service');
        $fecha = new \DateTime;
        setlocale (LC_TIME, "es_CO");
        $fecha = date('c');
        try {
            //echo "<script>alert('Ingresa Login')</script>";
            $em = $this->getDoctrine()->getManager();
            $usuario = new LbUsuarios();
            $device = new LbDispusuarios();
            $sesion = new LbSesiones();
            $actsesion = new LbActsesion();
            //Verifica si el usuario existe
            //echo "<script>alert('Mail usuario ".$pSolicitud->getEmail()."')</script>";
            if ($em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $pSolicitud->getEmail()))){
                
                $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('txusuemail' => $pSolicitud->getEmail()));

                $estado = $usuario->getInusuestado();
                //echo "<script>alert('-----Estado usuario ".$estado."')</script>";

                //Verifica si el usuario está activo
                if ($estado == AccesoController::inUsuActi)
                {
                    
                    //Verifica si la clave es correcta
                    if ($usuario->getTxusuclave() == $pSolicitud->getClave()){
                        //Verifica si el usuario tiene una sesion activa
                        if (AccesoController::usuarioSesionActiva($pSolicitud)){
                            $respuesta->setRespuesta(self::inUSeActi);
                        }
                        else
                        {
                            //AQUI SE LOGUEA FINALMENTE
                            //Busca el dispositivo
                            $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->
                                    findOneBy(array('indisusuario' => $usuario));
                
                            //echo "<script>alert('Dispositivo ".$device->getTxdisid()."')</script>";

                            //Crea sesion
                            //echo "<script>alert('-----Creará sesion')</script>";
                            $sesion = $objAcceso::generaSesion(AccesoController::inSesActi,$fecha,NULL,$device,$pSolicitud->getIPaddr());
                            //Genera sesion activa sin fecha de finalización
                            $actsesion = $objAcceso::generaActSesion($sesion,AccesoController::inDatoUno,'Login usuario '.$usuario->getTxusuemail().' exitoso',$pSolicitud->getAccion(),$fecha,NULL);
                            $respuesta->setRespuesta(self::inULogged);    
                            $respuesta->setSession($sesion->getTxsesnumero());  
                            
                            //Busca la cantidad de mensajes del usuario sin leer 
                            $respuesta->setCantMensajes($usuario->cantMsgUsr($usuario));    
                            
                        }
                    }
                    //Clave incorrecta
                    else{$respuesta->setRespuesta(self::inUsClInv);}    
                }
                //Usuario no está activo
                else {$respuesta->setRespuesta(self::inUsInact);}

            }
            //Usuario no existe
            else {$respuesta->setRespuesta(self::inUsClInv);}
            
            return Logica::generaRespuesta($respuesta, $pSolicitud);
            
        }
        catch (Exception $ex) {
            $respuesta->setRespuesta(self::inPlatCai);
            return Logica::generaRespuesta($respuesta, $pSolicitud);
        }     
        
    }
    
}

