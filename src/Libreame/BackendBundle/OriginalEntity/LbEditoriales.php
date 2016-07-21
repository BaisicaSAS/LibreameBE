<?php

namespace Libreame\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LbEditoriales
 *
 * @ORM\Table(name="lb_editoriales")
 * @ORM\Entity
 */
class LbEditoriales
{
    /**
     * @var integer
     *
     * @ORM\Column(name="inIdEditorial", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $inideditorial;

    /**
     * @var string
     *
     * @ORM\Column(name="txEdiNombre", type="string", length=100, nullable=false)
     */
    private $txedinombre;

    /**
     * @var string
     *
     * @ORM\Column(name="txEdiPais", type="string", length=100, nullable=true)
     */
    private $txedipais;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Libreame\BackendBundle\Entity\LbLibros", mappedBy="inedilibroeditorial")
     */
    private $inediliblibro;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->inediliblibro = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Get inideditorial
     *
     * @return integer 
     */
    public function getInideditorial()
    {
        return $this->inideditorial;
    }

    /**
     * Set txedinombre
     *
     * @param string $txedinombre
     * @return LbEditoriales
     */
    public function setTxedinombre($txedinombre)
    {
        $this->txedinombre = $txedinombre;

        return $this;
    }

    /**
     * Get txedinombre
     *
     * @return string 
     */
    public function getTxedinombre()
    {
        return $this->txedinombre;
    }

    /**
     * Set txedipais
     *
     * @param string $txedipais
     * @return LbEditoriales
     */
    public function setTxedipais($txedipais)
    {
        $this->txedipais = $txedipais;

        return $this;
    }

    /**
     * Get txedipais
     *
     * @return string 
     */
    public function getTxedipais()
    {
        return $this->txedipais;
    }

    /**
     * Add inediliblibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $inediliblibro
     * @return LbEditoriales
     */
    public function addInediliblibro(\Libreame\BackendBundle\Entity\LbLibros $inediliblibro)
    {
        $this->inediliblibro[] = $inediliblibro;

        return $this;
    }

    /**
     * Remove inediliblibro
     *
     * @param \Libreame\BackendBundle\Entity\LbLibros $inediliblibro
     */
    public function removeInediliblibro(\Libreame\BackendBundle\Entity\LbLibros $inediliblibro)
    {
        $this->inediliblibro->removeElement($inediliblibro);
    }

    /**
     * Get inediliblibro
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInediliblibro()
    {
        return $this->inediliblibro;
    }
}
