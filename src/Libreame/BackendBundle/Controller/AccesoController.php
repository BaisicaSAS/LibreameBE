<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Libreame\BackendBundle\Entity\LbActsesion;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Entity\LbMembresias;
//use Libreame\BackendBundle\Entity\LbUsuarios;
use Symfony\Component\Serializer\Encoder\JsonDecode;
//use Symfony\Component\Serializer\Encoder\JsonEncode;
//use Symfony\Component\Serializer\Encoder\JsonDecoder;
//use Symfony\Component\Serializer\Encoder\JsonEncoder;

/*
 * Controlador que contiene las funciones que validan, controlan y despachan 
 * el acceso a todas las url. Esto implica la generacion y validacion de Tokens
 * Las funciones involucradas:
 * GenerarSesion / EliminarSesion / VerificarAcceso / DespacharOpcion / Cifrar-Descifrar comunicaciones
 * Alta y Baja de usuarios / Recuperacion y cambio de clave
 * 
 * La información que recibe en formato JSON es la siguiente:
 * 
 * 
 *  
 */
class AccesoController extends Controller
{   
    var $inFallido =  0; //Proceso fallido por calidad de datos
    var $inDescone = -1; //Proceso faiilido por conexión de plataforma
    var $inExitoso =  1; //Proceso existoso
    
    private $pSession;
    private $pIDSession;
    private $pFechaHora;
    private $pDevice;
    private $pIDDevice;
    private $pIPaddr;
    private $pAccion;
    private $pUsuario;
    private $pIDUsuario;
    private $pClave;
    private $pTelefono;

    /*
     *  Bloque de getter para los atributos de la clase
     */
    public function getSession() {
        return $this->pSession;
    }

    public function getIDSession() {
        return $this->pIDSession;
    }

    public function getFechaHora() {
        return $this->pFechaHora;
    }

    public function getDevice() {
        return $this->pDevice;
    }

    public function getIDDevice() {
        return $this->pIDDevice;
    }

    public function getIPaddr() {
        return $this->pIPaddr;
    }

    public function getAccion() {
        return $this->pAccion;
    }

    public function getUsuario() {
        return $this->pUsuario;
    }

    public function getIDUsuario() {
        return $this->pIDUsuario;
    }

    public function getClave() {
        return $this->pClave;
    }

    public function getTelefono() {
        return $this->pTelefono;
    }


    /*
     * Ingresar es la funcion que recibe la información desde el cliente, para revisar y despachar
     * Recibe un JSON, con la estructura definida como default mas los datos especificos de cada opcion.
     * 
     * @TODO: Es la mas importante para la integración con otros sistemas::
     */
    public function ingresarSistemaAction($datos)
    {
        //Se evalúa si se logró obtener la información de sesion desde el JSON
        if (descomponerJson($datos) != false) {
            switch ($this->getAccion()){
                case 1: return $this->registroUsuario();
            }
        } else {
            return false;
        }
    }
    /*
     * Descomponer: 
     * Funcion que extrae la informacion del JSON de ingresar
     * {"idsesion":{["idtrx": "ses", "fecha": "fechahora", "device": "Dispositivo", "ipaddr": "IP Address", 
     *               "idaccion": "accion", "usuario": "usuario", "idusuario": "clave", "telefono": "telefono"]},
     * 
     *  "data":{[]}
     * }
     */
    private function descomponerJson($datos)
    {
        try {
            $json_datos = JsonDecode($datos);
            $this->pSession = $json_datos['idsesion']['idtrx'];
            $this->pFechaHora = $json_datos['idsesion']['fecha'];
            $this->pDevice = $json_datos['idsesion']['device'];
            $this->pIPaddr = $json_datos['idsesion']['ipaddr'];
            $this->pAccion = $json_datos['idsesion']['idaccion'];
            $this->pUsuario = $json_datos['idsesion']['usuario'];
            $this->pClave = $json_datos['idsesion']['clave'];
            $this->pTelefono = $json_datos['idsesion']['telefono'];
            $em = $this->getDoctrine()->getManager();
            $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->findOneBy(array('txusunommostrar' => $this->pUsuario));
            if (!$usuario) {
                $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->findOneBy(array('txusuemail' => $this->pUsuario));
            }
            $this->pIDUsuario = $usuario->getInusuario();
            
            //Valido que todos los datos de SESION son correctos. Aquí es donde efectivamente nos percatamos 
            //de que estamos siendo requeridos por un usuario válido
            //if(validaSesion()){
            // 
            //      Dispara la funcion que el usuario seleccionó según el parametro "pAccion"
            //      switch ($this->pAccion){
            //        case 0: 
            //        case 0:
            //      }
            //}
            return $this;
        } catch (Exception $ex) {
            if($ex->getMessage() == ''){return $this->inFallido;}    
            else {return $this->inDescone;}
        }     
    }
    
