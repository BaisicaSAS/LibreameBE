<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbEjemplares
 *
 * @ORM\Table(name="lb_ejemplares", indexes={@ORM\Index(name="fk_lb_ejemplares_lb_usuarios1_idx", columns={"inEjeUsuDueno"}), @ORM\Index(name="fk_lb_ejemplares_lb_libros1_idx", columns={"inEjeLibro"})})
 * @ORM\Entity
 */
class LbEjemplares
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjemplar", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $inejemplar;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeCantidad", type="integer", nullable=false)
     */
    protected $inejecantidad = '1';

    /**
     * @var float
     *
     * @ORM\Column(name="dbEjeAvaluo", type="float", precision=10, scale=0, nullable=false)
     */
    protected $dbejeavaluo = '0';

    /**
     * @var \LbLibros
     *
     * @ORM\ManyToOne(targetEntity="LbLibros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inEjeLibro", referencedColumnName="inLibro")
     * })
     */
    protected $inejelibro;

    /**
     * @var \LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inEjeUsuDueno", referencedColumnName="inUsuario")
     * })
     */
    protected $inejeusudueno;

    /**
     * @var blob
     *
     * @ORM\Column(name="txEjeImagen", type="blob", nullable=true)
     */
    protected $txejeimagen;




    /**
     * Get inejemplar
     *
     * @return integer 
     */
    public function getInejemplar()
    {
        return $this->inejemplar;
    }

    /**
     * Set inejecantidad
     *
     * @param integer $inejecantidad
     * @return LbEjemplares
     */
    public function setInejecantidad($inejecantidad)
    {
        $this->inejecantidad = $inejecantidad;

        return $this;
    }

    /**
     * Get inejecantidad
     *
     * @return integer 
     */
    public function getInejecantidad()
    {
        return $this->inejecantidad;
    }

    /**
     * Set dbejeavaluo
     *
     * @param float $dbejeavaluo
     * @return LbEjemplares
     */
    public function setDbejeavaluo($dbejeavaluo)
    {
        $this->dbejeavaluo = $dbejeavaluo;

        return $this;
    }

    /**
     * Get dbejeavaluo
     *
     * @return float 
     */
    public function getDbejeavaluo()
    {
        return $this->dbejeavaluo;
    }

    /**
     * Set inejelibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $inejelibro
     * @return LbEjemplares
     */
    public function setInejelibro(\Libreame\BackendBundle\Entity\LbLibros $inejelibro = null)
    {
        $this->inejelibro = $inejelibro;

        return $this;
    }

    /**
     * Get inejelibro
     *
     * @return \Libreame\BackendBundle\Entity\LbLibros 
     */
    public function getInejelibro()
    {
        return $this->inejelibro;
    }

    /**
     * Set inejeusudueno
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inejeusudueno
     * @return LbEjemplares
     */
    public function setInejeusudueno(\Libreame\BackendBundle\Entity\LbUsuarios $inejeusudueno = null)
    {
        $this->inejeusudueno = $inejeusudueno;

        return $this;
    }

    /**
     * Get inejeusudueno
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInejeusudueno()
    {
        return $this->inejeusudueno;
    }
    
    /**
     * Set txejeimagen
     *
     * @param string $txejeimagen
     * @return LbEjemplares
     */
    public function setTxejeimagen($txejeimagen)
    {
        $this->txejeimagen = $txejeimagen;

        return $this;
    }

    /**
     * Get txejeimagen
     *
     * @return string 
     */
    public function getTxejeimagen()
    {
        return $this->txejeimagen;
    }    
}