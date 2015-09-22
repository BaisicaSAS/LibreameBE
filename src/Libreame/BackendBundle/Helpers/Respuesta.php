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
    private $idejemplar; //Id ejemplar
    private $titulo; //Titulo del ejemplar
    private $estado; //Estado del ejemplar
    private $idoferta; 
    private $idmensaje;
    private $fecha;
    private $padre;
    private $descripcion;
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

    public function getIdEjemplar()
    {
        return $this->idejemplar;
    }   

    public function getTitulo()
    {
        return $this->titulo;
    }   

    public function getEstado()
    {
        return $this->estado;
    }   

    public function getIdOferta()
    {
        return $this->idoferta;
    }   

    public function getIdMensaje()
    {
        return $this->idmensaje;
    }   

    public function getFecha()
    {
        return $this->fecha;
    }   

    public function getPadre()
    {
        return $this->padre;
    }   

    public function getDescripcion()
    {
        return $this->descripcion;
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


    public function setArrCalificaciones($califica)
    {
        $this->RespCalifUsu[] = $califica;
        return $this;
    }   

    public function setArrGrupos($grupos)
    {
        $this->RespGrupos[] = $grupos;
        return $this;
    }   

    public function setArrUsuarios(LbUsuarios $usuario)
    {
        $this->RespUsuarios[] = $usuario;
        return $this;
    }   

    public function setIdEjemplar($idejemplar)
    {
        $this->idejemplar = $idejemplar;
        return $this;
    }   

    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        return $this;
    }   
    
    public function setEstado($estado)
    {
        $this->estado = $estado;
        return $this;
    }   

    public function setIdOferta($idoferta)
    {
        $this->idoferta = $idoferta;
        return $this;
    }   
    
    public function setIdMensaje($idmensaje)
    {
        $this->idmensaje = $idmensaje;
        return $this;
    }   
    
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
        return $this;
    }   
    
    public function setPadre($padre)
    {
        $this->padre = $padre;
        return $this;
    }   
    
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
        return $this;
    }   
    
}

