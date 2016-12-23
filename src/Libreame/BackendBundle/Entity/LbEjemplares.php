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
     * @ORM\Column(name="inEjemplar", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inejemplar;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeCantidad", type="integer", nullable=false)
     */
    private $inejecantidad = 1;

    /**
     * @var float
     *
     * @ORM\Column(name="dbEjeAvaluo", type="float", precision=10, scale=0, nullable=false)
     */
    private $dbejeavaluo = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="txEjeImagen", type="text", nullable=false)
     */
    private $txejeimagen;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjePuntos", type="integer", nullable=false)
     */
    private $inejepuntos = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjePublicado", type="integer", nullable=false)
     */
    private $inejepublicado = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeBloqueado", type="integer", nullable=false)
     */
    private $inejebloqueado = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeEstado", type="integer", nullable=false)
     */
    private $inejeestado = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeCondicion", type="integer", nullable=false)
     */
    private $inejecondicion = 1;

    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeSoloventa", type="integer", nullable=false)
     */
    private $inejesoloventa = 0;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLibros
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbLibros")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inEjeLibro", referencedColumnName="inLibro")
     * })
     */
    private $inejelibro;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inEjeUsuDueno", referencedColumnName="inUsuario")
     * })
     */
    private $inejeusudueno;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeEstadoNegocio", type="integer", nullable=false)
     */
    private $inejeestadonegocio = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeRegHisBloqueo", type="integer", nullable=false)
     */
    private $inejereghisbloqueo = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeRegHisPublicacion", type="integer", nullable=false)
     */
    private $inejereghispublicacion = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeRegHisBajaSis", type="integer", nullable=false)
     */
    private $inejereghisbajasis = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeRegHisAprobDueno", type="integer", nullable=false)
     */
    private $inejereghisaprobdueno = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeRegHisAprobSolic", type="integer", nullable=false)
     */
    private $inejereghisaprobsolic = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeRegHisEntrega", type="integer", nullable=false)
     */
    private $inejereghisentrega = 0;
    /**
     * @var integer
     *
     * @ORM\Column(name="inEjeRegHisRecibido", type="integer", nullable=false)
     */
    private $inejereghisrecibido = 0;



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

    /**
     * Set inejepuntos
     *
     * @param integer $inejepuntos
     * @return LbEjemplares
     */
    public function setInejepuntos($inejepuntos)
    {
        $this->inejepuntos = $inejepuntos;

        return $this;
    }

    /**
     * Get inejepuntos
     *
     * @return integer 
     */
    public function getInejepuntos()
    {
        return $this->inejepuntos;
    }

    /**
     * Set inejepublicado
     *
     * @param integer $inejepublicado
     * @return LbEjemplares
     */
    public function setInejepublicado($inejepublicado)
    {
        $this->inejepublicado = $inejepublicado;

        return $this;
    }

    /**
     * Get inejepublicado
     *
     * @return integer 
     */
    public function getInejepublicado()
    {
        return $this->inejepublicado;
    }

    /**
     * Set inejebloqueado
     *
     * @param integer $inejebloqueado
     * @return LbEjemplares
     */
    public function setInejebloqueado($inejebloqueado)
    {
        $this->inejebloqueado = $inejebloqueado;

        return $this;
    }

    /**
     * Get inejebloqueado
     *
     * @return integer 
     */
    public function getInejebloqueado()
    {
        return $this->inejebloqueado;
    }

    /**
     * Set inejeestado
     *
     * @param integer $inejeestado
     * @return LbEjemplares
     */
    public function setInejeestado($inejeestado)
    {
        $this->inejeestado = $inejeestado;

        return $this;
    }

    /**
     * Get inejeestado
     *
     * @return integer 
     */
    public function getInejeestado()
    {
        return $this->inejeestado;
    }

    /**
     * Set inejecondicion
     *
     * @param integer $inejecondicion
     * @return LbEjemplares
     */
    public function setInejecondicion($inejecondicion)
    {
        $this->inejecondicion = $inejecondicion;

        return $this;
    }

    /**
     * Get inejecondicion
     *
     * @return integer 
     */
    public function getInejecondicion()
    {
        return $this->inejecondicion;
    }

    /**
     * Set inejesoloventa
     *
     * @param integer $inejesoloventa
     * @return LbEjemplares
     */
    public function setInejesoloventa($inejesoloventa)
    {
        $this->inejesoloventa = $inejesoloventa;

        return $this;
    }

    /**
     * Get inejesoloventa
     *
     * @return integer 
     */
    public function getInejesoloventa()
    {
        return $this->inejesoloventa;
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
     * Set inejeestadonegocio
     *
     * @param integer $inejeestadonegocio
     * @return LbEjemplares
     */
    public function setInejeestadonegocio($inejeestadonegocio)
    {
        $this->inejeestadonegocio = $inejeestadonegocio;

        return $this;
    }

    /**
     * Get inejeestadonegocio
     *
     * @return integer 
     */
    public function getInejeestadonegocio()
    {
        return $this->inejeestadonegocio;
    }
   
     /**
     * Set inejereghisbloqueo
     *
     * @param integer $inejereghisbloqueo
     * @return LbEjemplares
     */
    public function setInejereghisbloqueo($inejereghisbloqueo)
    {
        $this->inejereghisbloqueo = $inejereghisbloqueo;

        return $this;
    }

    /**
     * Get inejereghisbloqueo
     *
     * @return integer 
     */
    public function getInejereghisbloqueo()
    {
        return $this->inejereghisbloqueo;
    }

     /**
     * Set inejereghispublicacion
     *
     * @param integer $inejereghispublicacion
     * @return LbEjemplares
     */
    public function setInejereghispublicacion($inejereghispublicacion)
    {
        $this->inejereghispublicacion = $inejereghispublicacion;

        return $this;
    }

    /**
     * Get inejereghispublicacion
     *
     * @return integer 
     */
    public function getInejereghispublicacion()
    {
        return $this->inejereghispublicacion;
    }
    
     /**
     * Set inejereghisbajasis
     *
     * @param integer $inejereghisbajasis
     * @return LbEjemplares
     */
    public function setInejereghisbajasis($inejereghisbajasis)
    {
        $this->inejereghisbajasis = $inejereghisbajasis;

        return $this;
    }

    /**
     * Get inejereghisbajasis
     *
     * @return integer 
     */
    public function getInejereghisbajasis()
    {
        return $this->inejereghisbajasis;
    }
    
    
     /**
     * Set inejereghisaprobdueno
     *
     * @param integer $inejereghisaprobdueno
     * @return LbEjemplares
     */
    public function setInejereghisaprobdueno($inejereghisaprobdueno)
    {
        $this->inejereghisaprobdueno = $inejereghisaprobdueno;

        return $this;
    }

    /**
     * Get inejereghisaprobdueno
     *
     * @return integer 
     */
    public function getInejereghisaprobdueno()
    {
        return $this->inejereghisaprobdueno;
    }
     /**
     * Set inejereghisaprobsolic
     *
     * @param integer $inejereghisaprobsolic
     * @return LbEjemplares
     */
    public function setInejereghisaprobsolic($inejereghisaprobsolic)
    {
        $this->inejereghisaprobsolic = $inejereghisaprobsolic;

        return $this;
    }

    /**
     * Get inejereghisaprobsolic
     *
     * @return integer 
     */
    public function getInejereghisaprobsolic()
    {
        return $this->inejereghisaprobsolic;
    }
    
     /**
     * Set inejereghisentrega
     *
     * @param integer $inejereghisentrega
     * @return LbEjemplares
     */
    public function setInejereghisentrega($inejereghisentrega)
    {
        $this->inejereghisentrega = $inejereghisentrega;

        return $this;
    }

    /**
     * Get inejereghisentrega
     *
     * @return integer 
     */
    public function getInejereghisentrega()
    {
        return $this->inejereghisentrega;
    }
    
     /**
     * Set inejereghisrecibido
     *
     * @param integer $inejereghisrecibido
     * @return LbEjemplares
     */
    public function setInejereghisrecibido($inejereghisrecibido)
    {
        $this->inejereghisrecibido = $inejereghisrecibido;

        return $this;
    }

    /**
     * Get inejereghisrecibido
     *
     * @return integer 
     */
    public function getInejereghisrecibido()
    {
        return $this->inejereghisrecibido;
    }
    
 }
