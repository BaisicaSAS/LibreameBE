<?php

namespace Libreame\BackendBundle\Helpers;

//use DateTime;
use Libreame\BackendBundle\Controller\AccesoController;
//use Doctrine\ORM\EntityManager;
use Libreame\BackendBundle\Repository\ManejoDataRepository;
use Libreame\BackendBundle\Entity\LbLugares;
use Libreame\BackendBundle\Entity\LbGeneros;
use Libreame\BackendBundle\Entity\LbLibros;
use Libreame\BackendBundle\Entity\LbAutores;
use Libreame\BackendBundle\Entity\LbEditoriales;
use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbEjemplares;
//use Libreame\BackendBundle\Entity\LbNegociacion;
//use Libreame\BackendBundle\Entity\LbHistejemplar;
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

                case AccesoController::txAccVisuaBib: {//Dato:16 : Visualizar Biblioteca
                    //echo "<script>alert('Antes de entrar a Visualizar Biblioteca-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::visualizarBiblioteca($solicitud);
                    break;
                } 

                case AccesoController::txAccPubMensa: {//Dato:19 : Chatear
                    //echo "<script>alert('Antes de entrar a Chatear-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::enviarMensajeChat($solicitud);
                    break;
                } 

                case AccesoController::txAccCaliTrat: {//Dato:22 : Calificar usuario trato
                    //echo "<script>alert('Antes de entrar a Chatear-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::calificarUsuarioTrato($solicitud);
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
                    //echo "Genera respuesta : ".$respuesta; 
                    break;
                } 

                case AccesoController::txAccListaLug: {//Dato:38 : Listar lugares
                    //echo "<script>alert('Antes de entrar a Listar idiomas Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestUsuarios = $this->get('gest_usuarios_service');
                    $respuesta = $objGestUsuarios::listarLugares($solicitud);
                    break;
                } 

                case AccesoController::txAccMegEjemp: {//Dato:40 : Marcar megusta ejemplar
                    //echo "<script>alert('Antes de entrar a Me gusta ejemplar Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::megustaEjemplar($solicitud);
                    break;
                } 

                case AccesoController::txAccVerUsMeg: {//Dato:41 : Ver usuarios a quienes les gusta un ejemplar
                    //echo "<script>alert('Antes de entrar a Ver usuarios Me gusta ejemplar Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::VerUsrgustaEjemplar($solicitud);
                    break;
                } 

                case AccesoController::txAccCommEjem: {//Dato:42 : Realizar, borrar, editar comentario a ejemplar
                    //echo "<script>alert('Antes de entrar a COMENTARIO ejemplar Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::comentarEjemplar($solicitud);
                    break;
                } 
                
                case AccesoController::txAccVerComEj: {//Dato:43 : Ver comentarios  ejemplar
                    //echo "<script>alert('Antes de entrar a COMENTARIO ejemplar Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::VerComentariosEjemplar($solicitud);
                    break;
                } 
                
                
                case AccesoController::txAccListaEdi: {//Dato:50 : Listar editoriales
                    //echo "<script>alert('Antes de entrar a Listar idiomas Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::listarEditoriales($solicitud);
                    break;
                } 

                case AccesoController::txAccListaAut: {//Dato:51 : Listar autores
                    //echo "<script>alert('Antes de entrar a Listar idiomas Usuario-".$solicitud->getEmail()."')</script>";
                    $objGestEjemplares = $this->get('gest_ejemplares_service');
                    $respuesta = $objGestEjemplares::listarAutores($solicitud);
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

                //accion de actualizar datos usuario
                case AccesoController::txAccActParam: //Dato:12 : Actualizar datos usuario
                    $JSONResp = Logica::respuestaActualizarDatosUsuario($respuesta, $pSolicitud);
                    break;
                
                //accion de publicar un ejemplar
                case AccesoController::txAccPubliEje:  //Dato: 13
                    $JSONResp = Logica::respuestaPublicarEjemplar($respuesta, $pSolicitud);
                    break;

                //accion de Visualizar biblioteca
                case AccesoController::txAccVisuaBib:  //Dato: 16
                    $JSONResp = Logica::respuestaVisualizarBiblioteca($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de Chatear
                case AccesoController::txAccPubMensa:  //Dato: 19
                    $JSONResp = Logica::respuestaEnviarMensajeChat($respuesta, $pSolicitud, $parreglo);
                    break;

                //accion de Calificar usuario trato
                case AccesoController::txAccCaliTrat:  //Dato: 22
                    $JSONResp = Logica::respuestaCalificarUsuarioTrato($respuesta, $pSolicitud);
                    break;

                case AccesoController::txAccRecClave: //Dato:29 : Cambio de clave
                    $JSONResp = Logica::respuestaCambiarClave($respuesta, $pSolicitud);
                    break;

                case AccesoController::txAccMarcMens: //Dato:36 : Marcar Mensaje
                    $JSONResp = Logica::respuestaMarcarMensaje($respuesta, $pSolicitud);
                    break;
                
                case AccesoController::txAccListaIdi: //Dato:37 : Listar idiomas
                    $JSONResp = Logica::respuestaListaIdiomas($respuesta, $pSolicitud, $parreglo);
                    //print_r(array_values($JSONResp));
                    break;
                
                case AccesoController::txAccListaLug: //Dato:38 : Listar Lugares
                    $JSONResp = Logica::respuestaListaLugares($respuesta, $pSolicitud, $parreglo);
                    break;
                
                case AccesoController::txAccMegEjemp: //Dato:40 : Marcar Megusta ejemplar
                    $JSONResp = Logica::respuestaMegustaEjemplar($respuesta, $pSolicitud);
                    break;
                
                case AccesoController::txAccVerUsMeg: //Dato:41 : Ver usuarios a quienes les gusta ejemplar
                    $JSONResp = Logica::respuestaVerUsuMegustaEjemplar($respuesta, $pSolicitud, $parreglo);
                    break;

                case AccesoController::txAccCommEjem: //Dato:42 : Realizar comentario a un ejemplar
                    $JSONResp = Logica::respuestaComentarioEjemplar($respuesta, $pSolicitud);
                    break;
                
                case AccesoController::txAccVerComEj: //Dato:43 : Ver comentarios ejemplar
                    $JSONResp = Logica::respuestaVerComentariosEjemplar($respuesta, $pSolicitud, $parreglo);
                    break;
                
                case AccesoController::txAccListaEdi: //Dato:50 : Listar editoriales
                    $JSONResp = Logica::respuestaListaEditoriales($respuesta, $pSolicitud, $parreglo);
                    //print_r(array_values($JSONResp));
                    break;
                
                case AccesoController::txAccListaAut: //Dato:51 : Listar autores
                    $JSONResp = Logica::respuestaListaAutores($respuesta, $pSolicitud, $parreglo);
                    //print_r(array_values($JSONResp));
                    break;
                
                
            }
            //echo " 1 La respuesta inicia";

            $respuestaGen = json_encode($JSONResp);
            //echo "2 La respuesta se imprimió - va a ".$respuestaGen;
            return $respuestaGen;
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
            $usuario = $respuesta->RespUsuarios[0];
            if ($usuario == NULL)  {
                $idusuario = NULL;
            } else {
                $idusuario = $usuario->getInusuario();
            }
                
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(),
                            'idusuario' => $idusuario,
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
            
            //echo "Va a generar respusta DatosUsuari0 \n";
            $usuario = new LbUsuarios();
            $usuario = ManejoDataRepository::getUsuarioByEmail($pSolicitud->getEmail());
            $lugar = new LbLugares();
            if ($respuesta->getRespuesta()== AccesoController::inULogged){
                $lugar = ManejoDataRepository::getLugar($usuario->getInusulugar());
            }
            if (!is_null($usuario)){
                if (is_null($usuario->getFeusunacimiento())) {
                    $fecha = "";
                } else {
                    $fecha = $usuario->getFeusunacimiento()->format('Y-m-d H:i:s');
                }
            }
            //echo "genero fecha \n";

            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(),
                    'usuario' => array('idusuario' => $usuario->getInusuario(), 
                        'nomusuario' => utf8_encode($usuario->getTxusunombre()),
                        'nommostusuario' => utf8_encode($usuario->getTxusunommostrar()), 
                        'email' => utf8_encode($usuario->getTxusuemail()),
                        'usutelefono' => utf8_encode($usuario->getTxusutelefono()), 
                        'usugenero' => $usuario->getInusugenero(),
                        //La siguiente línea debe habilitarse, e integrar el CAST de BLOB a TEXT??
                        //'usuimagen' => utf8_encode(base64_decode($respuesta->RespUsuarios[0]->getTxusuimagen())), 
                        'usuimagen' => utf8_encode($usuario->getTxusuimagen()), 
                        'usufecnac' => $fecha,
                        'usulugar' => $lugar->getInlugar(), 
                        'usunomlugar' => utf8_encode($lugar->getTxlugnombre()),
                        'usupromcalifica' => $respuesta->getPromCalificaciones(),
                        'puntosusuario' => $respuesta->getPunUsuario(),
                        'comentariosreci' => $respuesta->getArrCalificacionesReci(),
                        'comentariosreali' => $respuesta->getArrCalificacionesReali(),
                        'planusuario' => $respuesta->getArrPlanUsuario(),
                        'resumen' => $respuesta->getArrResumenU(),
                        'preferencias' => $respuesta->getArrPreferenciasU()))
                );
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
            $arrTmp = array();
            $ejemplar = new LbEjemplares();
            $usuarioConsulta = ManejoDataRepository::getUsuarioByEmail($pSolicitud->getEmail());
            //echo "Va a generar la respuestaBuscarEjemplares :: Logica.php [365] \n";
            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $generos = new LbGeneros();
                $autores = new LbAutores();
                $editoriales = new LbEditoriales();
                $libros = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    $libros = ManejoDataRepository::getLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "titulo libro: [".utf8_encode($libros->getTxlibtitulo())."]\n";
                    //echo "ejemplar: [".$ejemplar->getInejemplar()."--".$ejemplar->getInejelibro()->getInlibro()."] libro: [".utf8_encode($libros->getTxlibtitulo())."]\n";
                    $generos = ManejoDataRepository::getGenerosLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...generos \n";
                    $autores = ManejoDataRepository::getAutoresLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...autores \n";
                    $editoriales = ManejoDataRepository::getEditorialesLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...editoriales \n";
                    $megusta = ManejoDataRepository::getMegustaEjemplar($ejemplar, $usuarioConsulta);
                    //echo "...megusta \n";
                    $cantmegusta = ManejoDataRepository::getCantMegusta($ejemplar->getInejemplar());
                    //echo "...cantmegusta \n";
                    $cantcomment = ManejoDataRepository::getCantComment($ejemplar->getInejemplar());
                    //echo "...cantcomment \n";
                    $usuario = ManejoDataRepository::getUsuarioById($ejemplar->getInejeusudueno()->getInusuario());
                    //echo "...usuario [".utf8_encode($usuario->getTxusunommostrar())."] \n";
                    $promcalifica = ManejoDataRepository::getPromedioCalifica($usuario->getInusuario());
                    //echo "...promcalifica \n";
                    $fecpublica = ManejoDataRepository::getFechaPublicacion($ejemplar, $usuario);
                    //echo "...$fecpublica \n";
                    //echo "RECUPERO DATOS\n";*/
                }
                
                $arrAutores = array();
                foreach ($autores as $autor) {
                    //echo "...autor [".utf8_encode($autor->getTxautnombre())."] \n";
                    $arrAutores[] = array('inidautor' => $autor->getInidautor(),
                        'txautnombre' => utf8_encode($autor->getTxautnombre()));
                }
                $arrEditoriales = array();
                foreach ($editoriales as $editorial) {
                    //echo "...editorial [".utf8_encode($editorial->getTxedinombre())."] \n";
                    $arrEditoriales[] = array('inideditorial' => $editorial->getInideditorial(),
                        'txedinombre' => utf8_encode($editorial->getTxedinombre()));
                }
                $arrGeneros = array();
                foreach ($generos as $genero) {
                    //echo "...genero [".utf8_encode($genero->getTxgennombre())."] \n";
                    $arrGeneros[] = array('ingenero' => $genero->getIngenero(),
                        'txgennombre' => utf8_encode($genero->getTxgennombre()));
                }
                
                $titulo = utf8_encode($libros->getTxlibtitulo());
                $precio = utf8_encode($ejemplar->getDbejeavaluo());  //Precio del libro
                $puntos = utf8_encode($ejemplar->getInejepuntos()); //Cantidad de puntos
                $estado = utf8_encode($ejemplar->getInejeestado()); // de 1 a 10
                $usado = utf8_encode($ejemplar->getInejecondicion()); //0 nuevo - 1 usado
                $vencam = utf8_encode($ejemplar->getInejesoloventa()); //1: Solo venta - 2: venta / cambio - 3: Solo cambio
                $edicion = utf8_encode($libros->getTxediciondescripcion());
                $isbn10 = utf8_encode($libros->getTxlibcodigoofic());
                $isbn13 = utf8_encode($libros->getTxlibcodigoofic13());
                $imagen = utf8_encode($ejemplar->getTxejeimagen());
                $lugar = $usuario->getInusulugar();
                $condactual = $ejemplar->getInejeestadonegocio(); // 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega, 5 - Entregado, 6 - Recibido
                $desccondactual = utf8_encode(ManejoDataRepository::getDescCondicionActualEjemplar($ejemplar->getInejeestadonegocio())); // 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega, 5 - Entregado, 6 - Recibido
                //echo "Titulo + Descripcion edicion : [".$titulo."] - [".$edicion."]\n";
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                    'titulo' => $titulo, 
                    'precio' => $precio, 
                    'puntos' => $puntos, 
                    'estado' => $estado, 
                    'usado' => $usado, 
                    'vencam' => $vencam, 
                    'imagen' => $imagen, 
                    'edicion' => $edicion,
                    'isbn10' => $isbn10,
                    'isbn13' => $isbn13,
                    'megusta' => $megusta,
                    'fechapublica' => $fecpublica,
                    'cantmegusta' => $cantmegusta,
                    'cantcomment' => $cantcomment,
                    'condactual' => $condactual,
                    'desccondactual' => $desccondactual,
                    'lugar' => array('inlugar' => $lugar->getInlugar(), 'txlugnombre' => utf8_encode($lugar->getTxlugnombre())),
                    'autores' => $arrAutores,
                    'editoriales' => $arrEditoriales,
                    'generos' => $arrGeneros,
                    'usrdueno' => array('inusuario' => $usuario->getInusuario(),
                        'txusunommostrar' => utf8_encode($usuario->getTxusunommostrar()),
                        'txusuimagen' => utf8_encode($usuario->getTxusuimagen()),
                        'calificacion' => $promcalifica)
                );
                
            }
            
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                    'ejemplares' => $arrTmp ));

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
            $arrTmp = array();
            $ejemplar = new LbEjemplares();
            $usuarioConsulta = ManejoDataRepository::getUsuarioByEmail($pSolicitud->getEmail());
            //echo "Va a generar la respuestaFeedEjemplares :: Logica.php [365] \n";
            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $generos = new LbGeneros();
                $autores = new LbAutores();
                $editoriales = new LbEditoriales();
                $libros = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    $libros = ManejoDataRepository::getLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "titulo libro: [".utf8_encode($libros->getTxlibtitulo())."]\n";
                    //echo "ejemplar: [".$ejemplar->getInejemplar()."--".$ejemplar->getInejelibro()->getInlibro()."] libro: [".utf8_encode($libros->getTxlibtitulo())."]\n";
                    $generos = ManejoDataRepository::getGenerosLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...generos \n";
                    $autores = ManejoDataRepository::getAutoresLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...autores \n";
                    $editoriales = ManejoDataRepository::getEditorialesLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...editoriales \n";
                    $megusta = ManejoDataRepository::getMegustaEjemplar($ejemplar, $usuarioConsulta);
                    //echo "...megusta \n";
                    $cantmegusta = ManejoDataRepository::getCantMegusta($ejemplar->getInejemplar());
                    //echo "...cantmegusta \n";
                    $cantcomment = ManejoDataRepository::getCantComment($ejemplar->getInejemplar());
                    //echo "...cantcomment \n";
                    $usuario = ManejoDataRepository::getUsuarioById($ejemplar->getInejeusudueno()->getInusuario());
                    //echo "...usuario [".utf8_encode($usuario->getTxusunommostrar())."] \n";
                    $promcalifica = ManejoDataRepository::getPromedioCalifica($usuario->getInusuario());
                    //echo "...promcalifica \n";
                    $fecpublica = ManejoDataRepository::getFechaPublicacion($ejemplar, $usuario);
                    //echo "...$fecpublica \n";
                    //echo "RECUPERO DATOS\n";*/
                }
                
                $arrAutores = array();
                foreach ($autores as $autor) {
                    //echo "...autor [".utf8_encode($autor->getTxautnombre())."] \n";
                    $arrAutores[] = array('inidautor' => $autor->getInidautor(),
                        'txautnombre' => utf8_encode($autor->getTxautnombre()));
                }
                $arrEditoriales = array();
                foreach ($editoriales as $editorial) {
                    //echo "...editorial [".utf8_encode($editorial->getTxedinombre())."] \n";
                    $arrEditoriales[] = array('inideditorial' => $editorial->getInideditorial(),
                        'txedinombre' => utf8_encode($editorial->getTxedinombre()));
                }
                $arrGeneros = array();
                foreach ($generos as $genero) {
                    //echo "...genero [".utf8_encode($genero->getTxgennombre())."] \n";
                    $arrGeneros[] = array('ingenero' => $genero->getIngenero(),
                        'txgennombre' => utf8_encode($genero->getTxgennombre()));
                }
                
                $titulo = utf8_encode($libros->getTxlibtitulo());
                $precio = utf8_encode($ejemplar->getDbejeavaluo());  //Precio del libro
                $puntos = utf8_encode($ejemplar->getInejepuntos()); //Cantidad de puntos
                $estado = utf8_encode($ejemplar->getInejeestado()); // de 1 a 10
                $usado = utf8_encode($ejemplar->getInejecondicion()); //0 nuevo - 1 usado
                $vencam = utf8_encode($ejemplar->getInejesoloventa()); //1: Solo venta - 2: venta / cambio - 3: Solo cambio
                $edicion = utf8_encode($libros->getTxediciondescripcion());
                $isbn10 = utf8_encode($libros->getTxlibcodigoofic());
                $isbn13 = utf8_encode($libros->getTxlibcodigoofic13());
                $imagen = utf8_encode($ejemplar->getTxejeimagen());
                $lugar = $usuario->getInusulugar();
                $condactual = $ejemplar->getInejeestadonegocio(); // 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega, 5 - Entregado, 6 - Recibido
                $desccondactual = utf8_encode(ManejoDataRepository::getDescCondicionActualEjemplar($ejemplar->getInejeestadonegocio())); // 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega, 5 - Entregado, 6 - Recibido
                //echo "Titulo + Descripcion edicion : [".$titulo."] - [".$edicion."]\n";
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                    'titulo' => $titulo, 
                    'precio' => $precio, 
                    'puntos' => $puntos, 
                    'estado' => $estado, 
                    'usado' => $usado, 
                    'vencam' => $vencam, 
                    'imagen' => $imagen, 
                    'edicion' => $edicion,
                    'isbn10' => $isbn10,
                    'isbn13' => $isbn13,
                    'megusta' => $megusta,
                    'fechapublica' => $fecpublica,
                    'cantmegusta' => $cantmegusta,
                    'cantcomment' => $cantcomment,
                    'condactual' => $condactual,
                    'desccondactual' => $desccondactual,
                    'lugar' => array('inlugar' => $lugar->getInlugar(), 'txlugnombre' => utf8_encode($lugar->getTxlugnombre())),
                    'autores' => $arrAutores,
                    'editoriales' => $arrEditoriales,
                    'generos' => $arrGeneros,
                    'usrdueno' => array('inusuario' => $usuario->getInusuario(),
                        'txusunommostrar' => utf8_encode($usuario->getTxusunommostrar()),
                        'txusuimagen' => utf8_encode($usuario->getTxusuimagen()),
                        'calificacion' => $promcalifica)
                );
                
            }
            
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                    'ejemplares' => $arrTmp ));

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
            $calificacion = new LbCalificausuarios();
            foreach ($respuesta->getArrCalificacionesReci() as $calificacion){
                //$usuario = ManejoDataRepository::getUsuarioById($calificacion->getIncalusucalifica()->getInusuario());
                
                $arrTmp[] = array('idcalifica'=>$calificacion->getInidcalifica(),
                    'usucalifica' => $calificacion->getIncalusucalifica()->getInusuario(), 
                    'califica' => $calificacion->getIncalcalificacion(),
                    'mensaje' => $calificacion->getTxcalcomentario(),
                    'ejemplar' => $calificacion->getIncalhisejemplar()->getInhistejemplar()
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
                        'usuimagen' => "DUMMY", "calificacion" => $respuesta->getPromCalificaciones(),
                        'comentarios' => $arrTmp))
                );
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
                        'titulo'=>$respuesta->getTitulo(), 'idlibro' => $respuesta->getIdlibro()
                            )
                    ));
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
            //echo "respuesta idiomas \n";
            //print_r(array_values($parreglo));
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                            'idiomas' => $parreglo));
//                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'idiomas' => array('ididioma'=>$parreglo[][0], 'nomidioma'=>$parreglo[][1]))));
            //echo "termino armar \n" ;
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
        * respuestaMegustaEjemplar: 
     * Funcion que genera el JSON de respuesta para la accion de Dar Me gusta a ejemplar:: AccesoController::txAccMegEjemp

     */
    public function respuestaMegustaEjemplar(Respuesta $respuesta, Solicitud $pSolicitud){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 
                            'cantmegusta' => $respuesta->getCantMegusta(), 'cantcomenta' => $respuesta->getCantComenta())));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    /*
        * respuestaVerUsuariosMegustaEjemplar: 
     * Funcion que genera el JSON de respuesta para la accion de VEr usuarios Me gusta a ejemplar:: AccesoController::txAccVerUsMeg

     */
    public function respuestaVerUsuMegustaEjemplar(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'usuarios' => $parreglo)));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    /*
        * respuestaComentarEjemplar: 
     * Funcion que genera el JSON de respuesta para la accion de comentar a ejemplar:: AccesoController::txAccCommEjem

     */
    public function respuestaComentarioEjemplar(Respuesta $respuesta, Solicitud $pSolicitud){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 
                            'cantmegusta' => $respuesta->getCantMegusta(), 'cantcomenta' => $respuesta->getCantComenta())));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    /*
        * respuestaEnviarMensajeChat: 
     * Funcion que genera el JSON de respuesta para la accion de enviarMensajeChat:: AccesoController::txAccPublMens

     */
    public function respuestaEnviarMensajeChat(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'indacept' => $respuesta->getIndAcept(), 
                                'indotroacept' => $respuesta->getIndOtroAcept(), 'botonera' => $respuesta->getBotonesMostrar(), 'conversacion' => $parreglo )));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    

    /*
        * respuestaVerComentariosEjemplar: 
     * Funcion que genera el JSON de respuesta para la accion de comentar a ejemplar:: AccesoController::txAccCommEjem

     */
    public function respuestaVerComentariosEjemplar(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try {
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'comentarios' => $parreglo)));
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    public function respuestaVisualizarBiblioteca(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try{
            $arrTmp = array();
            $ejemplar = new LbEjemplares();
            $usuarioConsulta = ManejoDataRepository::getUsuarioByEmail($pSolicitud->getEmail());
            //echo "Va a generar la respuestaVisualizarBiblioteca :: Logica.php [365] \n";
            foreach ($parreglo as $ejemplar){
                //Recupera nombre del genero, Nombre del libro, Nombre del uduario Dueño
                $generos = new LbGeneros();
                $autores = new LbAutores();
                $editoriales = new LbEditoriales();
                $libros = new LbLibros();
                $usuario = new LbUsuarios();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    $libros = ManejoDataRepository::getLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "libro: [".utf8_encode($libros->getTxlibtitulo())."]\n";
                    //echo "ejemplar: [".$ejemplar->getInejemplar()."--".$ejemplar->getInejelibro()->getInlibro()."] libro: [".utf8_encode($libros->getTxlibtitulo())."]\n";
                    $generos = ManejoDataRepository::getGenerosLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...generos \n";
                    $autores = ManejoDataRepository::getAutoresLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...autores \n";
                    $editoriales = ManejoDataRepository::getEditorialesLibro($ejemplar->getInejelibro()->getInlibro());
                    //echo "...editoriales \n";
                    $arrHistEjemplar = ManejoDataRepository::getHistoriaEjemplarBiblioteca($ejemplar);
                    //echo "...histejemplar \n";
                    $arrNegociacion = ManejoDataRepository::getNegociacionEjemplarBiblioteca($ejemplar, $usuarioConsulta);
                    //echo "...negociacion \n";
                    $megusta = ManejoDataRepository::getMegustaEjemplar($ejemplar, $usuarioConsulta);
                    //echo "...megusta \n";
                    $cantmegusta = ManejoDataRepository::getCantMegusta($ejemplar->getInejemplar());
                    //echo "...cantmegusta \n";
                    $cantcomment = ManejoDataRepository::getCantComment($ejemplar->getInejemplar());
                    //echo "...cantcomment \n";
                    $usuario = ManejoDataRepository::getUsuarioById($ejemplar->getInejeusudueno()->getInusuario());
                    //echo "...usuario [".utf8_encode($usuario->getTxusunommostrar())."] \n";
                    $promcalifica = ManejoDataRepository::getPromedioCalifica($usuario->getInusuario());
                    //echo "...promcalifica \n";
                    $fecpublica = ManejoDataRepository::getFechaPublicacion($ejemplar, $usuario);
                    //echo "...$fecpublica \n";
                    //echo "RECUPERO DATOS\n";*/
                }
                
                $arrAutores = array();
                foreach ($autores as $autor) {
                    //echo "...autor [".utf8_encode($autor->getTxautnombre())."] \n";
                    $arrAutores[] = array('inidautor' => $autor->getInidautor(),
                        'txautnombre' => utf8_encode($autor->getTxautnombre()));
                }
                $arrEditoriales = array();
                foreach ($editoriales as $editorial) {
                    //echo "...editorial [".utf8_encode($editorial->getTxedinombre())."] \n";
                    $arrEditoriales[] = array('inideditorial' => $editorial->getInideditorial(),
                        'txedinombre' => utf8_encode($editorial->getTxedinombre()));
                }
                $arrGeneros = array();
                foreach ($generos as $genero) {
                    //echo "...genero [".utf8_encode($genero->getTxgennombre())."] \n";
                    $arrGeneros[] = array('ingenero' => $genero->getIngenero(),
                        'txgennombre' => utf8_encode($genero->getTxgennombre()));
                }
                $titulo = utf8_encode($libros->getTxlibtitulo());
                $precio = utf8_encode($ejemplar->getDbejeavaluo());  //Precio del libro
                $puntos = utf8_encode($ejemplar->getInejepuntos()); //Cantidad de puntos
                $estado = utf8_encode($ejemplar->getInejeestado()); // de 1 a 10
                $usado = utf8_encode($ejemplar->getInejecondicion()); //0 nuevo - 1 usado
                $vencam = utf8_encode($ejemplar->getInejesoloventa()); //1: Solo venta - 2: venta / cambio - 3: Solo cambio
                $edicion = utf8_encode($libros->getTxediciondescripcion());
                $isbn10 = utf8_encode($libros->getTxlibcodigoofic());
                $isbn13 = utf8_encode($libros->getTxlibcodigoofic13());
                $imagen = utf8_encode($ejemplar->getTxejeimagen());
                $lugar = $usuario->getInusulugar();
                $condactual = $ejemplar->getInejeestadonegocio(); // 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega, 5 - Entregado, 6 - Recibido
                $desccondactual = utf8_encode(ManejoDataRepository::getDescCondicionActualEjemplar($ejemplar->getInejeestadonegocio())); // 0 - No en negociacion,1 - Solicitado por usuario, 2 - En proceso de aprobación del negocio, 3 - Aprobado negocio por Ambos actores, 4 - En proceso de entrega, 5 - Entregado, 6 - Recibido
                //echo "Titulo + Descripcion edicion : [".$titulo."] - [".$edicion."]\n";
                if ($condactual == 0) {///Si el ejemplar NO está en negociacion se puede editar
                    //Si está bloqueado no se puede editar
                    if ($ejemplar->getInejebloqueado() == AccesoController::inDatoUno){
                        $puedeeditar = AccesoController::inDatoCer;
                    } else  {
                        $puedeeditar = AccesoController::inDatoUno;
                    }
                } else { //En negociacion NO se puede editar
                    $puedeeditar = AccesoController::inDatoCer;
                }
                    
                $arrTmp[] = array('idejemplar' => $ejemplar->getInejemplar(), 
                    'titulo' => $titulo, 
                    'precio' => $precio, 
                    'puntos' => $puntos, 
                    'estado' => $estado, 
                    'usado' => $usado, 
                    'vencam' => $vencam, 
                    'imagen' => $imagen, 
                    'edicion' => $edicion,
                    'isbn10' => $isbn10,
                    'isbn13' => $isbn13,
                    'publicado' => $ejemplar->getInejepublicado(),
                    'megusta' => $megusta,
                    'fechapublica' => $fecpublica,
                    'cantmegusta' => $cantmegusta,
                    'cantcomment' => $cantcomment,
                    'condactual' => $condactual,
                    'desccondactual' => $desccondactual,
                    'puedeeditar' => $puedeeditar,
                    'lugar' => array('inlugar' => $lugar->getInlugar(), 'txlugnombre' => utf8_encode($lugar->getTxlugnombre())),
                    'autores' => $arrAutores,
                    'editoriales' => $arrEditoriales,
                    'generos' => $arrGeneros,
                    'histejemplar' => $arrHistEjemplar,
                    'chats' => $arrNegociacion
                );
                
            }
            
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                    'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                    'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                    'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                    'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                    'ejemplares' => $arrTmp ));

        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    
    /*
        * respuestaCalificarUsuarioTrato: 
     * Funcion que genera el JSON de respuesta para la accion de CAlificarUsuarioTRato:: AccesoController::txAccCaliTrat

     */
    public function respuestaCalificarUsuarioTrato(Respuesta $respuesta, Solicitud $pSolicitud){
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
     * enviaMailRegistro 
     * Se encarga de enviar el email con el que el usuario confirmara su registro
     */
    public function enviaMailRegistro($usuario)
    {   
        try{
            $cadena = Logica::generaCadenaURL($usuario);
            #echo "cadena enviada = "."http://www.ex4read.co/web/registro/".$cadena;
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
                        'crurl' => "http://ex4read.co/exservices/web/registro/".$cadena)
                        //'crurl' => "http://www.ex4read.co/web/registro/".$cadena)
                        //'crurl' => "http://www.ex4read.co/web/registro/".Logica::generaCadenaURL($usuario))
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
    
    public function validarRegistroGeneradoUsuario($usuario, $clave)
    {
        try {
            //echo "logica:usr ".$usuario;
            //echo "logica:clave ".$clave;
            $vUsuario = new LbUsuarios();
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

    public function respuestaListaEditoriales(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try {
            //echo "respuesta idiomas \n";
            //print_r(array_values($parreglo));
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                            'editoriales' => $parreglo));
//                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'idiomas' => array('ididioma'=>$parreglo[][0], 'nomidioma'=>$parreglo[][1]))));
            //echo "termino armar \n" ;
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    
    public function respuestaListaAutores(Respuesta $respuesta, Solicitud $pSolicitud, $parreglo){
        try {
            //echo "respuesta idiomas \n";
            //print_r(array_values($parreglo));
            return array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                            'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                            'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                            'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                            'idrespuesta' => array('respuesta' => $respuesta->getRespuesta(), 
                            'autores' => $parreglo));
//                            'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(), 'idiomas' => array('ididioma'=>$parreglo[][0], 'nomidioma'=>$parreglo[][1]))));
            //echo "termino armar \n" ;
        } catch (Exception $ex) {
                return AccesoController::inPlatCai;
        } 
    }    
    

}
