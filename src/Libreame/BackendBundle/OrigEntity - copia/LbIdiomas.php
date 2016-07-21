<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbIdiomas
 *
 * @ORM\Table(name="lb_idiomas")
 * @ORM\Entity
 */
class LbIdiomas
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIdIdioma", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inididioma;

    /**
     * @var string
     *
     * @ORM\Column(name="txIdiNombre", type="string", length=100, nullable=false)
     */
    private $txidinombre;



    /**
     * Get inididioma
     *
     * @return integer 
     */
    public function getInididioma()
    {
        return $this->inididioma;
    }

    /**
     * Set txidinombre
     *
     * @param string $txidinombre
     * @return LbIdiomas
     */
    public function setTxidinombre($txidinombre)
    {
        $this->txidinombre = $txidinombre;

        return $this;
    }

    /**
     * Get txidinombre
     *
     * @return string 
     */
    public function getTxidinombre()
    {
        return $this->txidinombre;
    }
}
