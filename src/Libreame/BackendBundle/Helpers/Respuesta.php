<?php

namespace Libreame\BackendBundle\Helpers;

use Libreame\BackendBundle\Entity\LbUsuarios;

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
    public $RespUsuarios; //Arreglo de Usuarios 
    private $puntUsuario; //Puntero para los usuarios
	    
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

    public function setArrUsuarios(LbUsuarios $usuario)
    {
        $this->RespUsuarios[] = $usuario;
    }   

    //Bloque otras funciones para arreglos
    public function actualUsuarios ()
    {
        if (! $this->validoUsuario()) { return false; }
        if (empty($this->RespUsuarios[$this->puntUsuario])) { return array(); }
        return $this->RespUsuarios[$this->puntUsuario];
    }
    
    public function keyUsuarios()
    {
        return $this->puntUsuario;
    }
    
    public function siguienteUsuario()
    {
        return ++ $this->puntUsuario;
    }
    
    public function redimensionarUsuarios()
    {
        $this->puntUsuario = 0;
    }
    
    public function validoUsuario()
    {
	return $this->puntUsuario !== false;
    }
    
    
    public function cantidadUsuarios()
    {
        return count($this->RespUsuarios);
    }
        
}

