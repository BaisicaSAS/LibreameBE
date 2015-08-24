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
    private $pSession; //Sesion ???? Diferencia con el anterior?
    private $pIDSession;  //Id de la sesion ???? Diferencia con el anterior?
    private $pFechaHora; //Fecha y hora de la solicitud
    private $pDevice; //Nombre Dispositivo
    private $pIDDevice; // Id del dispositivo
    private $pIPaddr; //Direccion IP
    private $pAccion; //Accion solicitada
    private $pUsuario; //Nombre de usuario que realiza solicitud
    private $pIDUsuario; //Id el usuario que realiza solicitud
    private $pClave; //Clave del usuario
    private $pTelefono; //Numero telefónico 

    //Atributos para el detalle: identificado en el tag IDSOLICITUD del JSON
    private $pEmail;
    
    //private $
    

    /*
     *  Bloque de getter para los atributos de la clase
     */
    
   
    public function getSession() {
        return $this->pSession;
    }

    public function getIDSession() {
        return $this->pIDSession;
    }

    public function getFechaHora() {
        return $this->pFechaHora;
    }

    public function getDevice() {
        return $this->pDevice;
    }

    public function getIDDevice() {
        return $this->pIDDevice;
    }

    public function getIPaddr() {
        return $this->pIPaddr;
    }

    public function getAccion() {
        return $this->pAccion;
    }

    public function getUsuario() {
        return $this->pUsuario;
    }

    public function getIDUsuario() {
        return $this->pIDUsuario;
    }

    public function getClave() {
        return $this->pClave;
    }

    public function getTelefono() {
        return $this->pTelefono;
    }
    
    public function getEmail() {
        return $this->pEmail;
    }
    
    /*
     *  Bloque de setter para los atributos de la clase
     */
    public function setSession($pSesion) {
        $this->pSession = $pSesion;
        return $this;
    }

    public function setIDSession($pIDSession) {
        $this->pIDSession = $pIDSession;
        return $this;
    }

    public function setFechaHora($pFechaHora) {
        $this->pFechaHora = $pFechaHora;
        return $this;
    }

    public function setDevice($pDevice) {
        $this->pDevice = $pDevice;
        return $this;
    }

    public function setIDDevice($pIDDevice) {
        $this->pIDDevice = $pIDDevice;
        return $this;
    }

    public function setIPaddr($pIPaddr) {
        $this->pIPaddr = $pIPaddr;
        return $this;
    }

    public function setAccion($pAccion) {
        $this->pAccion = $pAccion;
        return $this;
    }

    public function setUsuario($pUsuario) {
        $this->pUsuario = $pUsuario;
        return $this;
    }

    public function setIDUsuario($pIDUsuario) {
        $this->pIDUsuario = $pIDUsuario;
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
    
    public function setEmail($pEmail) {
        $this->pEmail = $pEmail;
        return $this;
    }
    
}
