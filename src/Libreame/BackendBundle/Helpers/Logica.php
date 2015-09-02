<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;
use Libreame\BackendBundle\Helpers\Respuesta;


class Logica 
{   

    public $datosAcceso; //Tipo Clase AccesoController
            
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
                
        }
        //echo "<script>alert('ejecuta Accion: ".$respuesta."')</script>";
        return $respuesta;
    }
    
    public function generaRespuesta($respuesta, $pSolicitud){

        //echo "<script>alert('ACCION Genera respuesta: ".$pSolicitud->getAccion()."')</script>";
        //echo "<script>alert('REPUESTA Genera respuesta: ".$respuesta->getRespuesta()."')</script>";

        switch($pSolicitud->getAccion()){
            
            case AccesoController::txAccRegistro: 
                $JSONResp = array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'usuario' => $pSolicitud->getUsuario(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                        'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta())));
                break;
                
            case AccesoController::txAccIngresos:
                //$vRespuesta
                $JSONResp = array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'usuario' => $pSolicitud->getUsuario(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()), 
                        'idrespuesta' => (array('respuesta' => $respuesta->getRespuesta(),
                            'idsesion' => $respuesta->getSession(), 
                            'cantmensajes' => $respuesta->getCantMensajes())));
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
