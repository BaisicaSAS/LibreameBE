<?php

namespace Libreame\BackendBundle\Helpers;

/**
 * Esta clase contiene la información recibida de la solicitud de un usuario::: 
 * Puede entenderse como la Clase que recibe la infoirmacion del JSON
 *
 * @author mramirez
 */
class Solicitud {
    //@TODO: Reorganizar el encabezado para que contenga solo IDs, y solo la información que identifica la Transaccion. 
    //Todo el resto debe ir ebn el detalle...ejemplo el telefono
    //Atributos para el encabezado: identificado en el tag IDSESION del JSON
    private $pAccion; //Accion solicitada
    private $pUsuario; //Nombre de usuario que realiza solicitud
    private $pSession; //Sesion ???? 
    private $pIPaddr; //Direccion IP
    private $pDeviceMAC; //MAC del Dispositivo
    private $pDeviceMarca; // Marca del dispositivo
    private $pDeviceModelo; //Modelo del dispositivo
    private $pDeviceSO; //Sistema operativo del dispositivo

    //Atributos para el detalle: identificado en el tag IDSOLICITUD del JSON
    //C01: Registro 
    private $pEmail; //Mail del usuario
    private $pTelefono; //Numero telefónico 
    //$pClave se utiliza tambien para C02: Login
    private $pClave; //Clave del usuario
    
    /*
     *  Bloque de getter para los atributos de la clase
     */
    
    public function getAccion() {
        return $this->pAccion;
    }

    public function getUsuario() {
        return $this->pUsuario;
    }

    public function getSession() {
        return $this->pSession;
    }

    public function getIPaddr() {
        return $this->pIPaddr;
    }

    public function getDeviceMac() {
        return $this->pDeviceMAC;
    }

    public function getDeviceMarca() {
        return $this->pDeviceMarca;
    }

    public function getDeviceModelo() {
        return $this->pDeviceModelo;
    }

    public function getDeviceSO() {
        return $this->pDeviceSO;
    }

    public function getEmail() {
        return $this->pEmail;
    }
    
    public function getClave() {
        return $this->pClave;
    }

    public function getTelefono() {
        return $this->pTelefono;
    }
    
    /*
     *  Bloque de setter para los atributos de la clase
     */
    public function setAccion($pAccion) {
        $this->pAccion = $pAccion;
        return $this;
    }

    public function setUsuario($pUsuario) {
        $this->pUsuario = $pUsuario;
        return $this;
    }

    public function setSession($pSesion) {
        $this->pSession = $pSesion;
        return $this;
    }

    public function setIPaddr($pIPaddr) {
        $this->pIPaddr = $pIPaddr;
        return $this;
    }

    public function setDeviceMAC($pDeviceMAC) {
        $this->pDeviceMAC = $pDeviceMAC;
        return $this;
    }

    public function setDeviceMarca($pDeviceMarca) {
        $this->pDeviceMarca = $pDeviceMarca;
        return $this;
    }

    public function setDeviceModelo($pDeviceModelo) {
        $this->pDeviceModelo = $pDeviceModelo;
        return $this;
    }

    public function setDeviceSO($pDeviceSO) {
        $this->pDeviceSO = $pDeviceSO;
        return $this;
    }
    
    public function setEmail($pEmail) {
        $this->pEmail = $pEmail;
        return $this;
    }

    public function setClave($pClave) {
        $this->pClave = $pClave;
        return $this;
    }

    public function setTelefono($pTelefono) {
        $this->pTelefono = $pTelefono;
        return $this;
    }
    
}
