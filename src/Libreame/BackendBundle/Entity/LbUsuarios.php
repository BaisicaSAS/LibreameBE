<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Libreame\BackendBundle\Helpers\Logica;
use Libreame\BackendBundle\Controller\AccesoController;

/**
 * LbUsuarios
 *
 * @ORM\Table(name="lb_usuarios", uniqueConstraints={@ORM\UniqueConstraint(name="txUsuEmail_UNIQUE", columns={"txUsuEmail"}), @ORM\UniqueConstraint(name="txUsuTelefono_UNIQUE", columns={"txUsuTelefono"})}, indexes={@ORM\Index(name="fk_lb_usuarios_lb_lugares1_idx", columns={"inUsuLugar"})})
 * @ORM\Entity
 */
class LbUsuarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inUsuario", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inusuario;

    /**
     * @var string
     *
     * @ORM\Column(name="txUsuEmail", type="string", length=200, nullable=false)
     */
    private $txusuemail;

    /**
     * @var string
     *
     * @ORM\Column(name="txUsuTelefono", type="string", length=200, nullable=false)
     */
    private $txusutelefono;

    /**
     * @var string
     *
     * @ORM\Column(name="txUsuNombre", type="string", length=300, nullable=false)
     */
    private $txusunombre;

    /**
     * @var integer
     *
     * @ORM\Column(name="inUsuGenero", type="integer", nullable=false)
     */
    private $inusugenero = 2;

    /**
     * @var string
     *
     * @ORM\Column(name="txUsuImagen", type="text", nullable=false)
     */
    private $txusuimagen;

    /**
     * @var string
     *
     * @ORM\Column(name="txUsuNomMostrar", type="string", length=300, nullable=true)
     */
    private $txusunommostrar;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feUsuNacimiento", type="datetime", nullable=true)
     */
    private $feusunacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="txUsuValidacion", type="string", length=300, nullable=true)
     */
    private $txusuvalidacion;

    /**
     * @var integer
     *
     * @ORM\Column(name="inUsuEstado", type="integer", nullable=false)
     */
    private $inusuestado = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="txUsuClave", type="string", length=300, nullable=false)
     */
    private $txusuclave;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feFecRegistro", type="datetime", nullable=false)
     */
    private $fefecregistro;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feUsuUltIngreso", type="datetime", nullable=false)
     */
    private $feusuultingreso;

    /**
     * @var \Libreame\BackendBundle\Entity\LbLugares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbLugares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inUsuLugar", referencedColumnName="inLugar")
     * })
     */
    private $inusulugar = 1;



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
     * Set txusuclave
     *
     * @param string $txusuclave
     * @return LbUsuarios
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

    /**
     * Set fefecregistro
     *
     * @param \DateTime $fefecregistro
     * @return LbUsuarios
     */
    public function setFefecregistro($fefecregistro)
    {
        $this->fefecregistro = $fefecregistro;

        return $this;
    }

    /**
     * Get fefecregistro
     *
     * @return \DateTime 
     */
    public function getFefecregistro()
    {
        return $this->fefecregistro;
    }

    /**
     * Set feusuultingreso
     *
     * @param \DateTime $feusuultingreso
     * @return LbUsuarios
     */
    public function setFeusuultingreso($feusuultingreso)
    {
        $this->feusuultingreso = $feusuultingreso;

        return $this;
    }

    /**
     * Get feusuultingreso
     *
     * @return \DateTime 
     */
    public function getFeusuultingreso()
    {
        return $this->feusuultingreso;
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
    
        //Constructor de la clase
    function __construct(){ 
        $strBlanco = "";
        $this->txusuemail = $strBlanco;
        $this->txusunombre = $strBlanco;  
        $this->txusunommostrar = $strBlanco;
        $this->txusutelefono = $strBlanco;
        $this->txusuclave = $strBlanco;
        $this->txusuimagen = $strBlanco;
        $this->inusulugar = $strBlanco;
        $this->txusuvalidacion = $strBlanco;
    } 
    

    //Función que crea un usuario para su registro en el sistema
    public function creaUsuario($pSolicitud, $Lugar)
    {   
        $usuario = new LbUsuarios() ;
        try {
            setlocale (LC_TIME, "es_CO");
            $fechaReg = new \DateTime('c');
            $usuario->settxusuemail($pSolicitud->getEmail());  
            $usuario->settxusunombre($pSolicitud->getEmail());  
            $usuario->settxusunommostrar($pSolicitud->getEmail());
            $usuario->setFefecregistro($fechaReg);
            $usuario->setFeusuultingreso($fechaReg);
            if (trim($pSolicitud->getTelefono()) == ""){
                $usuario->settxusutelefono(AccesoController::txMenNoId);  
            } else {
                $usuario->settxusutelefono($pSolicitud->getTelefono());  
            }
            $usuario->settxusuclave($pSolicitud->getClave());  
            $usuario->settxusuimagen('DEFAULT IMAGE URL');  
            $usuario->setinusulugar($Lugar);  
            $usuario->settxusuvalidacion(Logica::generaRand(AccesoController::inTamVali));  

            return $usuario;
        } catch (Exception $ex)  {    
            return $usuario;
        }
    }

}
