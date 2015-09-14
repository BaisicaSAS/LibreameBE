<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Doctrine\ORM\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Libreame\BackendBundle\Entity\LbLugares;
use Libreame\BackendBundle\Entity\LbGeneros;
use Libreame\BackendBundle\Entity\LbLibros;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbActsesion;


class Logica extends \Symfony\Component\DependencyInjection\ContainerAware {   

    /*private $em;

    public function __construct(EntityManager $entityManager)
    {
      echo "<script>alert('Asignado em')</script>"; 
      $this->em = $entityManager;
    }
    /*
     * Esta funcion configurada como servicio se encarga de recibir la información del cliente
     * luego de que ha sido validada por el controlador AccesoController. Luego de recibirla
     * Evalua la accion solicitada, ejecuta lo solicitado y retorna la respuesta al controlador.
     */
    
    public function ejecutaAccion($solicitud)
    {
        try{
            $respuesta = AccesoController::inFallido;
            $tmpSolicitud = $solicitud->getAccion();
            //echo "<script>alert('".$tmpSesion."-".AccesoController::txAccRegistro."')</script>";
            switch ($tmpSolicitud){
                //accion de registro en el sistema
                case AccesoController::txAccRegistro: {//Dato:1
                    //echo "<script>alert('Antes de entrar a Registro-".$solicitud->getEmail()."')</script>";
                    $objRegistro = $this->get('registro_service');
                    $respuesta = $objRegistro::registroUsuario($solicitud);
                    break;
                }    
                //accion de login en el sistema
                case AccesoController::txAccIngresos: {//Dato:2
                    //echo "<script>alert('Antes de entrar a Login-".$solicitud->getEmail()."')</script>";
                    $objLogin = $this->get('login_service');
                    $respuesta = $objLogin::loginUsuario($solicitud);
                    break;
                } 
                //accion de recuperar datos y parametros de usuario
                case AccesoController::txAccRecParam: {//Dato:3
                    //echo "<script>alert('Antes de entrar a Recuperar Parametros Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::obtenerParametros($solicitud);
                    break;
                } 

                case AccesoController::txAccRecFeeds: {//Dato:4
                    //echo "<script>alert('Antes de entrar a Recuperar Parametros Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::recuperarFeedEjemplares($solicitud);
                    break;
                } 

                case AccesoController::txAccPubliEje: {//Dato:13
                    //echo "<script>alert('Antes de entrar a Publicar Ejemplar Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::publicarEjemplar($solicitud);
                    break;
                } 

            }
            //echo "<script>alert('ejecuta Accion: ".$respuesta."')</script>";
            return $respuesta;
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }
    
    public function generaRespuesta($respuesta, $pSolicitud, $parreglo){

        try {
            //echo "<script>alert('ACCION Genera respuesta: ".$pSolicitud->getAccion()."')</script>";
            //echo "<script>alert('REPUESTA Genera respuesta: ".$respuesta->getRespuesta()."')</script>";

            switch($pSolicitud->getAccion()){

                //accion de registro en el sistema
                case AccesoController::txAccRegistro:  //Dato: 1 
                    $JSONResp = Logica::respuestaRegistro($respuesta, $pSolicitud);
                    break;

                //accion de login en el sistema
                case AccesoController::txAccIngresos:  //Dato: 2
                    //$vRespuesta
                    $JSONResp = Logica::respuestaLogin($respuesta, $pSolicitud);
                    break;

                //accion de recuperar datos y parametros de usuario
                case AccesoController::txAccRecParam:  //Dato: 3
                    $JSONResp = Logica::respuestaDatosUsuario($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de recuperar los feeds de publicaciones nuevas
                case AccesoController::txAccRecFeeds:  //Dato: 4
                    $JSONResp = Logica::respuestaFeedEjemplares($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de publicar un ejemplar
                case AccesoController::txAccPubliEje:  //Dato: 13
                    $JSONResp = Logica::respuestaPublicarEjemplar($respuesta, $pSolicitud, $parreglo);
                    break;
            }

            return json_encode($JSONResp);
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }

    
    /*
     * respuestaRegistro: 
     * Funcion que genera el JSON de respuesta para la accion de registro :: AccesoController::txAccRegistro
     */
    public function respuestaRegistro($respuesta, $pSolicitud){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta())));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    

    /*
     * respuestaLogin: 
     * Funcion que genera el JSON de respuesta para la accion de Login :: AccesoController::txAccIngresos:
     */
    public function respuestaLogin($respuesta, $pSolicitud){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(),
                            'idsesion' => $respuesta->getSession(), 
                            'cantmensajes' => $respuesta->getCantMensajes())));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    

