<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
use Libreame\BackendBundle\Helpers\Solicitud;


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
    const txMensaje =  'Solicitud de registro de usuario en Libreame'; //Mensaje estandar para el registro de usuario

    var $objSesion;
    /*
     * IngresarSistema es la UNICA funcion que recibe la información desde el cliente, para revisar y despachar
     * Recibe un JSON, con la estructura definida como default mas los datos especificos de cada opcion.
     * 
     * @TODO: Es la mas importante para la integración con otros sistemas:: 
     * Cualquier aplicación -por lo pronto las nuestras- solo acceden por esta funcion, el resto de 
     * funciones del sistema son privadas

     * La funcion recibe los datos de la interacción con el cliente.
     * Su funcion es obtener la información de Usuario, Session y Opciones, validar que sean correctos o que 
     * no estén repetidos. Registra el intento de acceso, valida los datos adicionales con respecto
     * a la accion solicitada y en caso de estar todo en orden enviar la información a la Clase Logica para 
     * que realice los solicitado y emita las respuestas al cliente
     */
    public function ingresarSistemaAction($datos)
    {   
        $respuesta = 0;
        $fecha = new \DateTime;
        $texto = $fecha->format('YmdHis');
        //echo "<script>alert('".substr($datos,0,4)."---".substr($datos,4,2)."')</script>";
        $modo = substr($datos,0,4);
        $idreg = substr($datos,4,4);
        try {
            //Este bloque es solo de Prueba
            if ($modo == 'TEST') {
                //echo "<script>alert('Reconoce prueba')</script>"; 
                $prueba = array(array('idsesion' => array ('idaccion' => 'C01','usuario' => $idreg.'-alexviatela',
                    'idtrx' => $idreg.'-123456789012345'.$texto, 'ipaddr'=> '200.000.000.000', 
                    'iddevice'=> 'MACADDRESS', 'marca'=>'LG', 'modelo'=>'G2 Mini', 'so'=>'KITKAT',
                    )), 
                    array('idsolicitud' => array('email' => $idreg.'alexviatela@gmail.com',
                        'clave' => 'clave12345', 'telefono' => $idreg."-".$texto)));
                $datos = json_encode($prueba);
                //echo "<script>alert('".$datos."')</script>";
            }

            //Aquí iniciaría el código en producción, el bloque anterior solo funciona para TEST
            //Se evalúa si se logró obtener la información de sesion desde el JSON
            $jsonValido = $this->descomponerJson($datos);
            //echo "<script>alert('Validación retornó: ".$jsonValido."')</script>"; 
            
            if ($jsonValido != false) {
                $objLogica = $this->get('logica_service');
                $respuesta = $objLogica::ejecutaAccion($datos, $this->objSesion);
            } else {
                //echo "<script>alert('Encontramos un problema con tu registro: ".$this->$objSesion->getSession()."-".$jsonValido."')</script>"; 
                //@TODO: Debemos revisar que hacer cuando se detecta actividad sospechosa: Cierro sesion?. Bloqueo usuario e informo?
            }
            //echo "<script>alert('RESPUESTA ingresarSistemaAction: ".$respuesta."')</script>"; 
            return new RESPONSE("Normal ".$respuesta);
                    
        } catch (Exception $ex) {
            return new RESPONSE("Catch ".$jsonValido);
        }    
             
    }
    
    /*
     * Descomponer: 
     * Funcion que extrae la informacion del JSON de ingresar
     * 1. Opción Solicitada
     * 2. Usuario
     * 3. Sesión
     * 4. IP
     * 5. Id del dispositivo: MAC
     * 6. Marca del dispositivo
     * 7. Modelo del dispositivo
     * 8. Sistema operativo del dispositivo 
     * {"idsesion":{["idaccion": "accion", "usuario": "usuario", "idtrx": "sesion", "ipaddr": "IP Address", 
     *              "iddevice": "MAC Dispositivo", "marca": "Marca Dispositivo", "modelo": "Modelo Dispositivo", 
     *              "so": "Sistema operativo Dispositivo"]},
     * 
     *  "idsolicitud":{[]}
     * }
     */
    private function descomponerJson($datos)
    {   $resp = self::inFallido;
        try {
            $json_datos = json_decode($datos, true);
            //echo "<script>alert('Inicia a decodificar-----".$json_datos[0]['idsesion']['idtrx']."')</script>"; 
            $this->objSesion = new Solicitud();
            //echo "<script>alert(':::TRANS: ".$json_datos[0]['idsesion']['idtrx']."')</script>"; 
            $this->objSesion->setAccion($json_datos[0]['idsesion']['idaccion']);
            $this->objSesion->setUsuario($json_datos[0]['idsesion']['usuario']);
            $this->objSesion->setSession($json_datos[0]['idsesion']['idtrx']);
            $this->objSesion->setIPaddr($json_datos[0]['idsesion']['ipaddr']);
            $this->objSesion->setDeviceMAC($json_datos[0]['idsesion']['iddevice']);
            $this->objSesion->setDeviceMarca($json_datos[0]['idsesion']['marca']);
            $this->objSesion->setDeviceModelo($json_datos[0]['idsesion']['modelo']);
            $this->objSesion->setDeviceSO($json_datos[0]['idsesion']['so']);
            //Según la solicitud descompone el JSON
            $tmpSesion = $this->objSesion->getAccion();
            switch ($tmpSesion){
                case \Libreame\BackendBundle\Helpers\Logica::txAccRegistro: {
                    $this->objSesion->setEmail($json_datos[1]['idsolicitud']['email']);
                    $this->objSesion->setClave($json_datos[1]['idsolicitud']['clave']);
                    $this->objSesion->setTelefono($json_datos[1]['idsolicitud']['telefono']);
                }
            }
            //echo "<script>alert('SESION: ".$this->objSesion->getSession().": Finalizó')</script>"; 
            $resp = self::inExitoso;
            //echo "<script>alert('Decodificó e instació el objeto')</script>"; 
            return $resp;
        } catch (Exception $ex) {
        } finally {
            return $resp;
        }    
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
    public function generaSesion($pEstado,$pFecIni,$pFecFin,$pDevice,$pIpAdd)
    {
        //Guarda la sesion inactiva
        //echo "<script>alert('Ingresa a generar sesion".$pFecFin."-".$pFecIni."')</script>";
        try{
            $objLogica = $this->get('logica_service');
            $em = $this->getDoctrine()->getManager();
            $sesion = new LbSesiones();
            $sesion->setInsesactiva($pEstado);
            $sesion->setTxsesnumero($objLogica::generaRand(self::inTamSesi));
            $sesion->setFesesfechaini(new \DateTime($pFecIni));
            $sesion->setFesesfechafin(new \DateTime($pFecFin));
            $sesion->setInsesdispusuario($pDevice);
            $sesion->setTxipaddr($pIpAdd);
            $em->persist($sesion);
            //echo "<script>alert('Guardo sesion')</script>";
            $em->flush();
            //echo "<script>alert('Retorna".$sesion->getTxsesnumero()."')</script>";
            return $sesion;
            
        } catch (Exception $ex) {
                //echo "<script>alert('Error guardar sesion')</script>";
                return self::inDescone;
        } 
    }
    /*
     * GeneraActSesion 
     */
    public function generaActSesion($pSesion,$pFinalizada,$pMensaje,$pAccion,$pFecIni,$pFecFin)
    {
        //Guarda la sesion inactiva
        //echo "<script>alert('Ingresa a generar actividad de sesion".$pFecFin."-".$pFecIni."')</script>";
        try{
            $em = $this->getDoctrine()->getManager();
            
            //echo "<script>alert('::::Actividad Sesion".$pFecFin."-".$pFecIni."')</script>";
            $actsesion = new LbActsesion();
            //$actsesion->setInactsesiondisus($pSesion->getInsesdispusuario());
            $actsesion->setInactsesiondisus($pSesion);
            $actsesion->setTxactaccion($pAccion);
            $actsesion->setFeactfecha($pSesion->getFesesfechaini());
            $actsesion->setInactfinalizada($pFinalizada);
            $actsesion->setTxactmensaje($pMensaje);
            $em->persist($actsesion);
            $em->flush();

            return $actsesion;
            
        } catch (Exception $ex) {
                return self::inDescone;
        } 
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
                
                return self::inExitoso;
                
            } catch (Exception $ex) {
                return self::inFallido;
            }     
           
        } catch (Exception $ex) {
            return self::inDescone;
        }     
    }
    
    /*
     * enviaMailRegistro 
     * Se encarga de enviar el email con el que el usuario confirmara su registro
     */
    public function enviaMailRegistro($usuario)
    {   
        $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject('Bienvenido a ex4Read '.$usuario->getTxusunombre())
                ->setFrom('baisicasas@gmail.com')
                ->setTo($usuario->getTxusuemail())
                ->setBody($usuario->gettxusuvalidacion());

        $this->get('mailer')->send($message);
        
        return 0;
    }
}
