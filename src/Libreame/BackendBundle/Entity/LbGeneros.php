<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbGeneros
 */
class LbGeneros
{
    /**
     * @var integer
     */
    private $ingenero;

    /**
     * @var string
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
