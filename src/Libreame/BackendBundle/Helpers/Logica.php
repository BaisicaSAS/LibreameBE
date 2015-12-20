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
use Libreame\BackendBundle\Entity\LbMensajes;
use Libreame\BackendBundle\Entity\LbSolicitados;
use Libreame\BackendBundle\Entity\LbOfrecidos;
use Libreame\BackendBundle\Entity\LbOfertas;
use Libreame\BackendBundle\Entity\LbCalificausuarios;
use Libreame\BackendBundle\Helpers\Respuesta;


class Logica {   

    const pos1mail = 2;
    const pos2mail = 4;
    const pos3mail = 6;

    const pos1pat = 3;
    const pos2pat = 5;
    const pos3pat = 7;

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
                case AccesoController::txAccRegistro: {//Dato:1 : Registro en el sistema
                    //echo "<script>alert('Antes de entrar a Registro-".$solicitud->getEmail()."')</script>";
                    $objRegistro = $this->get('registro_service');
                    $respuesta = $objRegistro::registroUsuario($solicitud);
                    break;
                }    
                //accion de login en el sistema
                case AccesoController::txAccIngresos: {//Dato:2 : Login
                    //echo "<script>alert('Antes de entrar a Login-".$solicitud->getEmail()."')</script>";
                    $objLogin = $this->get('login_service');
                    $respuesta = $objLogin::loginUsuario($solicitud);
                    break;
                } 
                //accion de recuperar datos y parametros de usuario
                case AccesoController::txAccRecParam: {//Dato:3 : Recuperar datos de usuario (Propio)
                    //echo "<script>alert('Antes de entrar a Recuperar Parametros Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::obtenerParametros($solicitud);
                    break;
                } 

                case AccesoController::txAccRecFeeds: {//Dato:4 : Recuperar Feeds de ejemplares
                    //echo "<script>alert('Antes de entrar a Recuperar Parametros Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::recuperarFeedEjemplares($solicitud);
                    break;
                } 

                case AccesoController::txAccRecOpera: {//Dato:5 : Recuperar Mensajes
                    //echo "<script>alert('Antes de entrar a Recuperar Mensajes Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::recuperarMensajes($solicitud);
                    break;
                } 

                case AccesoController::txAccBusEjemp: {//Dato:7 : Buscar
                    //echo "<script>alert('Antes de entrar a Buscar Ejemplares Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::buscarEjemplares($solicitud);
                    break;
                } 

                case AccesoController::txAccRecOfert: {//Dato:8 : Recuperar oferta
                    //echo "<script>alert('Antes de entrar a Recuperar oferta Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::recuperarOferta($solicitud);
                    break;
                } 

                case AccesoController::txAccRecUsuar: {//Dato:9 : Ver usuario otro
                    //echo "<script>alert('Antes de entrar a Ver Usuario Otro-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::verUsuarioOtro($solicitud);
                    break;
                } 

                case AccesoController::txAccCerraSes: {//Dato:10 : Cerrar Sesion
                    //echo "<script>alert('Antes de entrar a Logout-".$solicitud->getEmail()."')</script>";
                    $objLogin = $this->get('login_service');
                    $respuesta = $objLogin::logoutUsuario($solicitud);
                    break;
                } 

                case AccesoController::txAccActParam: {//Dato:12 : Actualizar datos parametros usuario
                    //echo "<script>alert('Antes de entrar a Actualizar datos parametros usuario-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::actualizarDatosUsuario($solicitud);
                    break;
                } 

                case AccesoController::txAccPubliEje: {//Dato:13 : Publicar ejemplar
                    //echo "<script>alert('Antes de entrar a Publicar Ejemplar Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::publicarEjemplar($solicitud);
                    break;
                } 

                case AccesoController::txAccRecClave: {//Dato:29 : Cambio de clave
                    //echo "<script>alert('Antes de entrar a Cambio de clave -".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::actualizarClaveUsuario($solicitud);
                    break;
                } 
                
