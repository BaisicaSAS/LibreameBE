<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGeneros
 *
 * @ORM\Table(name="lb_generos")
 * @ORM\Entity
 */
class LbGeneros
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inGenero", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $ingenero;

    /**
     * @var string
     *
     * @ORM\Column(name="txGenNombre", type="string", length=45, nullable=false)
     */
    private $txgennombre;



    /**
     * Get ingenero
     *
     * @return integer 
     */
    public function getIngenero()
    {
        return $this->ingenero;
    }

    /**
     * Set txgennombre
     *
     * @param string $txgennombre
     * @return LbGeneros
     */
    public function setTxgennombre($txgennombre)
    {
        $this->txgennombre = $txgennombre;

        return $this;
    }

    /**
     * Get txgennombre
     *
     * @return string 
     */
    public function getTxgennombre()
    {
        return $this->txgennombre;
    }
}
