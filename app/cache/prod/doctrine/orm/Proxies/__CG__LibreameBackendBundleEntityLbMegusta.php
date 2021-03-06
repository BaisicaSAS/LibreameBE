<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbMegusta extends \Libreame\BackendBundle\Entity\LbMegusta implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', 'inidmegusta', 'inmegmegusta', 'femegmegusta', 'inmegusuario', 'inmegejemplar');
        }

        return array('__isInitialized__', 'inidmegusta', 'inmegmegusta', 'femegmegusta', 'inmegusuario', 'inmegejemplar');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbMegusta $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getInidmegusta()
    {
        if ($this->__isInitialized__ === false) {
            return  parent::getInidmegusta();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInidmegusta', array());

        return parent::getInidmegusta();
    }

    /**
     * {@inheritDoc}
     */
    public function setInmegmegusta($inmegmegusta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInmegmegusta', array($inmegmegusta));

        return parent::setInmegmegusta($inmegmegusta);
    }

    /**
     * {@inheritDoc}
     */
    public function getInmegmegusta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInmegmegusta', array());

        return parent::getInmegmegusta();
    }

    /**
     * {@inheritDoc}
     */
    public function setFemegmegusta($femegmegusta)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFemegmegusta', array($femegmegusta));

        return parent::setFemegmegusta($femegmegusta);
    }

    /**
     * {@inheritDoc}
     */
    public function getFemegmegusta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFemegmegusta', array());

        return parent::getFemegmegusta();
    }

    /**
     * {@inheritDoc}
     */
    public function setInmegusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inmegusuario = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInmegusuario', array($inmegusuario));

        return parent::setInmegusuario($inmegusuario);
    }

    /**
     * {@inheritDoc}
     */
    public function getInmegusuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInmegusuario', array());

        return parent::getInmegusuario();
    }

    /**
     * {@inheritDoc}
     */
    public function setInmegejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $inmegejemplar = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInmegejemplar', array($inmegejemplar));

        return parent::setInmegejemplar($inmegejemplar);
    }

    /**
     * {@inheritDoc}
     */
    public function getInmegejemplar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInmegejemplar', array());

        return parent::getInmegejemplar();
    }

}
