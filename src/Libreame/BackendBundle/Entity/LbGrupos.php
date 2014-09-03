<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGrupos
 */
class LbGrupos
{
    /**
     * @var integer
     */
    private $ingrupo;

    /**
     * @var string
     */
    private $ingrunombre;

    /**
     * @var \DateTime
     */
    private $fegrufecha;

    /**
     * @var integer
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
