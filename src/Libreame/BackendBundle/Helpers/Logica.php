<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Helpers\Respuesta;
use Libreame\BackendBundle\Entity\LbLugares;


class Logica 
{   

    //public $datosAcceso; //Tipo Clase AccesoController
            
    /*
     * Esta funcion configurada como servicio se encarga de recibir la información del cliente
     * luego de que ha sido validada por el controlador AccesoController. Luego de recibirla
     * Evalua la accion solicitada, ejecuta lo solicitado y retorna la respuesta al controlador.
     */
    public function ejecutaAccion($solicitud)
    {
        $respuesta = AccesoController::inFallido;
        $tmpSolicitud = $solicitud->getAccion();
        //echo "<script>alert('".$tmpSesion."-".AccesoController::txAccRegistro."')</script>";
        switch ($tmpSolicitud){
            //accion de registro en el sistema
            case AccesoController::txAccRegistro: {
                //echo "<script>alert('Antes de entrar a Registro-".$solicitud->getEmail()."')</script>";
                $objRegistro = $this->get('registro_service');
                $respuesta = $objRegistro::registroUsuario($solicitud);
                break;
            }    
            //accion de login en el sistema
            case AccesoController::txAccIngresos: {
                //echo "<script>alert('Antes de entrar a Login-".$solicitud->getEmail()."')</script>";
                $objLogin = $this->get('login_service');
                $respuesta = $objLogin::loginUsuario($solicitud);
                break;
            } 
            //accion de recuperar datos y parametros de usuario
            case AccesoController::txAccRecParam: {
                //echo "<script>alert('Antes de entrar a Recuperar Parametros Usuario-".$solicitud->getEmail()."')</script>";
                $objParametros = $this->get('parametros_service');
                $respuesta = $objParametros::obtenerParametros($solicitud);
                break;
            } 
            
            case AccesoController::txAccRecFeeds: {
                //echo "<script>alert('Antes de entrar a Recuperar Parametros Usuario-".$solicitud->getEmail()."')</script>";
                $objFeeds = $this->get('feeds_service');
                $respuesta = $objFeeds::obtenerFeeds($solicitud);
                break;
            } 
                
        }
        //echo "<script>alert('ejecuta Accion: ".$respuesta."')</script>";
        return $respuesta;
    }
    
    public function generaRespuesta($respuesta, $pSolicitud){

        //echo "<script>alert('ACCION Genera respuesta: ".$pSolicitud->getAccion()."')</script>";
        //echo "<script>alert('REPUESTA Genera respuesta: ".$respuesta->getRespuesta()."')</script>";

        switch($pSolicitud->getAccion()){
            
            //accion de registro en el sistema
            case AccesoController::txAccRegistro: 
                $JSONResp = array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                        'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta())));
                break;
                
            //accion de login en el sistema
            case AccesoController::txAccIngresos:
                //$vRespuesta
                $JSONResp = array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                        'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(),
                            'idsesion' => $respuesta->getSession(), 
                            'cantmensajes' => $respuesta->getCantMensajes())));
                break;

            //accion de recuperar datos y parametros de usuario
            case AccesoController::txAccRecParam:
                //Recupera el lugar, de la tabla de Lugares
                $em = $this->getDoctrine()->getManager();
                $lugar = new LbLugares();
                if ($respuesta->getRespuesta()== AccesoController::inULogged){
                    $lugar = $em->getRepository('LibreameBackendBundle:LbLugares')->
                        findOneBy(array('inlugar' => $respuesta->RespUsuarios[0]->getInusulugar()));
                }
                
                $JSONResp = array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
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

                break;
                
            case AccesoController::txAccRecFeeds:
                //Recupera el lugar, de la tabla de Ejemplares
                $em = $this->getDoctrine()->getManager();
                $JSONResp = array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                        'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(),
                        'ejemplares' => (array('nomusuario' => $respuesta->RespUsuarios[0]->getTxusunombre(),
                            'nommostusuario' => $respuesta->RespUsuarios[0]->getTxusunommostrar(), 
                            'email' => $respuesta->RespUsuarios[0]->getTxusuemail(),
                            'usutelefono' => $respuesta->RespUsuarios[0]->getTxusutelefono(), 
                            'usugenero' => $respuesta->RespUsuarios[0]->getInusugenero(),
                            'usuimagen' => $respuesta->RespUsuarios[0]->getTxusuimagen(), 
                            'usufecnac' => $respuesta->RespUsuarios[0]->getFeusunacimiento(),
                            'usulugar' => $lugar->getInlugar(), 
                            'usunomlugar' => $lugar->getTxlugnombre())),
                            array('nomusuario' => $respuesta->RespUsuarios[0]->getTxusunombre(),
                            'nommostusuario' => $respuesta->RespUsuarios[0]->getTxusunommostrar(), 
                            'email' => $respuesta->RespUsuarios[0]->getTxusuemail(),
                            'usutelefono' => $respuesta->RespUsuarios[0]->getTxusutelefono(), 
                            'usugenero' => $respuesta->RespUsuarios[0]->getInusugenero(),
                            'usuimagen' => $respuesta->RespUsuarios[0]->getTxusuimagen(), 
                            'usufecnac' => $respuesta->RespUsuarios[0]->getFeusunacimiento(),
                            'usulugar' => $lugar->getInlugar(), 
                            'usunomlugar' => $lugar->getTxlugnombre())                            
                                ))));

                break;
        }
        
        $JSONResp = json_encode($JSONResp);

        return $JSONResp;
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
