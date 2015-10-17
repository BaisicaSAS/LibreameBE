<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbDispusuarios
 *
 * @ORM\Table(name="lb_dispusuarios", indexes={@ORM\Index(name="fk_lb_dispusuarios_lb_usuarios1_idx", columns={"inDisUsuario"})})
 * @ORM\Entity
 */
class LbDispusuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inDispUsuario", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $indispusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="txDisID", type="string", length=45, nullable=false)
     */
    protected $txdisid;

    /**
     * @var string
     *
     * @ORM\Column(name="txDisNombre", type="string", length=45, nullable=true)
     */
    protected $txdisnombre;

    /**
     * @var string
     *
     * @ORM\Column(name="txDisMarca", type="string", length=45, nullable=true)
     */
    protected $txdismarca;

    /**
     * @var string
     *
     * @ORM\Column(name="txDisModelo", type="string", length=45, nullable=true)
     */
    protected $txdismodelo;

    /**
     * @var string
     *
     * @ORM\Column(name="txDisSO", type="string", length=45, nullable=true)
     */
    protected $txdisso;

    /**
     * @var \LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inDisUsuario", referencedColumnName="inUsuario")
     * })
     */
    protected $indisusuario;



    /**
     * Get indispusuario
     *
     * @return integer 
     */
    public function getIndispusuario()
    {
        return $this->indispusuario;
    }

    /**
     * Set txdisid
     *
     * @param string $txdisid
     * @return LbDispusuarios
     */
    public function setTxdisid($txdisid)
    {
        $this->txdisid = $txdisid;

        return $this;
    }

    /**
     * Get txdisid
     *
     * @return string 
     */
    public function getTxdisid()
    {
        return $this->txdisid;
    }

    /**
     * Set txdisnombre
     *
     * @param string $txdisnombre
     * @return LbDispusuarios
     */
    public function setTxdisnombre($txdisnombre)
    {
        $this->txdisnombre = $txdisnombre;

        return $this;
    }

    /**
     * Get txdisnombre
     *
     * @return string 
     */
    public function getTxdisnombre()
    {
        return $this->txdisnombre;
    }

    /**
     * Set txdismarca
     *
     * @param string $txdismarca
     * @return LbDispusuarios
     */
    public function setTxdismarca($txdismarca)
    {
        $this->txdismarca = $txdismarca;

        return $this;
    }

    /**
     * Get txdismarca
     *
     * @return string 
     */
    public function getTxdismarca()
    {
        return $this->txdismarca;
    }

    /**
     * Set txdismodelo
     *
     * @param string $txdismodelo
     * @return LbDispusuarios
     */
    public function setTxdismodelo($txdismodelo)
    {
        $this->txdismodelo = $txdismodelo;

        return $this;
    }

    /**
     * Get txdismodelo
     *
     * @return string 
     */
    public function getTxdismodelo()
    {
        return $this->txdismodelo;
    }

    /**
     * Set txdisso
     *
     * @param string $txdisso
     * @return LbDispusuarios
     */
    public function setTxdisso($txdisso)
    {
        $this->txdisso = $txdisso;

        return $this;
    }

    /**
     * Get txdisso
     *
     * @return string 
     */
    public function getTxdisso()
    {
        return $this->txdisso;
    }

    /**
     * Set indisusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $indisusuario
     * @return LbDispusuarios
     */
    public function setIndisusuario(\Libreame\BackendBundle\Entity\LbUsuarios $indisusuario = null)
    {
        $this->indisusuario = $indisusuario;

        return $this;
    }

    /**
     * Get indisusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIndisusuario()
    {
        return $this->indisusuario;
    }
}
