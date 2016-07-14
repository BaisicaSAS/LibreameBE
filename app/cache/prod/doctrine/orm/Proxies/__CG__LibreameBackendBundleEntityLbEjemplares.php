<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbEjemplares extends \Libreame\BackendBundle\Entity\LbEjemplares implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'inejemplar', 'inejecantidad', 'dbejeavaluo', 'inejelibro', 'inejeusudueno', 'txejeimagen');
        }

        return array('__isInitialized__', 'inejemplar', 'inejecantidad', 'dbejeavaluo', 'inejelibro', 'inejeusudueno', 'txejeimagen');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbEjemplares $proxy) {
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
    public function getInejemplar()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getInejemplar();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInejemplar', array());

        return parent::getInejemplar();
    }

    /**
     * {@inheritDoc}
     */
    public function setInejecantidad($inejecantidad)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInejecantidad', array($inejecantidad));

        return parent::setInejecantidad($inejecantidad);
    }

    /**
     * {@inheritDoc}
     */
    public function getInejecantidad()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInejecantidad', array());

        return parent::getInejecantidad();
    }

    /**
     * {@inheritDoc}
     */
    public function setDbejeavaluo($dbejeavaluo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDbejeavaluo', array($dbejeavaluo));

        return parent::setDbejeavaluo($dbejeavaluo);
    }

    /**
     * {@inheritDoc}
     */
    public function getDbejeavaluo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDbejeavaluo', array());

        return parent::getDbejeavaluo();
    }

    /**
     * {@inheritDoc}
     */
    public function setInejelibro(\Libreame\BackendBundle\Entity\LbLibros $inejelibro = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInejelibro', array($inejelibro));

        return parent::setInejelibro($inejelibro);
    }

    /**
     * {@inheritDoc}
     */
    public function getInejelibro()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInejelibro', array());

        return parent::getInejelibro();
    }

    /**
     * {@inheritDoc}
     */
    public function setInejeusudueno(\Libreame\BackendBundle\Entity\LbUsuarios $inejeusudueno = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInejeusudueno', array($inejeusudueno));

        return parent::setInejeusudueno($inejeusudueno);
    }

    /**
     * {@inheritDoc}
     */
    public function getInejeusudueno()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInejeusudueno', array());

        return parent::getInejeusudueno();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxejeimagen($txejeimagen)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxejeimagen', array($txejeimagen));

        return parent::setTxejeimagen($txejeimagen);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxejeimagen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxejeimagen', array());

        return parent::getTxejeimagen();
    }

}
