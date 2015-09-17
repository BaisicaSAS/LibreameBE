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
    //$pUltEjemplar
    private $pUltEjemplar;
    //Parametros para la creación de un Ejemplar, cargue o búsqueda del libro y de los generos
    private $pTitulo;
    private $pIdlibro;
    private $pTipopublica; //{0:Libro || 1:Revista || 2:Periodico}
    private $pIdioma;
    private $pAvaluo;
    private $pPublicar;

    /*
     *  Bloque de getter para los atributos de la clase
     */
    
    public function getAccion() {
        return $this->pAccion;
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

    public function getUltEjemplar() {
        return $this->pUltEjemplar;
    }
    
    public function getTitulo() {
        return $this->pTitulo;
    }
    
    public function getIdLibro() {
        return $this->pIdlibro;
    }
    
    public function getTipopublica() {
        return $this->pTipopublica;
    }
    
    public function getIdioma() {
        return $this->pIdioma;
    }
    
    public function getAvaluo() {
        return $this->pAvaluo;
    }
    
    public function getPublicar() {
        return $this->pPublicar;
    }
    
    /*
     *  Bloque de setter para los atributos de la clase
     */
    public function setAccion($pAccion) {
        $this->pAccion = $pAccion;
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
    
    public function setUltEjemplar($pUltEjemplar) {
        if ($pUltEjemplar==""){
            $this->pUltEjemplar = 0;
        } else {
            $this->pUltEjemplar = $pUltEjemplar;
        }
        return $this;
    }

    public function setTitulo($pTitulo) {
        $this->pTitulo = $pTitulo;
        return $this;
    }
    
    public function setIdLibro($pIdlibro) {
        $this->pIdlibro = $pIdlibro;
        return $this;
    }
    
    public function setTipopublica($pTipopublica) {
        $this->pTipopublica = $pTipopublica;
        return $this;
    }
    
    public function setIdioma($pIdioma) {
        $this->pIdioma = $pIdioma;
        return $this;
    }
    
    public function setAvaluo($pAvaluo) {
        $this->pAvaluo = $pAvaluo;
        return $this;
    }
    
    public function setPublicar($pPublicar) {
        $this->pPublicar = $pPublicar;
        return $this;
    }
    
}
