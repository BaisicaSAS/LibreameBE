<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbActividadofertas extends \Libreame\BackendBundle\Entity\LbActividadofertas implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'inactividadoferta', 'feactfechahora', 'txactdescripcion', 'inactestado', 'inactpadreact', 'inactoferta', 'inactusuario');
        }

        return array('__isInitialized__', 'inactividadoferta', 'feactfechahora', 'txactdescripcion', 'inactestado', 'inactpadreact', 'inactoferta', 'inactusuario');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbActividadofertas $proxy) {
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
    public function getInactividadoferta()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getInactividadoferta();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInactividadoferta', array());

        return parent::getInactividadoferta();
    }

    /**
     * {@inheritDoc}
     */
    public function setFeactfechahora($feactfechahora)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFeactfechahora', array($feactfechahora));

        return parent::setFeactfechahora($feactfechahora);
    }

    /**
     * {@inheritDoc}
     */
    public function getFeactfechahora()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeactfechahora', array());

        return parent::getFeactfechahora();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxactdescripcion($txactdescripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxactdescripcion', array($txactdescripcion));

        return parent::setTxactdescripcion($txactdescripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxactdescripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxactdescripcion', array());

        return parent::getTxactdescripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function setInactestado($inactestado)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInactestado', array($inactestado));

        return parent::setInactestado($inactestado);
    }

    /**
     * {@inheritDoc}
     */
    public function getInactestado()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInactestado', array());

        return parent::getInactestado();
    }

    /**
     * {@inheritDoc}
     */
    public function setInactpadreact(\Libreame\BackendBundle\Entity\LbActividadofertas $inactpadreact = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInactpadreact', array($inactpadreact));

        return parent::setInactpadreact($inactpadreact);
    }

    /**
     * {@inheritDoc}
     */
    public function getInactpadreact()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInactpadreact', array());

        return parent::getInactpadreact();
    }

    /**
     * {@inheritDoc}
     */
    public function setInactoferta(\Libreame\BackendBundle\Entity\LbOfertas $inactoferta = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInactoferta', array($inactoferta));

        return parent::setInactoferta($inactoferta);
    }

    /**
     * {@inheritDoc}
     */
    public function getInactoferta()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInactoferta', array());

        return parent::getInactoferta();
    }

    /**
     * {@inheritDoc}
     */
    public function setInactusuario(\Libreame\BackendBundle\Entity\LbUsuarios $inactusuario = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInactusuario', array($inactusuario));

        return parent::setInactusuario($inactusuario);
    }

    /**
     * {@inheritDoc}
     */
    public function getInactusuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInactusuario', array());

        return parent::getInactusuario();
    }

}