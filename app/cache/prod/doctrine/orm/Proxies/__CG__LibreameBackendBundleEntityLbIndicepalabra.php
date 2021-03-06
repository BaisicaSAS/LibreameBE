<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbIndicepalabra extends \Libreame\BackendBundle\Entity\LbIndicepalabra implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'lbindpalid', 'lbindpalpalabra', 'lbindpalidioma', 'lbindpallibro');
        }

        return array('__isInitialized__', 'lbindpalid', 'lbindpalpalabra', 'lbindpalidioma', 'lbindpallibro');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbIndicepalabra $proxy) {
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
    public function getLbindpalid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getLbindpalid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLbindpalid', array());

        return parent::getLbindpalid();
    }

    /**
     * {@inheritDoc}
     */
    public function setLbindpalpalabra($lbindpalpalabra)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLbindpalpalabra', array($lbindpalpalabra));

        return parent::setLbindpalpalabra($lbindpalpalabra);
    }

    /**
     * {@inheritDoc}
     */
    public function getLbindpalpalabra()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLbindpalpalabra', array());

        return parent::getLbindpalpalabra();
    }

    /**
     * {@inheritDoc}
     */
    public function setLbindpalidioma($lbindpalidioma)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLbindpalidioma', array($lbindpalidioma));

        return parent::setLbindpalidioma($lbindpalidioma);
    }

    /**
     * {@inheritDoc}
     */
    public function getLbindpalidioma()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLbindpalidioma', array());

        return parent::getLbindpalidioma();
    }

    /**
     * {@inheritDoc}
     */
    public function setLbindpallibro(\Libreame\BackendBundle\Entity\LbLibros $lbindpallibro = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLbindpallibro', array($lbindpallibro));

        return parent::setLbindpallibro($lbindpallibro);
    }

    /**
     * {@inheritDoc}
     */
    public function getLbindpallibro()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLbindpallibro', array());

        return parent::getLbindpallibro();
    }

}
