<?php

namespace Libreame\BackendBundle\Helpers;

/**
 * Description of Sesion
 *
 * @author mramirez
 */
class Sesion {
    //put your code here
    //Atributos
    private $pSession;
    private $pIDSession;
    private $pFechaHora;
    private $pDevice;
    private $pIDDevice;
    private $pIPaddr;
    private $pAccion;
    private $pUsuario;
    private $pIDUsuario;
    private $pClave;
    private $pTelefono;
    
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
    
}
