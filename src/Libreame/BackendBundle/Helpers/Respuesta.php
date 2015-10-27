<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Entity\LbUsuarios;
use Libreame\BackendBundle\Entity\LbGrupos;
use Libreame\BackendBundle\Entity\LbCalificausuarios;

/**
 * Esta clase contiene la información de RESPUESTA A una solicitud de usuario::: 
 * Puede entenderse como la Clase que envía la informacion al JSON
 *
 * @author mramirez
 */
class Respuesta {
    //Contiene todos los campos posibles en la generación de las respuestas a las solicitudes del cliente
    private $pAccion; //Accion solicitada
    private $pRespuesta; //Respuesta ID
    private $pSession; //Sesion ???? 
    private $pCantMensajes; //Cantidad de Mensajes
    public  $RespUsuarios; //Arreglo de Usuarios 
    private $RespCalifUsu; //Arreglo de calificaciones de usuario
    private $RespGrupos; //Arreglo de calificaciones de usuario
    private $CalifPromedio; //CAlificacion promedio que ha obtenido el usuario
    //Respuestas para PublicarEjemplar
    private $pIdOferta; //Id Oferta
    private $pTitulo; //Titulo del libro ofrecido
    private $pIdlibro; //Id del libro ofrecido
    private $pIdEjemplar; //Id del Ejemplar
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
    private $pIdMensaje; //Id Mensaje recibido (La plataforma publica el ejemplar)
    private $pTxMensaje; //Mensaje recibido (La plataforma publica el ejemplar)
    private $pFeMensaje; //Fecha Mensaje recibido (La plataforma publica el ejemplar)
    private $pIdPadre; //Id Mensaje padre del hilo
    /*
     *  Bloque de getter para los atributos de la clase
     */
    
    public function getAccion() {
        return $this->pAccion;
    }

    public function getRespuesta() {
        return $this->pRespuesta;
    }

    public function getSession() {
        return $this->pSession;
    }

    public function getCantMensajes() {
        return $this->pCantMensajes;
    }
    
    public function getArrUsuarios()
    {
        return $this->RespUsuarios;
    }   

    public function getArrCalificaciones()
    {
        return $this->RespCalifUsu;
    }   

    public function getArrGrupos()
    {
        return $this->RespGrupos;
    }   

    public function getIdOferta()
    {
        return $this->pIdOferta;
    }   

    public function getTitulo()
    {
        return $this->pTitulo;
    }   

    public function getIdlibro()
    {
        return $this->pIdlibro;
    }   

    public function getIdEjemplar()
    {
        return $this->pIdEjemplar;
    }   

    public function getIdioma()
    {
        return $this->pIdioma;
    }   

    public function getAvaluo()
    {
        return $this->pAvaluo;
    }   

    public function getValVenta()
    {
        return $this->pValVenta;
    }   

    public function getTituloSol1()
    {
        return $this->pTituloSol1;
    }   

    public function getIdLibroSol1()
    {
        return $this->pIdlibroSol1;
    }   

    public function getValAdicSol1()
    {
        return $this->pValAdicSol1;
    }   

    public function getTituloSol2()
    {
        return $this->pTituloSol2;
    }   

    public function getIdLibroSol2()
    {
        return $this->pIdlibroSol2;
    }   

    public function getValAdicSol2()
    {
        return $this->pValAdicSol2;
    }   

    public function getObservaSol()
    {
        return $this->pObservaSol;
    }   

    public function getIdMensaje()
    {
        return $this->pIdMensaje;
    }   

    public function getTxMensaje()
    {
        return $this->pTxMensaje;
    }   

    public function getFeMensaje()
    {
        return $this->pFeMensaje;
    }   


    public function getIdPadre()
    {
        return $this->pIdPadre;
    }   

    /*
     *  Bloque de setter para los atributos de la clase
     */
    public function setAccion($pAccion) {
        $this->pAccion = $pAccion;
        return $this;
    }

    public function setRespuesta($pRespuesta) {
        $this->pRespuesta = $pRespuesta;
        return $this;
    }

    public function setSession($pSesion) {
        $this->pSession = $pSesion;
        return $this;
    }

    public function setCantMensajes($pCantMensajes) {
        $this->pCantMensajes = $pCantMensajes;
        return $this;
    }


    public function setArrCalificaciones(LbCalificausuarios $califica)
    {
        $this->RespCalifUsu[] = $califica;
        return $this;
    }   

    public function setArrGrupos(LbGrupos $grupos)
    {
        $this->RespGrupos[] = $grupos;
        return $this;
    }   

    public function setArrUsuarios(LbUsuarios $usuario)
    {
        $this->RespUsuarios[] = $usuario;
        return $this;
    }   
    
    public function setIdOferta($pIdOferta)
    {
        $this->pIdOferta = $pIdOferta;
        return $this;
    }   

    public function setTitulo($pTitulo)
    {
        $this->pTitulo = $pTitulo;
        return $this;
    }   

    public function setIdlibro($pIdlibro)
    {
        $this->pIdlibro = $pIdlibro;
        return $this;
    }   

    public function setIdEjemplar($pIdEjemplar)
    {
        $this->pIdEjemplar = $pIdEjemplar;
        return $this;
    }   

    public function setIdioma($pIdioma)
    {
        $this->pIdioma = $pIdioma;
        return $this;
    }   

    public function setAvaluo($pAvaluo)
    {
        $this->pAvaluo = $pAvaluo;
        return $this;
    }   

    public function setValVenta($pValVenta)
    {
        $this->pValVenta = $pValVenta;
        return $this;
    }   

    public function setTituloSol1($pTituloSol1)
    {
        $this->pTituloSol1 = $pTituloSol1;
        return $this;
    }   

    public function setIdLibroSol1($pIdlibroSol1)
    {
        $this->pIdlibroSol1 = $pIdlibroSol1;
        return $this;
    }   

    public function setValAdicSol1($pValAdicSol1)
    {
        $this->pValAdicSol1 = $pValAdicSol1;
        return $this;
    }   

    public function setTituloSol2($pTituloSol2)
    {
        $this->pTituloSol2 = $pTituloSol2;
        return $this;
    }   

    public function setIdLibroSol2($pIdlibroSol2)
    {
        $this->pIdlibroSol2 = $pIdlibroSol2;
        return $this;
    }   

    public function setValAdicSol2($pValAdicSol2)
    {
        $this->pValAdicSol2 = $pValAdicSol2;
        return $this;
    }   

    public function setObservaSol($pObservaSol)
    {
        $this->pObservaSol = $pObservaSol;
        return $this;
    }   

    public function setIdMensaje($pIdMensaje)
    {
        $this->pIdMensaje = $pIdMensaje;
        return $this;
    }   

    public function setTxMensaje($pTxMensaje)
    {
        $this->pTxMensaje = $pTxMensaje;
        return $this;
    }   

    public function setFeMensaje($pFeMensaje)
    {
        $this->pFeMensaje = $pFeMensaje;
        return $this;
    }   


    public function setIdPadre($pIdPadre)
    {
        $this->pIdPadre = $pIdPadre;
        return $this;
    }   

}

