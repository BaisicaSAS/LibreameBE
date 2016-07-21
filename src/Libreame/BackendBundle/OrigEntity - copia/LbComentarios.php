<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbComentarios
 *
 * @ORM\Table(name="lb_comentarios", indexes={@ORM\Index(name="fk_lb_comentarios_lb_ejemplares1_idx", columns={"inComEjemplar"}), @ORM\Index(name="fk_lb_comentarios_lb_usuarios1_idx", columns={"inComUsuario"}), @ORM\Index(name="fk_lb_comentarios_lb_comentarios1_idx", columns={"inComComPadre"})})
 * @ORM\Entity
 */
class LbComentarios
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIDComentario", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidcomentario;

    /**
     * @var string
     *
     * @ORM\Column(name="txComComentario", type="text", nullable=false)
     */
    private $txcomcomentario;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feComFecComentario", type="datetime", nullable=false)
     */
    private $fecomfeccomentario;

    /**
     * @var integer
     *
     * @ORM\Column(name="inComActivo", type="integer", nullable=false)
     */
    private $incomactivo;

    /**
     * @var \Libreame\BackendBundle\Entity\LbComentarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbComentarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inComComPadre", referencedColumnName="inIDComentario")
     * })
     */
    private $incomcompadre;

    /**
     * @var \Libreame\BackendBundle\Entity\LbEjemplares
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbEjemplares")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inComEjemplar", referencedColumnName="inEjemplar")
     * })
     */
    private $incomejemplar;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inComUsuario", referencedColumnName="inUsuario")
     * })
     */
    private $incomusuario;



    /**
     * Get inidcomentario
     *
     * @return integer 
     */
    public function getInidcomentario()
    {
        return $this->inidcomentario;
    }

    /**
     * Set txcomcomentario
     *
     * @param string $txcomcomentario
     * @return LbComentarios
     */
    public function setTxcomcomentario($txcomcomentario)
    {
        $this->txcomcomentario = $txcomcomentario;

        return $this;
    }

    /**
     * Get txcomcomentario
     *
     * @return string 
     */
    public function getTxcomcomentario()
    {
        return $this->txcomcomentario;
    }

    /**
     * Set fecomfeccomentario
     *
     * @param \DateTime $fecomfeccomentario
     * @return LbComentarios
     */
    public function setFecomfeccomentario($fecomfeccomentario)
    {
        $this->fecomfeccomentario = $fecomfeccomentario;

        return $this;
    }

    /**
     * Get fecomfeccomentario
     *
     * @return \DateTime 
     */
    public function getFecomfeccomentario()
    {
        return $this->fecomfeccomentario;
    }

    /**
     * Set incomactivo
     *
     * @param integer $incomactivo
     * @return LbComentarios
     */
    public function setIncomactivo($incomactivo)
    {
        $this->incomactivo = $incomactivo;

        return $this;
    }

    /**
     * Get incomactivo
     *
     * @return integer 
     */
    public function getIncomactivo()
    {
        return $this->incomactivo;
    }

    /**
     * Set incomcompadre
     *
     * @param \Libreame\BackendBundle\Entity\LbComentarios $incomcompadre
     * @return LbComentarios
     */
    public function setIncomcompadre(\Libreame\BackendBundle\Entity\LbComentarios $incomcompadre = null)
    {
        $this->incomcompadre = $incomcompadre;

        return $this;
    }

    /**
     * Get incomcompadre
     *
     * @return \Libreame\BackendBundle\Entity\LbComentarios 
     */
    public function getIncomcompadre()
    {
        return $this->incomcompadre;
    }

    /**
     * Set incomejemplar
     *
     * @param \Libreame\BackendBundle\Entity\LbEjemplares $incomejemplar
     * @return LbComentarios
     */
    public function setIncomejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $incomejemplar = null)
    {
        $this->incomejemplar = $incomejemplar;

        return $this;
    }

    /**
     * Get incomejemplar
     *
     * @return \Libreame\BackendBundle\Entity\LbEjemplares 
     */
    public function getIncomejemplar()
    {
        return $this->incomejemplar;
    }

    /**
     * Set incomusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $incomusuario
     * @return LbComentarios
     */
    public function setIncomusuario(\Libreame\BackendBundle\Entity\LbUsuarios $incomusuario = null)
    {
        $this->incomusuario = $incomusuario;

        return $this;
    }

    /**
     * Get incomusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getIncomusuario()
    {
        return $this->incomusuario;
    }
}
