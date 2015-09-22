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
    private $pTipopublica; //Tipo de publicacion 0 / 1 / 2
    private $pTitulo; //Titulo del libro ofrecido
    private $pIdlibro; //Id del libro ofrecido
    private $pIdioma; //Idioma
    private $pAvaluo; //Avalúa
    private $pValVenta; //Valor venta
    private $pTituloSol1; //Primer Titulo Solicitado
    private $pIdlibroSol1; //Primer id del libro Solicitado
    private $pValAdicSol1; //Valor adicional para el primer libro
    private $pTituloSol2; //Segundo Titulo Solicitado
    private $pIdlibroSol2; //Segundo id del libro Solicitado
    private $pValAdicSol2; //Valor adicional para el segundo libro
    private $pObservaSol; //Observaciones de la oferta
    

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
    
    public function getTipopublica() {
        return $this->pTipopublica;
    }
    
    public function getTitulo() {
        return $this->pTitulo;
    }
    
    public function getIdLibro() {
        return $this->pIdlibro;
    }
        
    public function getIdioma() {
        return $this->pIdioma;
    }
    
    public function getAvaluo() {
        return $this->pAvaluo;
    }
    
    public function getValventa() {
        return $this->pValVenta;
    }

    public function getTituloSol1() {
        return $this->pTituloSol1;
    }
    
    public function getIdLibroSol1() {
        return $this->pIdlibroSol1;
    }
   
    public function getValAdicSol1() {
        return $this->pValAdicSol1;
    }

    public function getTituloSol2() {
        return $this->pTituloSol2;
    }
    
    public function getIdLibroSol2() {
        return $this->pIdlibroSol2;
    }
   
    public function getValAdicSol2() {
        return $this->pValAdicSol2;
    }

    public function getObservaSol() {
        return $this->pObservaSol;
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

    public function setTipopublica($pTipopublica) {
        $this->pTipopublica = $pTipopublica;
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
        
    public function setIdioma($pIdioma) {
        $this->pIdioma = $pIdioma;
        return $this;
    }
    
    public function setAvaluo($pAvaluo) {
        $this->pAvaluo = $pAvaluo;
        return $this;
    }
    
    public function setValventa($pValVenta) {
        $this->pValVenta = $pValVenta;
        return $this;
    }

    public function setTituloSol1($pTituloSol1) {
        $this->pTituloSol1 = $pTituloSol1;
        return $this;
    }
    
    public function setIdLibroSol1($pIdLibroSol1) {
        $this->pIdlibroSol1 = $pIdLibroSol1;
        return $this;
    }
   
    public function setValAdicSol1($pValAdicSol1) {
        $this->pValAdicSol1 = $pValAdicSol1;
        return $this;
    }

    public function setTituloSol2($pTituloSol2) {
        $this->pTituloSol2 = $pTituloSol2;
        return $this;
    }
    
    public function setIdLibroSol2($pIdLibroSol2) {
        $this->pIdlibroSol2 = $pIdLibroSol2;
        return $this;
    }
   
    public function setValAdicSol2($pValAdicSol2) {
        $this->pValAdicSol2 = $pValAdicSol2;
        return $this;
    }

    public function setObservaSol($pObservaSol) {
        $this->pObservaSol = $pObservaSol;
        return $this;
    }
    
}
