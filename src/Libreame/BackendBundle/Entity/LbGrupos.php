<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGrupos
 *
 * @ORM\Table(name="lb_grupos")
 * @ORM\Entity
 */
class LbGrupos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inGrupo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ingrupo;

    /**
     * @var string
     *
     * @ORM\Column(name="inGruNombre", type="string", length=100, nullable=false)
     */
    private $ingrunombre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="feGruFecha", type="datetime", nullable=false)
     */
    private $fegrufecha;

    /**
     * @var integer
     *
     * @ORM\Column(name="inGruCantMiem", type="integer", nullable=false)
     */
    private $ingrucantmiem;



    /**
     * Get ingrupo
     *
     * @return integer 
     */
    public function getIngrupo()
    {
        return $this->ingrupo;
    }

    /**
     * Set ingrunombre
     *
     * @param string $ingrunombre
     * @return LbGrupos
     */
    public function setIngrunombre($ingrunombre)
    {
        $this->ingrunombre = $ingrunombre;

        return $this;
    }

    /**
     * Get ingrunombre
     *
     * @return string 
     */
    public function getIngrunombre()
    {
        return $this->ingrunombre;
    }

    /**
     * Set fegrufecha
     *
     * @param \DateTime $fegrufecha
     * @return LbGrupos
     */
    public function setFegrufecha($fegrufecha)
    {
        $this->fegrufecha = $fegrufecha;

        return $this;
    }

    /**
     * Get fegrufecha
     *
     * @return \DateTime 
     */
    public function getFegrufecha()
    {
        return $this->fegrufecha;
    }

    /**
     * Set ingrucantmiem
     *
     * @param integer $ingrucantmiem
     * @return LbGrupos
     */
    public function setIngrucantmiem($ingrucantmiem)
    {
        $this->ingrucantmiem = $ingrucantmiem;

        return $this;
    }

    /**
     * Get ingrucantmiem
     *
     * @return integer 
     */
    public function getIngrucantmiem()
    {
        return $this->ingrucantmiem;
    }
}