    /*
     * registro 
     * Esta es la funcion que genera el registro de un usuario en el sistema
     * guarda los datos básicos, genera una clave (url) dispara el envío de email de 
     * Confirmacion, retorna mensaje de exito o fracaso de operacion para el cliente 
     * y registra en la bitácora.
     */
    private function registroUsuario()
    {   
        $em = $this->getDoctrine()->getManager();
        $usuario = new LbUsuarios();
        $device = new LbDispusuarios();
        $membresia = new LbMembresias();
        //Lugar por default
        $Lugar = $em->getRepository('LibreameBackendBundle:LbLugares')->find(1);
        //Grupo por default
        $Grupo = $em->getRepository('LibreameBackendBundle:LbGrupos')->find(1);
        //Valida que el usuario no existe
        if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->findOneBy(array('txusuemail' => $this->getUsuario()))){
            try {
                //Guarda el usuario
                $usuario->setTxusuemail($this->getUsuario());  
                $usuario->setTxusutelefono($this->getTelefono());  
                $usuario->setTxusunombre($this->getUsuario());  
                $usuario->setTxusuimagen('DEFAUL IMAGE URL');  
                $usuario->setInusulugar($Lugar);  
                $usuario->setTxusuvalidacion('Url para validar');  

                //Guarda el dispositivo
                $device->setIndisusuario($usuario);
                $device->setTxdisid($this->getDevice());
                
                //Guarda la membresia al grupo default
                $membresia->setInmemusuario($usuario);
                $membresia->setInmemgrupo($Grupo);
                
                $em->persist($usuario);
                $em->flush();
                $em->persist($device);
                $em->flush();
                $em->persist($membresia);
                $em->flush();
                //Envia email
                $this->enviaMailRegistro($usuario);
                return $this->inExitoso;
            } catch (Exception $ex) {
                return $this->inDescone;
            } 
                
        } else {
            //El usuario existe y no es posible registrarlo de nuevo:: el email.
            return $this->inFallido;
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
    
    /*
     * validaSesion 
     * Valida los datos de la sesion verificando que sea veridica
     * Credenciales está compuesto por: 1.usr,2.pass,3-device,4.session,5-opcion a despachar,
     * parametros para la url a despachar, cantidad de caracteres de cada uno 
     * de los anteriores cada uno con 4 digitos.
     * 
     */
    private function validaSesion()
    {   
        $sesion = $em->getRepository('LibreameBackendBundle:LbSesiones')->findBy(array(
            'txsesnumero' =>  $this->getSession(),
            'insesdispusuario' => $this->getIDDevice(),
            'insesactiva' => '1'));
        
        return ($sesion);
    }
    /*
     * GeneraSesion 
     * Guarda en BD y Devuelve el ID de la sesion
     * Recibe una cadena con los datos del usuario
     * Usuario/Password{cifrado}/FechaHora{Esta se guarda en el dispositivo para que sirva como clave}
     * Id/nombre dispositivo
     *  
     */
    private function generaSesion($credenciales)
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $credenciales));
    }
    /*
     * eliminaSesion 
     *  Elimina una sesion 
     */
    private function eliminaSesion($credenciales)
    {
        return $this->render('LibreameBackendBundle:Default:index.html.twig', array('name' => $credenciales));
    }
    /*
     * registraActSesion 
     *  registra cada una de las acciones realizadas por un usuario
     */
    private function registraActSesion()
    {
        try{
            $em = $this->getDoctrine()->getManager();
            
            try{
                $tabla = new LbActsesion();
                $tabla->setFeactfecha(TODAY);
                $tabla->setInactaccion($this->getAccion());
                $tabla->setInactfinalizada(TODAY);
                $tabla->setInactsesiondisus($this->getIDUsuario());

                $em->persist($tabla);
                $em->flush();
                
                return $this->inExitoso;
                
            } catch (Exception $ex) {
                return $this->inFallido;
            }     
           
        } catch (Exception $ex) {
            return $this->inDescone;
        }     
    }
}
