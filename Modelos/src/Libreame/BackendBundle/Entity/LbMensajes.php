<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbMensajes
 *
 * @ORM\Table(name="lb_mensajes", indexes={@ORM\Index(name="fk_lb_mensajes_lb_usuarios1_idx", columns={"inMenUsuario"}), @ORM\Index(name="fk_lb_mensajes_lb_usuarios2_idx", columns={"inMenUsuarioOrigen"}), @ORM\Index(name="fk_lb_mensajes_lb_mensajes1_idx", columns={"inMensajePadre"})})
 * @ORM\Entity
 */
class LbMensajes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inMensaje", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inmensaje;

    /**
     * @var string
     *
     * @ORM\Column(name="txMensaje", type="text", nullable=false)
     */
    protected $txmensaje;

    /**
     * @var integer
     *
     * @ORM\Column(name="inMenOrigen", type="integer", nullable=false)
     */
    protected $inmenorigen;

    /**
     * @var integer
     *
     * @ORM\Column(name="inMenLeido", type="integer", nullable=false)
     */
    protected $inmenleido = '0';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inMenFecha", type="datetime", nullable=false)
     */
    protected $inmenfecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="inMemIdRelacionado", type="integer", nullable=false)
     */
    protected $inmemidrelacionado;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="inMenFechaLeido", type="datetime", nullable=true)
     */
    protected $inmenfechaleido;

    /**
     * @var \LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inMenUsuario", referencedColumnName="inUsuario")
     * })
     */
    protected $inmenusuario;

    /**
     * @var \LbMensajes
     *
     * @ORM\ManyToOne(targetEntity="LbMensajes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inMensajePadre", referencedColumnName="inMensaje")
     * })
     */
    protected $inmensajepadre;

    /**
     * @var \LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inMenUsuarioOrigen", referencedColumnName="inUsuario")
     * })
     */
    protected $inmenusuarioorigen;



    /**
     * Get inmensaje
     *
     * @return integer 
     */
    public function getInmensaje()
    {
        return $this->inmensaje;
    }

    /**
     * Set txmensaje
     *
     * @param string $txmensaje
     * @return LbMensajes
     */
    public function setTxmensaje($txmensaje)
    {
        $this->txmensaje = $txmensaje;

        return $this;
    }

    /**
     * Get txmensaje
     *
     * @return string 
     */
    public function getTxmensaje()
    {
        return $this->txmensaje;
    }

    /**
     * Set inmenorigen
     *
     * @param integer $inmenorigen
     * @return LbMensajes
     */
    public function setInmenorigen($inmenorigen)
    {
        $this->inmenorigen = $inmenorigen;

        return $this;
    }

    /**
     * Get inmenorigen
     *
     * @return integer 
     */
    public function getInmenorigen()
    {
        return $this->inmenorigen;
    }

    /**
     * Set inmenleido
     *
     * @param integer $inmenleido
     * @return LbMensajes
     */
    public function setInmenleido($inmenleido)
    {
        $this->inmenleido = $inmenleido;

        return $this;
    }

    /**
     * Get inmenleido
     *
     * @return integer 
     */
    public function getInmenleido()
    {
        return $this->inmenleido;
    }

    /**
     * Set inmenfecha
     *
     * @param \DateTime $inmenfecha
     * @return LbMensajes
     */
    public function setInmenfecha($inmenfecha)
    {
        $this->inmenfecha = $inmenfecha;

        return $this;
    }

    /**
     * Get inmenfecha
     *
     * @return \DateTime 
     */
    public function getInmenfecha()
    {
        return $this->inmenfecha;
    }

    /**
     * Set inmemidrelacionado
     *
     * @param integer $inmemidrelacionado
     * @return LbMensajes
     */
    public function setInmemidrelacionado($inmemidrelacionado)
    {
        $this->inmemidrelacionado = $inmemidrelacionado;

        return $this;
    }

    /**
     * Get inmemidrelacionado
     *
     * @return integer 
     */
    public function getInmemidrelacionado()
    {
        return $this->inmemidrelacionado;
    }

    /**
     * Set inmenfechaleido
     *
     * @param \DateTime $inmenfechaleido
     * @return LbMensajes
     */
    public function setInmenfechaleido($inmenfechaleido)
    {
        $this->inmenfechaleido = $inmenfechaleido;

        return $this;
    }

    /**
     * Get inmenfechaleido
     *
     * @return \DateTime 
     */
    public function getInmenfechaleido()
    {
        return $this->inmenfechaleido;
    }

    /**
     * Set inmenusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inmenusuario
     * @return LbMensajes
     */
    public function setInmenusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inmenusuario = null)
    {
        $this->inmenusuario = $inmenusuario;

        return $this;
    }

    /**
     * Get inmenusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInmenusuario()
    {
        return $this->inmenusuario;
    }
    
    /**
     * Set inmenusuarioorigen
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inmenusuarioorigen
     * @return LbMensajes
     */
    public function setInmenusuarioorigen(\Libreame\BackendBundle\Entity\LbUsuarios $inmenusuarioorigen = null)
    {
        $this->inmenusuarioorigen = $inmenusuarioorigen;

        return $this;
    }

    /**
     * Get inmensajepadre
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInmenusuarioorigen()
    {
        return $this->inmenusuarioorigen;
    }
    
    /**
     * Set inmensajepadre
     *
     * @param \Libreame\BackendBundle\Entity\LbMensajes $inmensajepadre
     * @return LbMensajes
     */
    public function setInmensajepadre(\Libreame\BackendBundle\Entity\LbMensajes $inmensajepadre = null)
    {
        $this->inmensajepadre = $inmensajepadre;

        return $this;
    }

    /**
     * Get inmensajepadre
     *
     * @return \Libreame\BackendBundle\Entity\LbMensajes 
     */
    public function getInmensajepadre()
    {
        return $this->inmensajepadre;
    }
    
}
