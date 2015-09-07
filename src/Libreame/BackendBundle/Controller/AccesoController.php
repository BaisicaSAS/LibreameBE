<?php

namespace Libreame\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;
use Libreame\BackendBundle\Entity\LbDispusuarios;
use Libreame\BackendBundle\Helpers\Solicitud;
use Libreame\BackendBundle\Helpers\Respuesta;

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
    const txMensaje =  'Solicitud de registro de usuario en Ex4Read'; //Mensaje estandar para el registro de usuario
    //Estados del usuario
    const inUsuConf =  0; //Usuario en proceso de confiormacion de registro
    const inUsuActi =  1; //Usuario Activo
    const inUsuCuar =  2; //Usuario en cuarentena
    const inInactiv =  3; //Usuario inactivo
    //Estados de sesion
    const inSesActi =  1; //Usuario en proceso de confiormacion de registro
    const inSesInac =  0; //Usuario Activo
    
    
    
    //Acciones de la plataforma
    const txAccRegistro =  '1'; //Registro en el sistema
    const txAccIngresos =  '2'; //Login  (Ingreso)
    const txAccRecParam =  '3'; //Recuperar datos y parámetros de usuario: incluye calificaciones
    const txAccRecFeeds =  '4'; //Recuperar Feed (Todas las publicaciones de solicitudes y publicaciones de usuarios)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccRecOpera =  '5'; //Recuperar mi operación (Todas mis solicitudes publicaciones y mensajes)...Lleva una marca de Fecha y hora para recuperar los últimos tipo twitter
    const txAccConfRegi =  '6'; //Confirmacion Registro en el sistema        
    const txAccRecEjemp =  '7'; //Recuperar Ejemplar        
    const txAccRecSolic =  '8'; //Recuperar solicitud
    const txAccRecUsuar =  '9'; //Ver/Recuperar usuario: Incluye su calificacion
    
    const txAccCerraSes =  '10'; //Logout / Cerrar sesion
    const txAccBajaSist =  '11'; //Dar de baja
    const txAccActParam =  '12'; //Actualizar parámetros sistema y datos usuario
    const txAccPubliEje =  '13'; //Publicar un ejemplar
    const txAccModifEje =  '14'; //Modificar un ejemplar
    const txAccElimiEje =  '15'; //Eliminar un ejemplar
    const txAccPubliSol =  '16'; //Publicar una solicitud
    const txAccModifSol =  '17'; //Modificar una solicitud
    const txAccElimiSol =  '18'; //Eliminar una solicitud
    const txAccPubMensa =  '19'; //Enviar un mensaje a una solicitud especifica / Publicar o Responder
    const txAccConcNego =  '20'; //Concretar una negociación: Aceptar un usuario y descartar a los demás
    const txAccDesiNego =  '21'; //Desistir de una negociación ya realizada
    const txAccCaliTrat =  '22'; //Calificar un trato
    const txAccModCalTr =  '23'; //Modificar calificación trato
    const txAccEnviaPQR =  '24'; //Enviar una PQR
    const txAccModifPQR =  '25'; //Modificar una PQR
    const txAccElimiPQR =  '26'; //Eliminar una PQR

    const inUsClInv =  0;  //Usuario o clave inválidos
    const inULogged =  1;  //Usuario logeado exitosamente
    const inPlatCai = -1; //Proceso fallido por conexión de plataforma
    const inUSeActi = -2; //Usuario tiene sesion activa
    const inSosAtaq = -3; //Sesion sospechosa de ser ataque ::: AUN NO SE IMPLEMENTA
    const inUsInact = -4; //Usuario inactivo
    const inUsSeIna = -5; //Sesión inactiva

    var $objSolicitud;
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
     * Tambien es la responsable de generar todas las bitacoras de la aplicación
     */
    public function ingresarSistemaAction()
    {   
        $request = $this->getRequest();
        $content = $request->getContent();
        $datos = json_decode($content, true);
        
        $respuesta = 0;
        $fecha = new \DateTime;
        $texto = $fecha->format('YmdHis');
        try {

            //Aquí iniciaría el código en producción, el bloque anterior solo funciona para TEST
            //Se evalúa si se logró obtener la información de sesion desde el JSON
            $jsonValido = $this->descomponerJson($datos);
            //echo "<script>alert('Validación retornó: ".$jsonValido."')</script>"; 
            
            if ($jsonValido != false) {
                //echo "<script>alert('Ejecuta accion ')</script>"; 
                $objLogica = $this->get('logica_service');
                $respuesta = $objLogica::ejecutaAccion($this->objSolicitud);
            } else {
               //echo "<script>alert('Encontramos un problema con tu registro: ".$this->$objSolicitud->getSession()."-".$jsonValido."')</script>"; 
                //@TODO: Debemos revisar que hacer cuando se detecta actividad sospechosa: Cierro sesion?. Bloqueo usuario e informo?
            }
            //echo "<script>alert('RESPUESTA ingresarSistemaAction: ".$respuesta."')</script>"; 
            return new RESPONSE($respuesta);
            //return new RESPONSE("Normal ".$datos);
                    
        } catch (Exception $ex) {
            return new RESPONSE($jsonValido);
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
            //$json_datos = json_decode($datos, true);
            $json_datos = $datos;
            //echo "<script>alert('Inicia a decodificar-----".$json_datos[0]['idsesion']['idtrx']."')</script>"; 
            $this->objSolicitud = new Solicitud();
            //echo "<script>alert(':::TRANS: ".$json_datos[0]['idsesion']['idtrx']."')</script>"; 
            $this->objSolicitud->setAccion($json_datos['idsesion']['idaccion']);
            $this->objSolicitud->setSession($json_datos['idsesion']['idtrx']);
            $this->objSolicitud->setIPaddr($json_datos['idsesion']['ipaddr']);
            $this->objSolicitud->setDeviceMAC($json_datos['idsesion']['iddevice']);
            $this->objSolicitud->setDeviceMarca($json_datos['idsesion']['marca']);
            $this->objSolicitud->setDeviceModelo($json_datos['idsesion']['modelo']);
            $this->objSolicitud->setDeviceSO($json_datos['idsesion']['so']);
            //Según la solicitud descompone el JSON
            $tmpSesion = $this->objSolicitud->getAccion();
            //echo "<script>alert('ult ejemplar ".$json_datos['idsolicitud']['ultejemplar']."')</script>";
            //echo "<script>alert('sesion ".$tmpSesion."')</script>";
            switch ($tmpSesion){
                case self::txAccRegistro: {
                    //echo "<script>alert('ENTRA POR REGISTR')</script>";
                    $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                    $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                    $this->objSolicitud->setTelefono($json_datos['idsolicitud']['telefono']);
                    break;
                }
                case self::txAccIngresos : {
                    //echo "<script>alert('ENTRA POR LOGIN')</script>";
                    $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                    $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                    break;
                }
                case self::txAccRecParam: {
                    //echo "<script>alert('ENTRA POR OBT PARAM')</script>";
                    $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                    $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                    break;
                }
                case self::txAccRecFeeds: { 
                    //echo "<script>alert('ENTRA POR FEED')</script>";
                    $this->objSolicitud->setEmail($json_datos['idsolicitud']['email']);
                    $this->objSolicitud->setClave($json_datos['idsolicitud']['clave']);
                    $this->objSolicitud->setUltEjemplar($json_datos['idsolicitud']['ultejemplar']);
                    break;
                }
            }
            //echo "<script>alert('SESION: ".$this->objSolicitud->getSession().": Finalizó')</script>"; 
            $resp = self::inExitoso;
            //echo "<script>alert('Decodificó e instació el objeto')</script>"; 
            return $resp;
        } catch (Exception $ex) {
        } finally {
            return $resp;
        }    
    }
    
    /*
     * validaSesionUsuario 
     * Valida los datos de la sesion verificando que sea veridica
     * Credenciales está compuesto por: 1.usr,2.pass,3-device,4.session,5-opcion a despachar,
     * parametros para la url a despachar, cantidad de caracteres de cada uno 
     * de los anteriores cada uno con 4 digitos.
     * 
     */
    public function validaSesionUsuario($psolicitud)
    {   
        //Verifica que el usuario exista, que esté activo, que la clave coincida
        //que corresponda al dispositivo, y que la sesion esté activa
        
        //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getEmail()." ::')</script>";
        $respuesta = self::inUsSeIna; //Inicializa como sesion logueada
        $em = $this->getDoctrine()->getManager();
       //echo "<script>alert('validaSesionUsuario :: ingreso')</script>";
        if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()))){
           //echo "<script>alert('validaSesionUsuario :: No existe el USUARIO')</script>";
            $respuesta = self::inUsClInv; //Usuario o clave inválidos
        } else {    
            $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()));

            $estado = $usuario->getInusuestado();
            //echo "<script>alert('encontro el usuario: estado : ".$estado." ')</script>";

            //Busca el dispositivo si no esta asociado al usuario envia mensaje de sesion no existe
            if (!$em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                    'txdisid' => $psolicitud->getDeviceMAC(), 
                    'indisusuario' => $usuario))){
                   //echo "<script>alert('validaSesionUsuario :: Sesion inactiva')</script>";
                    $respuesta = self::inUsSeIna; //Si la sesion no existe para el dispositivo
            } else {
                //Si el usuario está INACTIVO
                if ($estado != self::inUsuActi)
                {
                   //echo "<script>alert('validaSesionUsuario :: Usuario inactivo')</script>";
                    $respuesta = self::inUsuConf; //Usuario Inactiva
                } else {
                    //Si la clave enviada es inválida
                    if ($usuario->getTxusuclave() != $psolicitud->getClave()){
                       //echo "<script>alert('validaSesionUsuario :: Clave invalida')</script>";
                        $respuesta = self::inUsClInv; //Usuario o clave inválidos
                    } else {
                        //Valida si la sesion está activa
                        $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                            'txdisid' => $psolicitud->getDeviceMAC(), 
                            'indisusuario' => $usuario));
                        if (!$em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                            'txsesnumero' =>  $psolicitud->getSession(),
                            'insesdispusuario' => $device,
                            'insesactiva' => self::inSesActi))){
                           //echo "<script>alert('validaSesionUsuario :: Sesion inactiva')</script>";
                            $respuesta = self::inUsSeIna; //Usuario o clave inválidos

                        } else {
                            $respuesta = self::inULogged; //Usuario o clave inválidos
                           //echo "<script>alert('La sesion es VALIDA')</script>";
                        }
                    }   
                }
            }
        }
                
        //Flush al entity manager
        $em->flush(); 

        return ($respuesta);
    }

    /*
     * usuarioSesionActiva 
     *Indica si un usuario tiene una sesion activa
     * 
     */
    public function usuarioSesionActiva($psolicitud, $device)
    {   
        $em = $this->getDoctrine()->getManager();
        //Identifica el dispositivo // a este es al que se asocia la sesion

        //echo "<script>alert('Dispositivo MAC ".$psolicitud->getDeviceMAC()."')</script>";
        $id = $device->getIndispusuario();
       //echo "<script>alert('Dispositivo ID ".$id." - MAC: ".$psolicitud->getDeviceMAC()."')</script>";
        //echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";

        $sesion = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
            'insesdispusuario' => $id,
            'insesactiva' => self::inSesActi));

        //$ses = $sesion->getInsesion();

        //echo "<script>alert('Sesion ".$ses()."')</script>";

        if ($sesion != NULL) {echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";}

        //Flush al entity manager
        $em->flush(); 

        return ($sesion != NULL);
            
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
            $sesion->setFesesfechaini($pFecIni);
            $sesion->setFesesfechafin($pFecFin);
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
     * recuperaSesionUsuario 
     * Valida los datos de la sesion verificando que sea veridica
     * Credenciales está compuesto por: 1.usr,2.pass,3-device,4.session,5-opcion a despachar,
     * parametros para la url a despachar, cantidad de caracteres de cada uno 
     * de los anteriores cada uno con 4 digitos.
     * 
     */
    public function recuperaSesionUsuario($pusuario, $psolicitud)
    {   
        //Verifica que el usuario exista, que esté activo, que la clave coincida
        //que corresponda al dispositivo, y que la sesion esté activa
        
       //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getEmail()." ::')</script>";
        $respuesta = self::inUsSeIna; //Inicializa como sesion logueada
        $em = $this->getDoctrine()->getManager();
        if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()))){
            $respuesta = self::inUsClInv; //Usuario o clave inválidos
        } else {    
            $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                    findOneBy(array('txusuemail' => $psolicitud->getEmail()));

            $estado = $usuario->getInusuestado();
           //echo "<script>alert('encontro el usuario: estado : ".$estado." ')</script>";

            //Busca el dispositivo si no esta asociado al usuario envia mensaje de sesion no existe
            if (!$em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                    'txdisid' => $psolicitud->getDeviceMAC(), 
                    'indisusuario' => $usuario))){
                   //echo "<script>alert('Sesion no existe para dispositivo ')</script>";
                    $respuesta = self::inUsSeIna; //Si la sesion no existe para el dispositivo
            } else {
                $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                    'txdisid' => $psolicitud->getDeviceMAC(), 
                    'indisusuario' => $usuario));
               //echo "<script>alert('encontro el dispositivo usuario ')</script>";
                //Si el usuario está INACTIVO
                if ($estado != self::inUsuActi)
                {
                   //echo "<script>alert('Usuario inactiva ')</script>";
                    $respuesta = self::inUsuConf; //Usuario Inactiva
                } else {
                    //Si la clave enviada es inválida
                    if ($usuario->getTxusuclave() != $psolicitud->getClave()){
                       //echo "<script>alert('Clave invalida ')</script>";
                        $respuesta = self::inUsClInv; //Usuario o clave inválidos
                    } else {
                        //Valida si la sesion está activa
                       //echo "<script>alert('Va a retornar la sesion ')</script>";
                        $respuesta = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                            'txsesnumero' =>  $psolicitud->getSession(),
                            'insesdispusuario' => $device,
                            'insesactiva' => self::inSesActi));
                    }   
                }
            }
        }       
        //Flush al entity manager
        $em->flush(); 

        return ($respuesta);
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
