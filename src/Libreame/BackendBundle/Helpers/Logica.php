<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Controller\AccesoController;


class Logica 
{   

    public $datosAcceso; //Tipo Clase AccesoController
            
    /*
     * Esta funcion configurada como servicio se encarga de recibir la información del cliente
     * luego de que ha sido validada por el controlador AccesoController. Luego de recibirla
     * Evalua la accion solicitada, ejecuta lo solicitado y retorna la respuesta al controlador.
     */
    public function ejecutaAccion($datos, $solicitud)
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

        switch($pSolicitud->getAccion()){
            
            case AccesoController::txAccRegistro: 
                $JSONResp = array(array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'usuario' => $pSolicitud->getUsuario(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()
                        )), 
                        array('idrespuesta' => (array($respuesta[0][0] => $respuesta[0][1]))));
                break;
                
            case AccesoController::txAccRegistro: 
                $JSONResp = array(array('idsesion' => array ('idaccion' => $pSolicitud->getAccion(),
                        'usuario' => $pSolicitud->getUsuario(),
                        'idtrx' => '', 'ipaddr'=> $pSolicitud->getIPaddr(), 
                        'iddevice'=> $pSolicitud->getDeviceMac(), 'marca'=>$pSolicitud->getDeviceMarca(), 
                        'modelo'=>$pSolicitud->getDeviceModelo(), 'so'=>$pSolicitud->getDeviceSO()
                        )), 
                        array('idrespuesta' => (array($respuesta[0][0] => $respuesta[0][1],
                            $respuesta[1][0] => $respuesta[1][1], $respuesta[2][0] => $respuesta[2][1]))));
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
