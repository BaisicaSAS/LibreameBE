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
    private $pClaveNueva; //Clave Nueva del usuario
    private $pNomUsuario; //Nombre de usuario
    private $pNomMostUsuario; //Nombre para mostrar de usuario
    private $pUsuGenero; //Genero del usuario
    private $pUsuImagen; //Imagen
    private $pUsuFecNac; //Fecha de nacimiento
    private $pUsuLugar; //Lugar del usuario
    //$pUltEjemplar
    private $pUltEjemplar;
    //Parametros para la creación de un Ejemplar, cargue o búsqueda del libro y de los generos
    private $pTipopublica; //Tipo de publicacion 0 / 1 / 2
    private $pIdOferta;
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
    private $pImagenEje; //Imagen del ejemplar
    //Parametros para la búsqueda
    private $pTextoBuscar; //Texto a buscar
    //Parametros para marcar mensaje como leído
    private $pIdMensaje; //Id del mensaje
    private $pMarcaComo; //Marcar usuario como : Leido = 1, No leido = 0
    //Parametros para recuperar usuario otro
    private $pIdUsuarioVer; //Id del mensaje
    //Id de un ejemplar
    private $pIdEjemplar;
    //Marca de megusta o no me gusta para un ejemplar
    private $pMegusta;
    
    
    
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

    public function getClaveNueva() {
        return $this->pClaveNueva;
    }

    public function getNomUsuario() {
        return $this->pNomUsuario;
    }

    public function getNomMostUsuario() {
        return $this->pNomMostUsuario;
    }

    public function getUsuGenero() {
        return $this->pUsuGenero;
    }

    public function getUsuImagen() {
        return $this->pUsuImagen;
    }

    public function getUsuFecNac() {
        return $this->pUsuFecNac;
    }

    public function getUsuLugar() {
        return $this->pUsuLugar;
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
    
    public function getIdOferta() {
        return $this->pIdOferta;
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
    
    public function getTextoBuscar() {
        return $this->pTextoBuscar;
    }
    
    public function getIdmensaje() {
        return $this->pIdMensaje;
    }
    
    public function getMarcacomo() {
        return $this->pMarcaComo;
    }

    public function getIdusuariover() {
        return $this->pIdUsuarioVer;
    }
    
    public function getImageneje() {
        return $this->pImagenEje;
    }

    public function getIdEjemplar() {
        return $this->pIdEjemplar;
    }

    public function getMegusta() {
        return $this->pMegusta;
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

    public function setClaveNueva($pClaveNueva) {
        $this->pClaveNueva = $pClaveNueva;
        return $this;
    }

    
    public function setNomUsuario($pNomUsuario) {
        $this->pNomUsuario = $pNomUsuario;
        return $this;
    }

    public function setNomMostUsuario($pNomMostUsuario) {
        $this->pNomMostUsuario= $pNomMostUsuario;
        return $this;
    }

    public function setUsuGenero($pUsugenero) {
        $this->pUsuGenero = $pUsugenero;
        return $this;
    }

    public function setUsuImagen($pUsuImagen) {
        $this->pUsuImagen = $pUsuImagen;
        return $this;
    }

    public function setUsuFecNac($pUsuFecNac) {
        $this->pUsuFecNac = $pUsuFecNac;
        return $this;
    }

    public function setUsuLugar($pUsuLugar) {
        $this->pUsuLugar = $pUsuLugar;
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
    
    public function setIdOferta($pIdOferta) {
        $this->pIdOferta = $pIdOferta;
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
    
    public function setTextoBuscar($pTextoBus) {
        $this->pTextoBuscar = $pTextoBus;
        return $this;
    }
    
    public function setIdmensaje($pIdMens) {
        $this->pIdMensaje = $pIdMens;
        return $this;
    }
    
    public function setMarcarcomo($pMarcar) {
        $this->pMarcaComo = $pMarcar;
        return $this;
    }
    
    public function setIdusuariover($pIdUsrVer) {
        $this->pIdUsuarioVer = $pIdUsrVer;
        return $this;
    }
    
    public function setImageneje($pimageneje) {
        $this->pImagenEje = $pimageneje;
        return $this;
    }
    
    public function setIdEjemplar($pidejemplar) {
        $this->pIdEjemplar = $pidejemplar;
        return $this;
    }
    
    public function setMegusta($pmegusta) {
        $this->pMegusta = $pmegusta;
        return $this;
    }
    
}
