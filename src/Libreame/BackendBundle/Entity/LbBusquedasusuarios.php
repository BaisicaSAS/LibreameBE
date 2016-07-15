<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbBusquedasusuarios
 *
 * @ORM\Table(name="lb_busquedasusuarios", indexes={@ORM\Index(name="fk_lb_busquedasusuarios_lb_usuarios1_idx", columns={"inBusUsuario"})})
 * @ORM\Entity
 */
class LbBusquedasusuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inBusqueda", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inbusqueda;

    /**
     * @var string
     *
     * @ORM\Column(name="txBusPalabra", type="string", length=100, nullable=false)
     */
    private $txbuspalabra;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feBusFecha", type="datetime", nullable=false)
     */
    private $febusfecha;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inBusUsuario", referencedColumnName="inUsuario")
     * })
     */
    private $inbususuario;



    /**
     * Get inbusqueda
     *
     * @return integer 
     */
    public function getInbusqueda()
    {
        return $this->inbusqueda;
    }

    /**
     * Set txbuspalabra
     *
     * @param string $txbuspalabra
     * @return LbBusquedasusuarios
     */
    public function setTxbuspalabra($txbuspalabra)
    {
        $this->txbuspalabra = $txbuspalabra;

        return $this;
    }

    /**
     * Get txbuspalabra
     *
     * @return string 
     */
    public function getTxbuspalabra()
    {
        return $this->txbuspalabra;
    }

    /**
     * Set febusfecha
     *
     * @param \DateTime $febusfecha
     * @return LbBusquedasusuarios
     */
    public function setFebusfecha($febusfecha)
    {
        $this->febusfecha = $febusfecha;

        return $this;
    }

    /**
     * Get febusfecha
     *
     * @return \DateTime 
     */
    public function getFebusfecha()
    {
        return $this->febusfecha;
    }

    /**
     * Set inbususuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inbususuario
     * @return LbBusquedasusuarios
     */
    public function setInbususuario(\Libreame\BackendBundle\Entity\LbUsuarios $inbususuario = null)
    {
        $this->inbususuario = $inbususuario;

        return $this;
    }

    /**
     * Get inbususuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInbususuario()
    {
        return $this->inbususuario;
    }
}
