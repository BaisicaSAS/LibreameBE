<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbTitulos
 *
 * @ORM\Table(name="lb_titulos")
 * @ORM\Entity
 */
class LbTitulos
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIdTitulo", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inidtitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="txTitNTitulo", type="string", length=200, nullable=false)
     */
    private $txtitntitulo;



    /**
     * Get inidtitulo
     *
     * @return integer 
     */
    public function getInidtitulo()
    {
        return $this->inidtitulo;
    }

    /**
     * Set txtitntitulo
     *
     * @param string $txtitntitulo
     * @return LbTitulos
     */
    public function setTxtitntitulo($txtitntitulo)
    {
        $this->txtitntitulo = $txtitntitulo;

        return $this;
    }

    /**
     * Get txtitntitulo
     *
     * @return string 
     */
    public function getTxtitntitulo()
    {
        return $this->txtitntitulo;
    }
}
