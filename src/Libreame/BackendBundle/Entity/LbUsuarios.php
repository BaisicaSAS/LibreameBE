<?php

namespace Libreame\BackendBundle\Entity;
namespace Libreame\BackendBundle\Helpers\Logica;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbUsuarios
 */
class LbUsuarios
{
    /**
     * @var integer
     */
    private $inusuario;

    /**
     * @var string
     */
    private $txusuemail;

    /**
     * @var string
     * Modificado para adicionar default '0'
     */
    private $txusutelefono = '0';

    /**
     * @var string
     */
    private $txusunombre;

    /**
     * @var integer
     * Modificado para adicionar default 2: Sin especificar
     */
    private $inusugenero = 2;

    /**
     * @var string
     */
    private $txusuimagen;

    /**
     * @var string
     */
    private $txusunommostrar;

    /**
     * @var \DateTime
     */
    private $feusunacimiento;

    /**
     * @var string
     */
    private $txusuvalidacion;

    /**
     * @var integer
     * Moficado para adicionar default 0:  Esperando confirmación
     */
    private $inusuestado = 0;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLugares
     */
    private $inusulugar;

    /**
     * @var string
     */
    private $txusuclave;



    /**
     * Get inusuario
     *
     * @return integer 
     */
    public function getInusuario()
    {
        return $this->inusuario;
    }

    /**
     * Set txusuemail
     *
     * @param string $txusuemail
     * @return LbUsuarios
     */
    public function setTxusuemail($txusuemail)
    {
        $this->txusuemail = $txusuemail;

        return $this;
    }

    /**
     * Get txusuemail
     *
     * @return string 
     */
    public function getTxusuemail()
    {
        return $this->txusuemail;
    }

    /**
     * Set txusutelefono
     *
     * @param string $txusutelefono
     * @return LbUsuarios
     */
    public function setTxusutelefono($txusutelefono)
    {
        $this->txusutelefono = $txusutelefono;

        return $this;
    }

    /**
     * Get txusutelefono
     *
     * @return string 
     */
    public function getTxusutelefono()
    {
        return $this->txusutelefono;
    }

    /**
     * Set txusunombre
     *
     * @param string $txusunombre
     * @return LbUsuarios
     */
    public function setTxusunombre($txusunombre)
    {
        $this->txusunombre = $txusunombre;

        return $this;
    }

    /**
     * Get txusunombre
     *
     * @return string 
     */
    public function getTxusunombre()
    {
        return $this->txusunombre;
    }

    /**
     * Set inusugenero
     *
     * @param integer $inusugenero
     * @return LbUsuarios
     */
    public function setInusugenero($inusugenero)
    {
        $this->inusugenero = $inusugenero;

        return $this;
    }

    /**
     * Get inusugenero
     *
     * @return integer 
     */
    public function getInusugenero()
    {
        return $this->inusugenero;
    }

    /**
     * Set txusuimagen
     *
     * @param string $txusuimagen
     * @return LbUsuarios
     */
    public function setTxusuimagen($txusuimagen)
    {
        $this->txusuimagen = $txusuimagen;

        return $this;
    }

    /**
     * Get txusuimagen
     *
     * @return string 
     */
    public function getTxusuimagen()
    {
        return $this->txusuimagen;
    }

    /**
     * Set txusunommostrar
     *
     * @param string $txusunommostrar
     * @return LbUsuarios
     */
    public function setTxusunommostrar($txusunommostrar)
    {
        $this->txusunommostrar = $txusunommostrar;

        return $this;
    }

    /**
     * Get txusunommostrar
     *
     * @return string 
     */
    public function getTxusunommostrar()
    {
        return $this->txusunommostrar;
    }

    /**
     * Set feusunacimiento
     *
     * @param \DateTime $feusunacimiento
     * @return LbUsuarios
     */
    public function setFeusunacimiento($feusunacimiento)
    {
        $this->feusunacimiento = $feusunacimiento;

        return $this;
    }

    /**
     * Get feusunacimiento
     *
     * @return \DateTime 
     */
    public function getFeusunacimiento()
    {
        return $this->feusunacimiento;
    }

    /**
     * Set txusuvalidacion
     *
     * @param string $txusuvalidacion
     * @return LbUsuarios
     */
    public function setTxusuvalidacion($txusuvalidacion)
    {
        $this->txusuvalidacion = $txusuvalidacion;

        return $this;
    }

    /**
     * Get txusuvalidacion
     *
     * @return string 
     */
    public function getTxusuvalidacion()
    {
        return $this->txusuvalidacion;
    }

    /**
     * Set inusuestado
     *
     * @param integer $inusuestado
     * @return LbUsuarios
     */
    public function setInusuestado($inusuestado)
    {
        $this->inusuestado = $inusuestado;

        return $this;
    }

    /**
     * Get inusuestado
     *
     * @return integer 
     */
    public function getInusuestado()
    {
        return $this->inusuestado;
    }

    /**
     * Set inusulugar
     *
     * @param \Libreame\BackendBundle\Entity\LbLugares $inusulugar
     * @return LbUsuarios
     */
    public function setInusulugar(\Libreame\BackendBundle\Entity\LbLugares $inusulugar = null)
    {
        $this->inusulugar = $inusulugar;

        return $this;
    }

    /**
     * Get inusulugar
     *
     * @return \Libreame\BackendBundle\Entity\LbLugares 
     */
    public function getInusulugar()
    {
        return $this->inusulugar;
    }

    /**
     * Set txusuclave
     *
     * @param string $txusuclave
     * @return string
     */
    public function setTxusuclave($txusuclave)
    {
        $this->txusuclave = $txusuclave;

        return $this;
    }

    /**
     * Get txusuclave
     *
     * @return string 
     */
    public function getTxusuclave()
    {
        return $this->txusuclave;
    }
    
    public function creaUsuario($pSolicitud, $Lugar)
    {
        $usuario = new LbUsuarios();
        $usuario->setTxusuemail($pSolicitud->getEmail());  
        $usuario->setTxusutelefono($pSolicitud->getTelefono());  
        $usuario->setTxusunombre($pSolicitud->getUsuario());  
        $usuario->setTxusuclave($pSolicitud->getClave());  
        $usuario->setTxusuimagen('DEFAUL IMAGE URL');  
        $usuario->setInusulugar($Lugar);  
        $usuario->setTxusuvalidacion(Logica::generaRand(AccesoController::inTamVali));  
        
        return $usuario;
    }
    
    public function cantMsgUsr($usuario)
    {
        //$em = $this->getDoctrine()->getManager();
        //$usuario = $em->getRepository('LibreameBackendBundle:LbUsuarios')->
        //                findOneBy(array('txusuemail' => $pSolicitud->getEmail()));

        
        return 10;
    }
    
    
}