    /*
     * respuestaDatosUsuario: 
     * Funcion que genera el JSON de respuesta para la accion de Recuperar Datos de Usuario :: AccesoController::txAccRecParam
     */
    public function respuestaDatosUsuario($respuesta, $pSolicitud, $parreglo){

        try {
            //Recupera el lugar, de la tabla de Lugares
            $em = AccesoController::getManager();
            $lugar = new LbLugares();
            if ($respuesta->getRespuesta()== AccesoController::inULogged){
                $lugar = $em->getRepository('LibreameBackendBundle:LbLugares')->
                    findOneBy(array('inlugar' => $respuesta->RespUsuarios[0]->getInusulugar()));
            }

            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(),
                    'usuario' => (array('nomusuario' => $respuesta->RespUsuarios[0]->getTxusunombre(),
                        'nommostusuario' => $respuesta->RespUsuarios[0]->getTxusunommostrar(), 
                        'email' => $respuesta->RespUsuarios[0]->getTxusuemail(),
                        'usutelefono' => $respuesta->RespUsuarios[0]->getTxusutelefono(), 
                        'usugenero' => $respuesta->RespUsuarios[0]->getInusugenero(),
                        'usuimagen' => $respuesta->RespUsuarios[0]->getTxusuimagen(), 
                        'usufecnac' => $respuesta->RespUsuarios[0]->getFeusunacimiento(),
                        'usulugar' => $lugar->getInlugar(), 
                        'usunomlugar' => $lugar->getTxlugnombre())))));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    

    /*
     * respuestaFeedEjemplares: 
     * Funcion que genera el JSON de respuesta para la accion de recuperar Feed de ejemplares :: AccesoController::txAccRecFeeds:
     */
    public function respuestaFeedEjemplares($respuesta, $pSolicitud, $parreglo){
        try{
            $em = AccesoController::getManager();
            $arrTmp[] = array();

            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $genero = new LbGeneros();
                $libro = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    $genero = $em->getRepository('LibreameBackendBundle:LbGeneros')->
                        findOneBy(array('ingenero' => $ejemplar->getInejegenero()));
                    $libro = $em->getRepository('LibreameBackendBundle:LbLibros')->
                        findOneBy(array('inlibro' => $ejemplar->getInejelibro()));
                    $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('inusuario' => $ejemplar->getInejeusudueno()));
                }
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                  'idgenero' => $genero->getIngenero(), 'inejecantidad' => $ejemplar->getInejecantidad(),
                  'dbavaluo' => $ejemplar->getDbejeavaluo(), 'indueno' => $usuario->getInusuario(),
                  'inlibro' => $libro->getInlibro(), 'txgenero' => $genero->getTxgennombre(), 
                  'txlibro' => $libro->getTxlibtitulo(), 'txdueno' => $usuario->getTxusunombre()
                ) ;
            }

            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                    'ejemplares' => $arrTmp));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    /*
     * respuestaPublicaeEjemplar: 
     * Funcion que genera el JSON de respuesta para la accion de Publicar un ejemplar :: AccesoController::txAccPubliEje:
     */
    public function respuestaPublicarEjemplar($respuesta, $pSolicitud, $parreglo){
        return "";
        /*try{
            $em = $this->getDoctrine()->getManager();
            $arrTmp[] = array();

            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $genero = new LbGeneros();
                $libro = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    $genero = $em->getRepository('LibreameBackendBundle:LbGeneros')->
                        findOneBy(array('ingenero' => $ejemplar->getInejegenero()));
                    $libro = $em->getRepository('LibreameBackendBundle:LbLibros')->
                        findOneBy(array('inlibro' => $ejemplar->getInejelibro()));
                    $usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('inusuario' => $ejemplar->getInejeusudueno()));
                }
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                  'idgenero' => $genero->getIngenero(), 'inejecantidad' => $ejemplar->getInejecantidad(),
                  'dbavaluo' => $ejemplar->getDbejeavaluo(), 'indueno' => $usuario->getInusuario(),
                  'inlibro' => $libro->getInlibro(), 'txgenero' => $genero->getTxgennombre(), 
                  'txlibro' => $libro->getTxlibtitulo(), 'txdueno' => $usuario->getTxusunombre()
                ) ;
            }

            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                    'ejemplares' => $arrTmp));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } */
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
        $respuesta = AccesoController::inPlatCai;
        try{
            //Verifica que el usuario exista, que esté activo, que la clave coincida
            //que corresponda al dispositivo, y que la sesion esté activa

            //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getEmail()." ::')</script>";
            $respuesta = AccesoController::inUsSeIna; //Inicializa como sesion logueada
            $em = AccesoController::getManager();
            //echo "<script>alert('validaSesionUsuario :: ingreso')</script>";
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('txusuemail' => $psolicitud->getEmail()))){
               //echo "<script>alert('validaSesionUsuario :: No existe el USUARIO')</script>";
                $respuesta = AccesoController::inUsClInv; //Usuario o clave inválidos
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
                        $respuesta = AccesoController::inUsSeIna; //Si la sesion no existe para el dispositivo
                } else {
                    //Si el usuario está INACTIVO
                    if ($estado != AccesoController::inUsuActi)
                    {
                       //echo "<script>alert('validaSesionUsuario :: Usuario inactivo')</script>";
                        $respuesta = AccesoController::inUsuConf; //Usuario Inactiva
                    } else {
                        //Si la clave enviada es inválida
                        if ($usuario->getTxusuclave() != $psolicitud->getClave()){
                           //echo "<script>alert('validaSesionUsuario :: Clave invalida')</script>";
                            $respuesta = AccesoController::inUsClInv; //Usuario o clave inválidos
                        } else {
                            //Valida si la sesion está activa
                            $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                                'txdisid' => $psolicitud->getDeviceMAC(), 
                                'indisusuario' => $usuario));
                            if (!$em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                                'txsesnumero' =>  $psolicitud->getSession(),
                                'insesdispusuario' => $device,
                                'insesactiva' => AccesoController::inSesActi))){
                               //echo "<script>alert('validaSesionUsuario :: Sesion inactiva')</script>";
                                $respuesta = AccesoController::inUsSeIna; //Usuario o clave inválidos

                            } else {
                                $respuesta = AccesoController::inULogged; //Usuario o clave inválidos
                               //echo "<script>alert('La sesion es VALIDA')</script>";
                            }
                        }   
                    }
                }
            }

            //Flush al entity manager
            $em->flush(); 

            return ($respuesta);
        } catch (Exception $ex) {
            return ($respuesta);
        }    
    }

    /*
     * usuarioSesionActiva 
     *Indica si un usuario tiene una sesion activa
     * 
     */
    public function usuarioSesionActiva($psolicitud, $device)
    {   
        try {
            $em = $this->getEntityManager();
            //Identifica el dispositivo // a este es al que se asocia la sesion

            //echo "<script>alert('Dispositivo MAC ".$psolicitud->getDeviceMAC()."')</script>";
            $id = $device->getIndispusuario();
            //echo "<script>alert('Dispositivo ID ".$id." - MAC: ".$psolicitud->getDeviceMAC()."')</script>";
            //echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";

            $sesion = $this->em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                'insesdispusuario' => $id,
                'insesactiva' => AccesoController::inSesActi));

            //if ($sesion != NULL) {echo "<script>alert('EXISTE Sesion activa ".$device->getIndispusuario()."')</script>";}

            //Flush al entity manager
            $em->flush(); 

            return ($sesion != NULL);
        } catch (Exception $ex) {
            return (FALSE);
        }    
            
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
            $em = AccesoController::getManager();
            $sesion = new LbSesiones();
            $sesion->setInsesactiva($pEstado);
            $sesion->setTxsesnumero($objLogica::generaRand(AccesoController::inTamSesi));
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
                return AccesoController::inPlatCai;
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
            $em = AccesoController::getManager();
            
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
                return AccesoController::inPlatCai;
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
        try{
            //Verifica que el usuario exista, que esté activo, que la clave coincida
            //que corresponda al dispositivo, y que la sesion esté activa

            //echo "<script>alert('Ingresa validar sesion :: ".$psolicitud->getEmail()." ::')</script>";
            $respuesta = AccesoController::inUsSeIna; //Inicializa como sesion logueada
            $em = AccesoController::getManager();
            
            if (!$em->getRepository('LibreameBackendBundle:LbUsuarios')->
                        findOneBy(array('txusuemail' => $psolicitud->getEmail()))){
                $respuesta = AccesoController::inUsClInv; //Usuario o clave inválidos
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
                        $respuesta = AccesoController::inUsSeIna; //Si la sesion no existe para el dispositivo
                } else {
                    $device = $em->getRepository('LibreameBackendBundle:LbDispusuarios')->findOneBy(array(
                        'txdisid' => $psolicitud->getDeviceMAC(), 
                        'indisusuario' => $usuario));
                   //echo "<script>alert('encontro el dispositivo usuario ')</script>";
                    //Si el usuario está INACTIVO
                    if ($estado != AccesoController::inUsuActi)
                    {
                       //echo "<script>alert('Usuario inactiva ')</script>";
                        $respuesta = AccesoController::inUsuConf; //Usuario Inactiva
                    } else {
                        //Si la clave enviada es inválida
                        if ($usuario->getTxusuclave() != $psolicitud->getClave()){
                           //echo "<script>alert('Clave invalida ')</script>";
                            $respuesta = AccesoController::inUsClInv; //Usuario o clave inválidos
                        } else {
                            //Valida si la sesion está activa
                           //echo "<script>alert('Va a retornar la sesion ')</script>";
                            $respuesta = $em->getRepository('LibreameBackendBundle:LbSesiones')->findOneBy(array(
                                'txsesnumero' =>  $psolicitud->getSession(),
                                'insesdispusuario' => $device,
                                'insesactiva' => AccesoController::inSesActi));
                        }   
                    }
                }
            }       
            //Flush al entity manager
            $em->flush(); 

            return ($respuesta);
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }
    
    
    /*
     * enviaMailRegistro 
     * Se encarga de enviar el email con el que el usuario confirmara su registro
     */
    public function enviaMailRegistro($usuario)
    {   
        try{
            $message = \Swift_Message::newInstance()
                ->setContentType('text/html')
                ->setSubject('Bienvenido a ex4Read '.$usuario->getTxusunombre())
                ->setFrom('baisicasas@gmail.com')
                ->setTo($usuario->getTxusuemail())
                ->setBody($usuario->gettxusuvalidacion());

            $this->get('mailer')->send($message);
        
            return 0;
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }
    
    /*
     * generaRand: 
     * Funcion que genera un ID aleatorio de la cantidad solicitada en el parámetro
     */
    public function generaRand($tamano){

        $patron = "1234567890abcdefghijklmnopqrstuvwxyz+~*-"; 
        $key = "";
        
        for($i = 0; $i < $tamano; $i++) { 
            $key .= $patron{rand(0, 39)}; 
        } 
        //echo "<script>alert('Generó clave de ".$tamano.": ".$key."')</script>";
        return $key;         
    }
}
