<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Doctrine\ORM\EntityManager;
use Libreame\BackendBundle\Repository\ManejoDataRepository;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Libreame\BackendBundle\Entity\LbLugares;
use Libreame\BackendBundle\Entity\LbGeneros;
use Libreame\BackendBundle\Entity\LbGeneroslibros;
use Libreame\BackendBundle\Entity\LbLibros;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbEjemplares;
use Libreame\BackendBundle\Entity\LbActsesion;


class Logica {   

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
            //echo "<script>alert('".$tmpSolicitud."-".AccesoController::txAccRegistro."')</script>";
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
     * respuestaGenerica: 
     * Funcion que genera el JSON de respuesta cuando por calidad de datos no se ralizó ninguna operacion
     */
    public function respuestaGenerica($respuesta, $pSolicitud){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => $pSolicitud->getSession(), 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta())));
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
            
            //$lugar = new LbLugares();
            if ($respuesta->getRespuesta()== AccesoController::inULogged){
                $lugar = ManejoDataRepository::getLugar($respuesta->RespUsuarios[0]->getInusulugar());
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
            $arrTmp[] = array();
            $ejemplar = new LbEjemplares();
            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $genero = new LbGeneros();
                $generolibro = new LbGeneroslibros();
                $libro = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    $libro = ManejoDataRepository::getLibro($ejemplar->getInejelibro());
                    $generolibro = ManejoDataRepository::getGeneroLibro($ejemplar->getInejelibro());
                    $usuario = ManejoDataRepository::getUsuarioById($ejemplar->getInejeusudueno());
                }
                //Guarda los generos
                foreach ($generolibro as $gen){
                    $genero = ManejoDataRepository::getGenero($gen->getIngligenero());
                    $arrGeneros[] = array('ingenero' => $genero->getIngenero(), 'txgenero' => $genero->getTxgennombre());
                }
                
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                  'idgenero' => $arrGeneros, 'inejecantidad' => $ejemplar->getInejecantidad(),
                  'dbavaluo' => $ejemplar->getDbejeavaluo(), 'indueno' => $usuario->getInusuario(),
                  'inlibro' => $libro->getInlibro(), 'txlibro' => $libro->getTxlibtitulo(), 
                  'txdueno' => $usuario->getTxusunombre()
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
