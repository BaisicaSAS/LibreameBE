<?php


namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Repository\ManejoDataRepository;

use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbSesiones;
use Libreame\BackendBundle\Entity\LbMensajes;
use Libreame\BackendBundle\Entity\LbCalificausuarios;
use Libreame\BackendBundle\Entity\LbLugares;
/**
 * Description of Gestion Usuarios
 *
 * @author mramirez
 */
class GestionUsuarios {
    
    /* ObtenerParametros 
     * Retorna la información del usuario que se encuentra logueado, para visualización
     */

    public function obtenerParametros($psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        $califica = new LbCalificausuarios();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' obtenerParametros :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Busca el usuario 
                $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
                if (!is_null($usuario)) 
                {
                    //echo "<script>alert(' SI ESTA EL USUARIO ".$respSesionVali." ')</script>";
                    $califiRecibidas = ManejoDataRepository::getCalificaUsuarioRecibidas($usuario);
                    //echo "<script>alert(' SI ESTA EL USUARIO ".$respSesionVali." ')</script>";
                    $califiRealizadas = ManejoDataRepository::getCalificaUsuarioRealizadas($usuario);
                   //echo "<script>alert('RESP CALIFICA  ".count($califica)." ')</script>";
                    $grupo= ManejoDataRepository::getObjetoGruposUsuario($usuario);

                    $arrGru = array();
                    foreach ($grupo as $gru){
                        $arrGru[] = $gru->getIngrupo();
                    }

                    //echo "<script>alert('RESP GRUPO ".count($arrGru)." ')</script>";
                    //echo "<script>alert('La sesion es ".$usuario->getTxusuemail()."')</script>";

                    //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                    //Busca y recupera el objeto de la sesion:: 
                    //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                    //Guarda la actividad de la sesion:: 
                    //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Datos de usuario ".$psolicitud->getEmail()." recuperados con éxito",$psolicitud->getAccion(),$fecha,$fecha);
                    //echo "<script>alert('Generó actividad de sesion ')</script>";

                    $respuesta->setRespuesta(AccesoController::inExitoso);

                    //echo "<script>alert('2 Validez de sesion ".$respuesta." ')</script>";
                    //Ingresa el usuario en el arreglo de la Clase respuesta
                    //echo "<script>alert('ALEX ')</script>";
                    //$respuesta->setArrUsuarios($usuario);
                    $respuesta->setPromCalificaciones(ManejoDataRepository::getPromedioCalifica($usuario->getInusuario()));
                    $respuesta->setPunUsuario(ManejoDataRepository::getPuntosUsuario($usuario));
                    //echo "<script>alert('ALEX ".$respuesta->RespUsuarios[0]->getTxusunombre()." ')</script>";
                    
                    
                    $arrCalifiRecibidas = array();
                    foreach ($califiRecibidas as $calificaRc) {
                       $arrCalifiRecibidas[] = array("idcalifica"=>$calificaRc->getInidcalifica(),
                                            "idusrcalif" => $calificaRc->getIncalusucalifica()->getInusuario(),
                                            "nomusrcalif" => $calificaRc->getIncalusucalifica()->getTxusunommostrar(),
                                            "incalificacion" => $calificaRc->getIncalcalificacion(),
                                            "comentario" => $calificaRc->getTxcalcomentario(),
                                            "fecha" => $calificaRc->getFecalfecha()->format('Y-m-d H:i:s'));
                    }
                    
                    $arrCalifiRealizadas = array();
                    foreach ($califiRealizadas as $calificaRe) {
                       $arrCalifiRealizadas[] = array("idcalifica"=>$calificaRe->getInidcalifica(),
                                            "idusrcalif" => $calificaRe->getIncalusucalificado()->getInusuario(),
                                            "nomusrcalif" => $calificaRe->getIncalusucalificado()->getTxusunommostrar(),
                                            "incalificacion" => $calificaRe->getIncalcalificacion(),
                                            "comentario" => $calificaRe->getTxcalcomentario(),
                                            "fecha" => $calificaRe->getFecalfecha()->format('Y-m-d H:i:s'));
                    }
                    
                    $respuesta->setArrCalificacionesReali($arrCalifiRealizadas);
                    $respuesta->setArrCalificacionesReci($arrCalifiRecibidas);
                    $respuesta->setArrGrupos($arrGru);
                    $planusuario = ManejoDataRepository::getPlanUsuario($usuario);
                    //$arrPlanUsuario = array();
                    //foreach ($planusuario as $plan) {
                    $arrPlanUsuario = array("inplan"=>$planusuario->getInplan(),
                                            "txplannombre" => utf8_encode($planusuario->getTxplannombr()),
                                            "txplandescripcion" => utf8_encode($planusuario->getTxplandescripcion()),
                                            "gratis" => $planusuario->getInplanfree(),
                                            "maxlibmes" => $planusuario->getInplancantejemes(),
                                            //"vigencia" => utf8_encode($planusuario->getFeplanfinvigencia()->format('Y-m-d H:i:s')),
                                            "fecha" => utf8_encode($planusuario->getFeplanfinvigencia()->format('Y-m-d H:i:s')));
                    //echo "<script>alert('RESP PLANES ".count($planusuario)." ')</script>";
                    $respuesta->setArrPlanUsuario($arrPlanUsuario);
                    
                    $respuesta->setArrResumenU(ManejoDataRepository::getResumenUsuario($usuario)); 
                    $respuesta->setArrPreferenciasU(ManejoDataRepository::getPreferenciasUsuario($usuario, 5)); //Solo 5 registros de preferencias máximo
                    //echo "<script>alert('Finaliza - va a respuesta ".$respuesta->RespUsuarios[0]->getTxusunombre()." ')</script>";
                } else {
                    //echo "No encontro usuario";
                    $usuario = new LbUsuarios();
                    $respuesta->setRespuesta(AccesoController::inMenNoEx);
                    $respuesta->setArrUsuarios($usuario);
                }
            } else {
                //echo "No logueado";
                $usuario = new LbUsuarios();
                $respuesta->setRespuesta($respSesionVali);
                $respuesta->setArrUsuarios($usuario);
            }
        } catch (Exception $ex) {
            //echo "Error...";
            $respuesta->setRespuesta(AccesoController::inPlatCai);
        } finally {
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $usuario);
        }
    }
    
    /* recuperarMensajes 
     * Retorna la información de los mensajes del usuario
     */
    
    public function recuperarMensajes($psolicitud)
    {
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $mensaje = new LbMensajes();
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=ManejoDataRepository::validaSesionUsuario($psolicitud);
           //echo "<script>alert(' obtenerParametros :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Busca el usuario 
                $usuario = ManejoDataRepository::getUsuarioByEmail($psolicitud->getEmail());
                //echo "[".$usuario->getTxusuemail()."]";
                $mensaje = ManejoDataRepository::getMensajesUsuario($usuario);

                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //Guarda la actividad de la sesion:: 
                //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Datos de usuario ".$psolicitud->getEmail()." recuperados con éxito",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                $respuesta->setRespuesta(AccesoController::inExitoso);
            } else {
                $respuesta->setRespuesta($respSesionVali);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
        } finally {
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $mensaje);
        }
    }
    
    /* marcarMensajes 
     * Marca un mensaje como leído o no leído según el usuario lo indique
     */

    public function marcarMensajes(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' marcarMensajes :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Genera la oferta para el ejemplar
                $marca = ManejoDataRepository::setMarcaMensaje($psolicitud);
                if ($marca == AccesoController::inMenNoEx) {
                    $respuesta->setRespuesta(AccesoController::inMenNoEx);
                } else {
                    $respuesta->setRespuesta($respSesionVali);
                }
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
        }
       
    }
    
    public function verUsuarioOtro($psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        $usuario = new LbUsuarios();
        $sesion = new LbSesiones();
        $califica = new LbCalificausuarios();
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=ManejoDataRepository::validaSesionUsuario($psolicitud);
           //echo "<script>alert(' obtenerParametros :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Busca el usuario 
                $usuario = ManejoDataRepository::getUsuarioById($psolicitud->getIdusuariover());
                if ($usuario != NULL)
                {
                    $califica = ManejoDataRepository::getCalificaUsuarioRecibidas($usuario);
                    //echo "<script>alert('RESP cali ".count($califica)." ')</script>";
                    //echo "<script>alert('La sesion es ".$usuario->getTxusuemail()."')</script>";

                    //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                    //Busca y recupera el objeto de la sesion:: 
                    //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                    //Guarda la actividad de la sesion:: 
                    //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Datos de usuario ".$psolicitud->getEmail()." recuperados con éxito",$psolicitud->getAccion(),$fecha,$fecha);
                    //echo "<script>alert('Generó actividad de sesion ')</script>";

                    $respuesta->setRespuesta(AccesoController::inExitoso);

                    //echo "<script>alert('2 Validez de sesion ".$respuesta." ')</script>";
                    //Ingresa el usuario en el arreglo de la Clase respuesta
                    //echo "<script>alert('ALEX ')</script>";
                    $respuesta->setArrUsuarios($usuario);
                    //echo "<script>alert('ALEX ".$respuesta->RespUsuarios[0]->getTxusunombre()." ')</script>";
                    $respuesta->setArrCalificacionesReci($califica);
                    $promcal = ManejoDataRepository::getPromedioCalifica($usuario);
                    //echo "prom ".$promcal."\n";
                    $respuesta->setPromCalificaciones($promcal);
                } else {
                    $usuario = new LbUsuarios();
                    $respuesta->setRespuesta(AccesoController::inMenNoEx);
                    $respuesta->setArrUsuarios($usuario);
                }
            } else {
                $usuario = new LbUsuarios();
                $respuesta->setRespuesta($respSesionVali);
                $respuesta->setArrUsuarios($usuario);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
        } finally {
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $usuario);
        }
    }
    
    public function listarLugares(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' buscarEjemplares :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    

                //SE INACTIVA PORQUE PUEDE GENERAR UNA GRAN CANTIDAD DE REGISTROS EN UNA SOLA SESION
                //Busca y recupera el objeto de la sesion:: 
                //$sesion = ManejoDataRepository::recuperaSesionUsuario($usuario,$psolicitud);
                //echo "<script>alert('La sesion es ".$sesion->getTxsesnumero()." ')</script>";
                //Guarda la actividad de la sesion:: 
                //ManejoDataRepository::generaActSesion($sesion,AccesoController::inDatoUno,"Recupera Feed de Ejemplares".$psolicitud->getEmail()." recuperados con éxito ",$psolicitud->getAccion(),$fecha,$fecha);
                //echo "<script>alert('Generó actividad de sesion ')</script>";
                
                $respuesta->setRespuesta(AccesoController::inExitoso);
                
                //$arLugares = new array();
                
                $lugares = ManejoDataRepository::getLugares();
                $lugar = new LbLugares();
                $arLugares = array();
                
                //$contador = 0;
                foreach ($lugares as $lugar) {
                    $arLugares[] = array("idlugar"=>$lugar->getInlugar(),"nomlugar"=>utf8_encode($lugar->getTxlugnombre()));
                    //$contador++;
                }
                //echo $contador." - lugares hallados";
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $arLugares);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                $arLugares = array();
                return $objLogica::generaRespuesta($respuesta, $psolicitud, $arLugares);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            $arLugares = array();
            return $objLogica::generaRespuesta($respuesta, $psolicitud, $arLugares);
        }
       
    }

    
    public function actualizarDatosUsuario(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' marcarMensajes :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Genera la oferta para el ejemplar
                $actualiza = ManejoDataRepository::setActualizaUsuario($psolicitud);
                if ($actualiza == AccesoController::inFallido){
                    $respuesta->setRespuesta(AccesoController::inFallido);
                } else {
                    $respuesta->setRespuesta($respSesionVali);
                }
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
        }
       
    }    

    public function actualizarClaveUsuario(Solicitud $psolicitud)
    {   
        //echo 'INGRESA ACTUALIZAR CLAVE ';
         /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' marcarMensajes :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
               
                //echo 'Esta logueado';
                $actualiza = ManejoDataRepository::setCambiarClave($psolicitud);
                if ($actualiza == AccesoController::inFallido){
                    //echo 'Responde fallido';
                    $respuesta->setRespuesta(AccesoController::inFallido);
                } else {
                    //echo 'Responde sesion valida';
                    $respuesta->setRespuesta($respSesionVali);
                }
                
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            } else {
                //echo 'NO LOGUEADO';
                $respuesta->setRespuesta($respSesionVali);
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
        }
       
    }    
    
    
    public function calificarUsuarioTrato(Solicitud $psolicitud)
    {   
        /*setlocale (LC_TIME, "es_CO");
        $fecha = new \DateTime;*/
        $respuesta = new Respuesta();
        $objLogica = $this->get('logica_service');
        try {
            //Valida que la sesión corresponda y se encuentre activa
            $respSesionVali=  ManejoDataRepository::validaSesionUsuario($psolicitud);
            //echo "<script>alert(' marcarMensajes :: Validez de sesion ".$respSesionVali." ')</script>";
            if ($respSesionVali==AccesoController::inULogged) 
            {    
                //Genera la oferta para el ejemplar
                $actualiza = ManejoDataRepository::setCalificaUsuarioTrato($psolicitud);
                if ($actualiza == AccesoController::inFallido){
                    $respuesta->setRespuesta(AccesoController::inFallido);
                } else {
                    $respuesta->setRespuesta($respSesionVali);
                }
                
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            } else {
                $respuesta->setRespuesta($respSesionVali);
                return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
            }
        } catch (Exception $ex) {
            $respuesta->setRespuesta(AccesoController::inPlatCai);
            return $objLogica::generaRespuesta($respuesta, $psolicitud, NULL);
        }
       
    }    

}
