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
     */
    //Constantes globales
    const inFallido =  0; //Proceso fallido por calidad de datos
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


            //Lugar por default
            $Lugar = $em->getRepository('LibreameBackendBundle:LbLugares')->find(1);
            //Grupo por default
            $Grupo = $em->getRepository('LibreameBackendBundle:LbGrupos')->find(1);
            //Valida que el usuario no existe
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->findOneBy(array('txusuemail' => $pSesion->getUsuario()))){
                try {
                    //Guarda el usuario
                    $usuario->setTxusuemail($pSesion->getUsuario());  
                    $usuario->setTxusutelefono($pSesion->getTelefono());  
                    $usuario->setTxusunombre($pSesion->getUsuario());  
                    $usuario->setTxusuimagen('DEFAUL IMAGE URL');  
                    $usuario->setInusulugar($Lugar);  
                    $usuario->setTxusuvalidacion(Logica::generaRand(self::inTamVali));  

                    //Guarda el dispositivo
                    $device->setIndisusuario($usuario);
                    $device->setTxdisid($pSesion->getDevice());

                    //Guarda la membresia al grupo default
                    $membresia->setInmemusuario($usuario);
                    $membresia->setInmemgrupo($Grupo);

                    //Guarda la información
                    $em->persist($usuario);
                    $em->flush();
                    $em->persist($device);
                    $em->flush();
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
                    //echo "<script>alert('Generó actividad de sesion ')</script>";

                    //Envia email
                    $objAcceso::enviaMailRegistro($usuario);
                    //echo "<script>alert('Envió mail ')</script>";
                    
                    return self::inExitoso;
                } catch (Exception $ex) {
                    return self::inDescone;
                } 

            } else {
                //El usuario existe y no es posible registrarlo de nuevo:: el email.
                return self::inFallido;
            }
        } catch (Exception $ex) {
            echo "<script>alert('Registro Error')</script>";
        }    
        
    }
    
    /*
     * enviaMailRegistro 
     * Se encarga de enviar el email con el que el usuario confirmara su registro
     */
    private function enviaMailRegistro($usuario)
    {   
        $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject('Bienvenido a Libreame '.$this->getUsuario())
                ->setFrom('baisicasas@gmail.com')
                ->setTo($this->getUsuario())
                ->setBody($usuario->gettxusuvalidacion());

        $this->get('mailer')->send($message);
    }
}
