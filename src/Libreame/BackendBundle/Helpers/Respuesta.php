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
        //return $this;
    }   

    public function setArrGrupos(LbGrupos $grupos)
    {
        $this->RespGrupos[] = $grupos;
        //return $this;
    }   

    public function setArrUsuarios(LbUsuarios $usuario)
    {
        $this->RespUsuarios[] = $usuario;
        //return $this;
    }   

}