                case AccesoController::txAccMarcMens: {//Dato:36 : Marcar Mensaje
                    //echo "<script>alert('Antes de entrar a Marcar Mensajes Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::marcarMensajes($solicitud);
                    break;
                } 

                case AccesoController::txAccListaIdi: {//Dato:37 : Listar idiomas
                    //echo "<script>alert('Antes de entrar a Listar idiomas Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::listarIdiomas($solicitud);
                    break;
                } 

                case AccesoController::txAccListaLug: {//Dato:38 : Listar lugares
                    //echo "<script>alert('Antes de entrar a Listar idiomas Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::listarLugares($solicitud);
                    break;
                } 

            }
            //echo "<script>alert('ejecuta Accion: ".$respuesta."')</script>";
            return $respuesta;
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }   
    
    public function generaRespuesta(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){

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

                //accion de recuperar mensajes
                case AccesoController::txAccRecOpera:  //Dato: 5
                    $JSONResp = Logica::respuestaRecuperarMensajes($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de buscar ejemplares
                case AccesoController::txAccBusEjemp:  //Dato: 7
                    $JSONResp = Logica::respuestaBuscarEjemplares($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de recuperar oferta
                case AccesoController::txAccRecOfert:  //Dato: 8
                    $JSONResp = Logica::respuestaRecuperarOferta($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de ver usuario otro
                case AccesoController::txAccRecUsuar:  //Dato: 9
                    $JSONResp = Logica::respuestaVerUsuarioOtro($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de cerrar sesion de usuario
                case AccesoController::txAccCerraSes:  //Dato: 10
                    $JSONResp = Logica::respuestaCerrarSesion($respuesta, $pSolicitud);
                    break;

                //accion de publicar un ejemplar
                case AccesoController::txAccActParam: //Dato:12 : Actualizar datos usuario
                    $JSONResp = Logica::respuestaActualizarDatosUsuario($respuesta, $pSolicitud);
                    break;
                
                //accion de publicar un ejemplar
                case AccesoController::txAccPubliEje:  //Dato: 13
                    $JSONResp = Logica::respuestaPublicarEjemplar($respuesta, $pSolicitud);
                    break;

                case AccesoController::txAccRecClave: //Dato:29 : Cambio de clave
                    $JSONResp = Logica::respuestaCambiarClave($respuesta, $pSolicitud);
                    break;

                case AccesoController::txAccMarcMens: //Dato:36 : Marcar Mensaje
                    $JSONResp = Logica::respuestaMarcarMensaje($respuesta, $pSolicitud);
                    break;
                
                case AccesoController::txAccListaIdi: //Dato:37 : Listar idiomas
                    $JSONResp = Logica::respuestaListaIdiomas($respuesta, $pSolicitud, $parreglo);
                    break;
                
                case AccesoController::txAccListaLug: //Dato:38 : Listar Lugares
                    $JSONResp = Logica::respuestaListaLugares($respuesta, $pSolicitud, $parreglo);
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
    public function respuestaGenerica(Respuesta $respuesta, Solicitud $pSolicitud){
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
    public function respuestaRegistro(Respuesta $respuesta, Solicitud $pSolicitud){
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
    public function respuestaLogin(Respuesta $respuesta, Solicitud $pSolicitud){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(),
                            'idusuario' => $respuesta->RespUsuarios[0]->getInusuario(),
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
    public function respuestaDatosUsuario(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){

        try {
            //Recupera el lugar, de la tabla de Lugares
            
            $lugar = new LbLugares();
            if ($respuesta->getRespuesta()== AccesoController::inULogged){
                $lugar = ManejoDataRepository::getLugar($respuesta->RespUsuarios[0]->getInusulugar());
            }
            
            if ($respuesta->RespUsuarios[0]->getFeusunacimiento() == NULL) {
                $fecha = "";
            } else {
                $fecha = $respuesta->RespUsuarios[0]->getFeusunacimiento()->format('d-m-Y');
            }
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(),
                    'usuario' => array('idusuario' => $respuesta->RespUsuarios[0]->getInusuario(), 
                        'nomusuario' => $respuesta->RespUsuarios[0]->getTxusunombre(),
                        'nommostusuario' => $respuesta->RespUsuarios[0]->getTxusunommostrar(), 
                        'email' => $respuesta->RespUsuarios[0]->getTxusuemail(),
                        'usutelefono' => $respuesta->RespUsuarios[0]->getTxusutelefono(), 
                        'usugenero' => $respuesta->RespUsuarios[0]->getInusugenero(),
                        //La siguiente línea debe habilitarse, e integrar el CAST de BLOB a TEXT??
                        //'usuimagen' => $respuesta->RespUsuarios[0]->getTxusuimagen(), 
                        'usuimagen' => base64_decode($respuesta->RespUsuarios[0]->getTxusuimagen()), 
                        'usufecnac' => $fecha,
                        'usulugar' => $lugar->getInlugar(), 
                        'usunomlugar' => $lugar->getTxlugnombre(),
                        'usupromcalifica' => $respuesta->getPromCalificaciones(),
                        'comentariosreci' => $respuesta->getArrCalificacionesRec(),
                        'comentariosreali' => $respuesta->getArrCalificacionesRea(),
                        'resumen' => array('ejemplares' => '5', 'vendidos' => '4', 'comprados' => '0', 
                            'cambiados' => '3', 'donados' => '1'),
                        'preferencias' => array('generos' => 'Genero 1, Genero 2',
                            'autores' => 'Autor 1, Autor 2', 
                            'editoriales' => 'editorial 1, editorial 2')))
                );
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    

    /*
     * respuestaFeedEjemplares: 
     * Funcion que genera el JSON de respuesta para la accion de recuperar Feed de ejemplares :: AccesoController::txAccRecFeeds:
     */
    public function respuestaFeedEjemplares(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try{
            $arrGeneros = array();
            $arrTmp = array();
            //$ejemplar = new LbEjemplares();
            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $genero = new LbGeneros();
                $generolibro = new LbGeneroslibros();
                $libro = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    //echo "ejemplar: [".$ejemplar->getInejelibro()->getInlibro()."]\n";
                    $libro = ManejoDataRepository::getLibro($ejemplar->getInejelibro()->getInlibro());
                    $generolibro = ManejoDataRepository::getGeneroLibro($ejemplar->getInejelibro()->getInlibro());
                    $usuario = ManejoDataRepository::getUsuarioById($ejemplar->getInejeusudueno()->getInusuario());
                    //echo "RECUPERO DATOS\n";
                }
                //Guarda los generos
                foreach ($generolibro as $gen){
                    $genero = ManejoDataRepository::getGenero($gen->getIngligenero());
                    $arrGeneros[] = array('ingenero' => $genero->getIngenero(), 'txgenero' => $genero->getTxgennombre());
                }
                //echo "ANTES OFERTA RECUPERO DATOS\n";

                $oferta = new LbOfertas();
                $oferta = ManejoDataRepository::getOfertasByEjemplar($ejemplar);
                //echo "RECUPERO OFERTA = ".$oferta->getInoferta()."\n";

                $ofrecidos = new LbOfrecidos();
                $ofrecidos = ManejoDataRepository::getOfrecidosByOferta($oferta);
                //echo "RECUPERO OFRECIDOS \n";

                $solicitados = new LbSolicitados();
                $solicitados = ManejoDataRepository::getSolicitadosByOferta($oferta);
                //echo "RECUPERO SOLICITADOS \n";
                
                $inContador = 0;
                $sol1 = "";
                $sol2 = "";
                $vsol1 = 0;
                $vsol2 = 0;
                $mensaje = "";
                foreach ($solicitados as $solicitado){
                    //echo "SOLICITADO # ".$inContador." - ".$solicitado->getInsollibro()->getTxlibtitulo();
                    
                    if($inContador == 0) {
                        //echo "Libro - ".$solicitado->getInsollibro()->getInlibro();
                        
                        $sol1 = $solicitado->getInsollibro()->getTxlibtitulo();
                        $vsol1 = $solicitado->getDbsolvaladic();
                        $mensaje = $solicitado->getTxsolobservacion();
                    } else {
                        //echo "Libro - ".$solicitado->getInsollibro()->getInlibro();
                        $sol2 = $solicitado->getInsollibro()->getTxlibtitulo();
                        $vsol2 = $solicitado->getDbsolvaladic();
                    }
                    //echo $inContador." - ".$solicitado->getInsollibro()->getTxlibtitulo();
                    $inContador++;
                }
                
                $arrOferta = array('inoferta' => $oferta->getInoferta(), 
                    'soli1' => $sol1, 
                    'valadic1' => $vsol1, 
                    'soli2' => $sol2, 
                    'valadic2' => $vsol2, 
                    'valventa' => $ejemplar->getDbejeavaluo(), 
                    'mensaje' => $mensaje 
                );
                        
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                    'titulo' => $ejemplar->getInejelibro()->getTxlibtitulo(), 
                    'autor' => $ejemplar->getInejelibro()->getTxlibautores(),
                    'edicion' => $ejemplar->getInejelibro()->getTxlibedicionnum(), 
                    'editorial' => $ejemplar->getInejelibro()->getTxlibeditorial(),
                    'idioma' => $ejemplar->getInejelibro()->getTxlibidioma(),
                    'indueno' => $usuario->getInusuario(), 'oferta' => $arrOferta
                ); 

                
                unset($arrGeneros);
                
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
     * respuestaRecuperarMensajes: 
     * Funcion que genera el JSON de respuesta para la accion de recuperar mensajes:: AccesoController::txAccRecOpera:
     */
    public function respuestaRecuperarMensajes(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try{
            $arUsuario = array();
            $arrTmp = array();
            $mensaje = new LbMensajes();
            
            foreach ($parreglo as $mensaje){
                //echo $mensaje->getTxmensaje()."\n";
                //Recupera los usuarios ID + Nombre
                if ($mensaje->getInmenusuarioorigen() != NULL)
                {
                    //echo "[ID_ORIGEN: ".$mensaje->getInmenusuarioorigen()->getInusuario()."]\n";
                    $usuario = ManejoDataRepository::getUsuarioById($mensaje->getInmenusuarioorigen()->getInusuario());
                    $u1 = array('idusuario' => $usuario->getInusuario(), 'nombre' => $usuario->getTxusunommostrar());  
                } else {
                    $u1 = array('idusuario' => "", 'nombre' => "");                      
                } 
                    
                //echo "[ID_DESTINO: ".$mensaje->getInmenusuario()->getInusuario()."]\n";
                $usuario2 = ManejoDataRepository::getUsuarioById($mensaje->getInmenusuario()->getInusuario());
                $u2 = array('idusuario' => $usuario2->getInusuario(), 'nombre' => $usuario2->getTxusunommostrar());  
                
                if ($mensaje->getInmensajepadre() == NULL)
                    $idpadre = $mensaje->getInmensajepadre();
                else
                    $idpadre = "";
                
                $arrTmp[] = array('idmensaje' => $mensaje->getInmensaje(), 
                  'mensaje' => $mensaje->getTxmensaje(),'tipomensaje' => $mensaje->getInmenorigen(), 
                  'idorigen' => $mensaje->getInmemidrelacionado(),
                  'padre' => $idpadre, 'remitente' => $u1, 
                  'destinatario' => $u2, 'leido' => $mensaje->getInmenleido()
                ) ;
                
                //echo "ID Mensaje ".$mensaje->getInmensaje()."\n";
                
                unset($u1);
                unset($u2);

            }

            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                    'mensaje' => $arrTmp));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    

    /*
     * respuestaVerUsuarioOtro: 
     * Funcion que genera el JSON de respuesta para la accion de Recuperar Usuario Otro:: AccesoController::txAccRecUsuar
     */
    public function respuestaVerUsuarioOtro(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){

        try {
            //$calificacion = new LbCalificausuarios();
            $usuario = new LbUsuarios();
            $arrTmp = array();
            foreach ($respuesta->getArrCalificaciones() as $calificacion){
                //$usuario = ManejoDataRepository::getUsuarioById($calificacion->getIncalusucalifica()->getInusuario());
                
                $arrTmp[] = array('usucalifica' => $calificacion->getIncalusucalifica()->getInusuario(), 
                    'califica' => $calificacion->getIncalcalificacion(),
                    'mensaje' => $calificacion->getTxcalobservacion()
                ) ;
                
            }
            
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(),
                    'usuario' => array('idusuario' => $respuesta->RespUsuarios[0]->getInusuario(), 
                        'nommostusuario' => $respuesta->RespUsuarios[0]->getTxusunommostrar(), 
                        'email' => $respuesta->RespUsuarios[0]->getTxusuemail(),
                        //La siguiente línea debe habilitarse, e integrar el CAST de BLOB a TEXT??
                        //'usuimagen' => $respuesta->RespUsuarios[0]->getTxusuimagen(), 
                        'usuimagen' => "DUMMY", "calificacion" => "4,5",
                        'comentarios' => $arrTmp))
                );
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    
    /*
     * respuestaRecuperarOferta: 
     * Funcion que genera el JSON de respuesta para la accion de Recuperar Oferta:: AccesoController::txAccRecOferta:
     */
    public function respuestaRecuperarOferta(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try{
            $arrTmp = array();
            //$ejemplar = new LbEjemplares();
            $oferta = new LbOfertas();
            $oferta = $parreglo;
            
            if ($oferta == NULL){
                $arrOferta = array('inoferta' => '', 
                    'soli1' => '', 
                    'valadic1' => '', 
                    'soli2' => '', 
                    'valadic2' => '', 
                    'valventa' => '', 
                    'mensaje' => '' 
                );
                $arrTmp[] = array('idejemplar' => '', 
                    'titulo' => '', 
                    'autor' => '',
                    'edicion' => '', 
                    'editorial' => '',
                    'idioma' => '',
                    'indueno' => '', 'oferta' => $arrOferta
                ); 


                return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                        'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                        'ejemplares' => $arrTmp));
            } else {
                //$ofrecidos = new LbOfrecidos();
                $ofrecido = ManejoDataRepository::getOfrecidosByOferta($oferta);

                //echo "RECUPERO OFRECIDOS \n";
                //$solicitados = new LbSolicitados();
                $solicitados = ManejoDataRepository::getSolicitadosByOferta($oferta);
                //echo "RECUPERO SOLICITADOS \n";

                $inContador = 0;
                $sol1 = "";
                $sol2 = "";
                $vsol1 = 0;
                $vsol2 = 0;
                $mensaje = "";
                foreach ($solicitados as $solicitado){
                    if($inContador == 0) {
                        $sol1 = (String)$solicitado->getInsollibro()->getTxlibtitulo();
                        $vsol1 = $solicitado->getDbsolvaladic();
                        $mensaje = $solicitado->getTxsolobservacion();
                    } else {
                        $sol2 = (String)$solicitado->getInsollibro()->getTxlibtitulo();
                        $vsol2 = $solicitado->getDbsolvaladic();
                    }
                    //echo $inContador." - ".$solicitado->getInsollibro()->getTxlibtitulo();
                    $inContador++;
                }

                $ejemplar = new LbEjemplares();
                if ($ofrecido != NULL) {
                    $ejemplar = $ofrecido->getInofrejemplar();
                }
                
                //$precio = $ejemplar->getDbejeavaluo();
                $precio = 0;
                
                $arrOferta = array('inoferta' => $oferta->getInoferta(), 
                    'soli1' => $sol1, 
                    'valadic1' => $vsol1, 
                    'soli2' => $sol2, 
                    'valadic2' => $vsol2, 
                    'valventa' => $precio, 
                    'mensaje' => $mensaje 
                );

                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                    'titulo' => $ejemplar->getInejelibro()->getTxlibtitulo(), 
                    'autor' => $ejemplar->getInejelibro()->getTxlibautores(),
                    'edicion' => $ejemplar->getInejelibro()->getTxlibedicionnum(), 
                    'editorial' => $ejemplar->getInejelibro()->getTxlibeditorial(),
                    'idioma' => $ejemplar->getInejelibro()->getTxlibidioma(),
                    'indueno' => $ejemplar->getInejeusudueno()->getInusuario(), 
                    'oferta' => $arrOferta
                ); 

                return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                        'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                        'ejemplares' => $arrTmp));
            }
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    /*
     * respuestaBuscarEjemplares: 
     * Funcion que genera el JSON de respuesta para la accion de Buscar ejemplares :: AccesoController::txAccBusEjem:
     */
    public function respuestaBuscarEjemplares(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try{
            $arrGeneros = array();
            $arrTmp = array();
            //$ejemplar = new LbEjemplares();
            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $genero = new LbGeneros();
                $generolibro = new LbGeneroslibros();
                $libro = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    //echo "ejemplar: [".$ejemplar->getInejelibro()->getInlibro()."]\n";
                    $libro = ManejoDataRepository::getLibro($ejemplar->getInejelibro()->getInlibro());
                    $generolibro = ManejoDataRepository::getGeneroLibro($ejemplar->getInejelibro()->getInlibro());
                    $usuario = ManejoDataRepository::getUsuarioById($ejemplar->getInejeusudueno()->getInusuario());
                    //echo "RECUPERO DATOS\n";
                }
                //Guarda los generos
                foreach ($generolibro as $gen){
                    $genero = ManejoDataRepository::getGenero($gen->getIngligenero());
                    $arrGeneros[] = array('ingenero' => $genero->getIngenero(), 'txgenero' => $genero->getTxgennombre());
                }
                //echo "ANTES OFERTA RECUPERO DATOS\n";

                

                $oferta = new LbOfertas();
                $oferta = ManejoDataRepository::getOfertasByEjemplar($ejemplar);
                //echo "RECUPERO OFERTA = ".$oferta->getInoferta()."\n";

                $ofrecidos = new LbOfrecidos();
                $ofrecidos = ManejoDataRepository::getOfrecidosByOferta($oferta);
                //echo "RECUPERO OFRECIDOS \n";

                $solicitados = new LbSolicitados();
                $solicitados = ManejoDataRepository::getSolicitadosByOferta($oferta);
                //echo "RECUPERO SOLICITADOS \n";
                
                $inContador = 0;
                $sol1 = "";
                $sol2 = "";
                $vsol1 = 0;
                $vsol2 = 0;
                $mensaje = "";
                foreach ($solicitados as $solicitado){
                    if($inContador == 0) {
                        $sol1 = $solicitado->getInsollibro()->getTxlibtitulo();
                        $vsol1 = $solicitado->getDbsolvaladic();
                        $mensaje = $solicitado->getTxsolobservacion();
                    } else {
                        $sol2 = $solicitado->getInsollibro()->getTxlibtitulo();
                        $vsol2 = $solicitado->getDbsolvaladic();
                    }
                    //echo $inContador." - ".$solicitado->getInsollibro()->getTxlibtitulo();
                    $inContador++;
                }
                
                $arrOferta = array('inoferta' => $oferta->getInoferta(), 
                    'soli1' => $sol1, 
                    'valadic1' => $vsol1, 
                    'soli2' => $sol2, 
                    'valadic2' => $vsol2, 
                    'valventa' => $ejemplar->getDbejeavaluo(), 
                    'mensaje' => $mensaje 
                );
                        
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                    'titulo' => $ejemplar->getInejelibro()->getTxlibtitulo(), 
                    'autor' => $ejemplar->getInejelibro()->getTxlibautores(),
                    'edicion' => $ejemplar->getInejelibro()->getTxlibedicionnum(), 
                    'editorial' => $ejemplar->getInejelibro()->getTxlibeditorial(),
                    'idioma' => $ejemplar->getInejelibro()->getTxlibidioma(),
                    'indueno' => $usuario->getInusuario(), 'oferta' => $arrOferta
                ); 

                
                unset($arrGeneros);
                
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
     * respuestaCerrarSesion: 
     * Funcion que genera el JSON de respuesta para la accion de Cerrar Sesion :: AccesoController::txAccCerraSes
     */
    public function respuestaCerrarSesion($respuesta, $pSolicitud){
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
        * respuestaActualizarDatosUsuario: 
     * Funcion que genera el JSON de respuesta para la accion de Actualizar datos de usuario:: AccesoController::txAccActParam
     */
    public function respuestaActualizarDatosUsuario(Respuesta $respuesta, Solicitud $pSolicitud){
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
     * respuestaPublicaeEjemplar: 
     * Funcion que genera el JSON de respuesta para la accion de Publicar un ejemplar :: AccesoController::txAccPubliEje:
     */
    
    public function respuestaPublicarEjemplar(Respuesta $respuesta, Solicitud $pSolicitud){
        return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                    'ejemplar' => array('idejemplar' => $respuesta->getIdEjemplar(),
                        'titulo'=>$respuesta->getTitulo(), 'idlibro' => $respuesta->getIdlibro(),
                        'idioma'=>$respuesta->getIdioma(),'avaluo'=>$respuesta->getAvaluo(),
                        'valventa'=>$respuesta->getValVenta()),
                    'oferta'=>array('idoferta'=>$respuesta->getIdOferta(),'observasol'=>$respuesta->getObservaSol(),
                        'idlibrosol1'=>$respuesta->getIdLibroSol1(),'titulosol1'=>$respuesta->getTituloSol1(),
                        'valadicsol1'=>$respuesta->getValAdicSol1(),'idlibrosol2'=>$respuesta->getIdLibroSol2(),
                        'titulosol2'=>$respuesta->getTituloSol2(),'valadicsol2'=>$respuesta->getValAdicSol2()),
                    'mensaje'=>array('idmensaje'=>$respuesta->getIdMensaje(),
                        'fecha'=>$respuesta->getFeMensaje(), 'padre'=>$respuesta->getIdPadre(),
                        'descripcion'=>$respuesta->getTxMensaje())));
    }    
    
    /*
        * respuestaCambiarClave: 
     * Funcion que genera el JSON de respuesta para la accion de Cambiar clave de usuario:: AccesoController::txAccRecClave
     */
    public function respuestaCambiarClave(Respuesta $respuesta, Solicitud $pSolicitud){
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
        * respuestaMarcarMensaje: 
     * Funcion que genera el JSON de respuesta para la accion de Marcar el mensaje como Leído o No leído:: AccesoController::txAccMarcMens
     */
    public function respuestaMarcarMensaje(Respuesta $respuesta, Solicitud $pSolicitud){
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
        * respuestaListaIdiomas: 
     * Funcion que genera el JSON de respuesta para la accion de Listar Idiomas:: AccesoController::inListarIdi

     */
    public function respuestaListaIdiomas(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'idiomas' => $parreglo)));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    /*
        * respuestaListaLugares: 
     * Funcion que genera el JSON de respuesta para la accion de Listar Lugares:: AccesoController::inListarIdi

     */
    public function respuestaListaLugares(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'lugares' => $parreglo)));
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
                ->setFrom('registro@ex4read.co')
                ->setBcc('registro@ex4read.co')
                //->setFrom('baisicasas@gmail.com')
                //->setBcc('baisicasas@gmail.com')
                ->setTo($usuario->getTxusuemail())
                ->setBody($this->renderView(
                    'LibreameBackendBundle:Registro:registro.html.twig',
                    array('usuario' => $usuario->getTxusuemail(), 
                        'crurl' => "http://www.ex4read.co/web/registro/".Logica::generaCadenaURL($usuario))
            ),'text/html');

            $this->get('mailer')->send($message);
        
            return 0;
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }
    
    /*
     * generaCadenaURL 
     * Combina datos para entregar URL de Registro
     */
    public function generaCadenaURL(LbUsuarios $usuario)
    {   
        //Cantidad de caracteres del mail
        $caracEmail = strlen($usuario->getTxusuemail());
        //Arreglo de caractéres email
        if ($caracEmail > 99)  {
            $arCarMail[0] = floor($caracEmail / 100);
        } else {
            $arCarMail[0] = 0;
        }
        if ($caracEmail > 99)  {
            $arCarMail[1] = floor(($caracEmail-($arCarMail[0] * 100)) / 10);
        } else {
            $arCarMail[1] = floor($caracEmail / 10);
        }
        if ($caracEmail > 9)  {
            $arCarMail[2] = floor($caracEmail-(($arCarMail[0].$arCarMail[1])*10));
        } else {
            $arCarMail[2] = $caracEmail;
        }
        //echo "\nCaracteres Mail: ".$caracEmail;

        //echo "\nCar Mail 0: ".$arCarMail[0];
        //echo "\nCar Mail 1: ".$arCarMail[1];
        //echo "\nCar Mail 2: ".$arCarMail[2];
        //email
        $email = $usuario->getTxusuemail();
        //Inicializa la cadena
        $cadena = $usuario->gettxusuvalidacion();

        //echo 'arreglo: '.$arCarMail[0].'-'.$arCarMail[1].'-'.$arCarMail[2].'carac email: '.$caracEmail.'    -   valida: '.$cadena;
        //Obtener el patron de ocurrencia de datos
        $patron[0] = rand(1, 3);
        //echo "\nP1: ".$patron[0];
        $patron[1] = rand(1, 2);
        //echo "\nP2: ".$patron[1];
        $patron[2] = rand(1, 3);
        //echo "\nP3: ".$patron[2];

        $cadena = substr($cadena, 0, self::pos1mail).$arCarMail[0].$patron[0].$arCarMail[1].$patron[1]
                .$arCarMail[2].$patron[2].substr($cadena,2);

        //echo "\ncon patron: ".$cadena;

        /*for ($n=0;$n<$caracEmail;$n++) {
                $posClave[] = $patron[$pat]+7;
        }*/
        
        $pat = 0;
        for ($n=0;$n<$caracEmail;$n++) {
            if ($n==0) {
                $posClave[$n] = $patron[$pat]+8;
            } else {
                $posClave[$n] = $posClave[$n-1]+$patron[$pat];
            }
            
            //echo 'posicion: '.$posClave[$n];
            if ($pat==2) { $pat = 0; } else { $pat++; }
        }
        
        for($i=0;$i<$caracEmail;$i++) {
            $complem = substr($cadena, $posClave[$i]);
            //echo " \n ".$complem;
            $cadena = substr($cadena, 0, $posClave[$i]).substr($email,$i,1).$complem;
            //echo " \n ".$cadena;
        } 
        //echo "\n cadena_def: ".$cadena;
        return $cadena;
    }
    
    /*
     * validarRegistroUsuario: 
     * Funcion que genera realiza la validación del registro de usuario en el sistema, desde el email enviado por ex4read
     */
    public function validarRegistroUsuario($usuario, $clave)
    {
        try {
            $vUsuario = ManejoDataRepository::datosUsuarioValidos($usuario, $clave);
            $respuesta = AccesoController::inExitoso;
            if ($vUsuario == NULL) { $respuesta = AccesoController::inFallido; }
            
            if ($respuesta==AccesoController::inExitoso) {
                $respuesta = ManejoDataRepository::activarUsuarioRegistro($vUsuario);
            }
            return $respuesta;
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
