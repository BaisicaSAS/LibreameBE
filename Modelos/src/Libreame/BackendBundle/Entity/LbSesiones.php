<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbSesiones
 *
 * @ORM\Table(name="lb_sesiones", indexes={@ORM\Index(name="fk_lb_sesiones_lb_dispusuarios1_idx", columns={"inSesDispUsuario"})})
 * @ORM\Entity
 */
class LbSesiones
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inSesion", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $insesion;

    /**
     * @var string
     *
     * @ORM\Column(name="txSesNumero", type="string", length=45, nullable=false)
     */
    protected $txsesnumero;

    /**
     * @var integer
     *
     * @ORM\Column(name="inSesActiva", type="integer", nullable=false)
     */
    protected $insesactiva = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feSesFechaIni", type="datetime", nullable=false)
     */
    protected $fesesfechaini;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feSesFechaFin", type="datetime", nullable=true)
     */
    protected $fesesfechafin;

    /**
     * @var string
     *
     * @ORM\Column(name="txIPAddr", type="string", length=30, nullable=false)
     */
    protected $txipaddr = '000.000.000.000';

    /**
     * @var \LbDispusuarios
     *
     * @ORM\ManyToOne(targetEntity="LbDispusuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inSesDispUsuario", referencedColumnName="inDispUsuario")
     * })
     */
    protected $insesdispusuario;



    /**
     * Get insesion
     *
     * @return integer 
     */
    public function getInsesion()
    {
        return $this->insesion;
    }

    /**
     * Set txsesnumero
     *
     * @param string $txsesnumero
     * @return LbSesiones
     */
    public function setTxsesnumero($txsesnumero)
    {
        $this->txsesnumero = $txsesnumero;

        return $this;
    }

    /**
     * Get txsesnumero
     *
     * @return string 
     */
    public function getTxsesnumero()
    {
        return $this->txsesnumero;
    }

    /**
     * Set insesactiva
     *
     * @param integer $insesactiva
     * @return LbSesiones
     */
    public function setInsesactiva($insesactiva)
    {
        $this->insesactiva = $insesactiva;

        return $this;
    }

    /**
     * Get insesactiva
     *
     * @return integer 
     */
    public function getInsesactiva()
    {
        return $this->insesactiva;
    }

    /**
     * Set fesesfechaini
     *
     * @param \DateTime $fesesfechaini
     * @return LbSesiones
     */
    public function setFesesfechaini($fesesfechaini)
    {
        $this->fesesfechaini = $fesesfechaini;

        return $this;
    }

    /**
     * Get fesesfechaini
     *
     * @return \DateTime 
     */
    public function getFesesfechaini()
    {
        return $this->fesesfechaini;
    }

    /**
     * Set fesesfechafin
     *
     * @param \DateTime $fesesfechafin
     * @return LbSesiones
     */
    public function setFesesfechafin($fesesfechafin)
    {
        $this->fesesfechafin = $fesesfechafin;

        return $this;
    }

    /**
     * Get fesesfechafin
     *
     * @return \DateTime 
     */
    public function getFesesfechafin()
    {
        return $this->fesesfechafin;
    }

    /**
     * Set txipaddr
     *
     * @param string $txipaddr
     * @return LbSesiones
     */
    public function setTxipaddr($txipaddr)
    {
        $this->txipaddr = $txipaddr;

        return $this;
    }

    /**
     * Get txipaddr
     *
     * @return string 
     */
    public function getTxipaddr()
    {
        return $this->txipaddr;
    }

    /**
     * Set insesdispusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbDispusuarios $insesdispusuario
     * @return LbSesiones
     */
    public function setInsesdispusuario(\Libreame\BackendBundle\Entity\LbDispusuarios $insesdispusuario = null)
    {
        $this->insesdispusuario = $insesdispusuario;

        return $this;
    }

    /**
     * Get insesdispusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbDispusuarios 
     */
    public function getInsesdispusuario()
    {
        return $this->insesdispusuario;
    }
}
