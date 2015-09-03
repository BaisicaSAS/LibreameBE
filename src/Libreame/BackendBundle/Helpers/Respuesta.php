<?php

namespace Libreame\BackendBundle\Helpers;

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
    private $pUsuario; //Nombre para mostrar del usuario
    
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
    
    public function getUsuario() {
        return $this->pUsuario;
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

    public function setUsuario($pUsuario) {
        $this->pUsuario = $pUsuario;
        return $this;
    }
    
}
