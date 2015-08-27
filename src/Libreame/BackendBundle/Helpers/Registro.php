<?php


namespace Libreame\BackendBundle\Helpers;

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
    //Constantes globales
    const inFallido =  0; //Proceso fallido por usuario existente
    const inDescone = -1; //Proceso fallido por conexión de plataforma
    const inExitoso =  1; //Proceso existoso
    const inDatoCer =  0; //Valor cero: Sirve para los datos Inactivo, Cerrado etc del modelo
    const inDatoUno =  1; //Valor Uno: Sirve para los datos Activo, Abierto, etc del modelo
    const inGenSinE =  2; //Genero del usuario: Sin especificar
    const inGenFeme =  1; //Genero del usuario: Femenino
    const inGenMasc =  0; //Genero del usuario: Masculino
    const inTamVali =  40; //Tamaño del ID para confirmacion del Registro
    const inTamSesi =  30; //Tamaño del id de sesion generado
    const txMensaje =  'Solicitud de registro de usuario en Ex4Read'; //Mensaje estandar para el registro de usuario

    public function registroUsuario($pSesion)
    {   
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
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->findOneBy(array('txusuemail' => $pSesion->getEmail()))){
                try {
                    //Guarda el usuario
                    echo "<script>alert('Usuario NO existe')</script>";
                    $usuario->setTxusuemail($pSesion->getEmail());  
                    $usuario->setTxusutelefono($pSesion->getTelefono());  
                    $usuario->setTxusunombre($pSesion->getUsuario());  
                    $usuario->setTxusuimagen('DEFAUL IMAGE URL');  
                    $usuario->setInusulugar($Lugar);  
                    $usuario->setTxusuvalidacion(Logica::generaRand(self::inTamVali));  

                    //Guarda el dispositivo si NO existe
                    echo "<script>alert('Evalua si dispositivo existe')</script>";
                    $guardadevice=0;
                    if (!$em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(
                            array('txdisid' => $pSesion->getDeviceMAC()))){
                        echo "<script>alert('Dispositivo [".$pSesion->getDeviceMAC()."-guardadevice".$guardadevice." ] NO existe')</script>";
                        $guardadevice=1;
                        $device->setIndisusuario($usuario);
                        $device->setTxdisid($pSesion->getDeviceMAC());
                        $device->setTxdismarca($pSesion->getDeviceMarca());
                        $device->setTxdismodelo($pSesion->getDeviceModelo());
                        $device->setTxdisso($pSesion->getDeviceSO());
                    } else {
                        echo "<script>alert('Dispositivo [".$pSesion->getDeviceMAC()."-guardadevice".$guardadevice." ] existe')</script>";
                    }

                    //Guarda la membresia al grupo default
                    $membresia->setInmemusuario($usuario);
                    $membresia->setInmemgrupo($Grupo);

                    //Guarda la información
                    echo "<script>alert('Persiste usuario')</script>";
                    $em->persist($usuario);
                    $em->flush();
                    //Si el dispositivo existia no se guarda y se trae del repositorio
                    if($guardadevice===1){
                        echo "<script>alert('Persiste device')</script>";
                        $em->persist($device);
                        $em->flush();
                    } else {
                        $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array('txdisid' => $pSesion->getDeviceMAC()));
                    }
                        
                    echo "<script>alert('Persiste membresia')</script>";
                    $em->persist($membresia);
                    $em->flush();
                    //Guarda la sesion inactiva
                    //echo "<script>alert('Guardó usuario...va a generar sesion ')</script>";
                    setlocale (LC_TIME, "es_CO");
                    $fecha = date('c');
                    //echo "<script
                    //>alert('".$fecha."')</script>";
                    
                    $sesion = $objAcceso::generaSesion(self::inDatoCer,$fecha,$fecha,$device,$pSesion->getIPaddr());
                    //Guarda la actividad de la sesion:: Como finalizada
                    //echo "<script>alert('Guardó usuario...va a generar sesion ')</script>";
                    $actsesion = $objAcceso::generaActSesion($sesion,self::inDatoUno,self::txMensaje,$pSesion->getAccion(),$fecha,$fecha);
                    echo "<script>alert('Generó actividad de sesion ')</script>";

                    //Envia email
                    $mailsent = $objAcceso::enviaMailRegistro($usuario);
                    //echo "<script>alert('Envió mail ')</script>";
                    
                    return Registro::generaRespuesta(self::inExitoso, $pSesion);
                    
                } catch (Exception $ex) {
                    return Registro::generaRespuesta(self::inDescone, $pSesion);
                } 

            } else {
                //El usuario existe y no es posible registrarlo de nuevo:: el email.
                echo "<script>alert('Usuario existe')</script>";
                return Registro::generaRespuesta(self::inFallido, $pSesion);
            }
        } catch (Exception $ex) {
            echo "<script>alert('Registro Error')</script>";
            return Registro::generaRespuesta(self::inFallido, $pSesion);
        }    
        
    }
    
    private function generaRespuesta($idrespuesta, $pSesion){
        $JSONResp = array(array('idsesion' => array ('idaccion' => $pSesion->getAccion(),
            'usuario' => $pSesion->getUsuario(),
            'idtrx' => $pSesion->getSession(), 'ipaddr'=> $pSesion->getIPaddr(), 
            'iddevice'=> $pSesion->getDeviceMac(), 'marca'=>$pSesion->getDeviceMarca(), 
            'modelo'=>$pSesion->getDeviceModelo(), 'so'=>$pSesion->getDeviceSO()
            )), 
            array('idrespuesta' => array('respuesta' => $idrespuesta)));
        $JSONResp = json_encode($JSONResp);
        return $JSONResp;
    }
    
}
