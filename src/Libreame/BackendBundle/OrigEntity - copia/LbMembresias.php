<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbMembresias
 *
 * @ORM\Table(name="lb_membresias", indexes={@ORM\Index(name="fk_lb_membresias_lb_usuarios_idx", columns={"inMemUsuario"}), @ORM\Index(name="fk_lb_membresias_lb_grupos1_idx", columns={"inMemGrupo"})})
 * @ORM\Entity
 */
class LbMembresias
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inMembresia", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inmembresia;

    /**
     * @var integer
     *
     * @ORM\Column(name="inMemCreador", type="integer", nullable=false)
     */
    private $inmemcreador;

    /**
     * @var integer
     *
     * @ORM\Column(name="inMemActiva", type="integer", nullable=false)
     */
    private $inmemactiva;

    /**
     * @var \Libreame\BackendBundle\Entity\LbGrupos
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbGrupos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inMemGrupo", referencedColumnName="inGrupo")
     * })
     */
    private $inmemgrupo;

    /**
     * @var \Libreame\BackendBundle\Entity\LbUsuarios
     *
     * @ORM\ManyToOne(targetEntity="Libreame\BackendBundle\Entity\LbUsuarios")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="inMemUsuario", referencedColumnName="inUsuario")
     * })
     */
    private $inmemusuario;



    /**
     * Get inmembresia
     *
     * @return integer 
     */
    public function getInmembresia()
    {
        return $this->inmembresia;
    }

    /**
     * Set inmemcreador
     *
     * @param integer $inmemcreador
     * @return LbMembresias
     */
    public function setInmemcreador($inmemcreador)
    {
        $this->inmemcreador = $inmemcreador;

        return $this;
    }

    /**
     * Get inmemcreador
     *
     * @return integer 
     */
    public function getInmemcreador()
    {
        return $this->inmemcreador;
    }

    /**
     * Set inmemactiva
     *
     * @param integer $inmemactiva
     * @return LbMembresias
     */
    public function setInmemactiva($inmemactiva)
    {
        $this->inmemactiva = $inmemactiva;

        return $this;
    }

    /**
     * Get inmemactiva
     *
     * @return integer 
     */
    public function getInmemactiva()
    {
        return $this->inmemactiva;
    }

    /**
     * Set inmemgrupo
     *
     * @param \Libreame\BackendBundle\Entity\LbGrupos $inmemgrupo
     * @return LbMembresias
     */
    public function setInmemgrupo(\Libreame\BackendBundle\Entity\LbGrupos $inmemgrupo = null)
    {
        $this->inmemgrupo = $inmemgrupo;

        return $this;
    }

    /**
     * Get inmemgrupo
     *
     * @return \Libreame\BackendBundle\Entity\LbGrupos 
     */
    public function getInmemgrupo()
    {
        return $this->inmemgrupo;
    }

    /**
     * Set inmemusuario
     *
     * @param \Libreame\BackendBundle\Entity\LbUsuarios $inmemusuario
     * @return LbMembresias
     */
    public function setInmemusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inmemusuario = null)
    {
        $this->inmemusuario = $inmemusuario;

        return $this;
    }

    /**
     * Get inmemusuario
     *
     * @return \Libreame\BackendBundle\Entity\LbUsuarios 
     */
    public function getInmemusuario()
    {
        return $this->inmemusuario;
    }
}
