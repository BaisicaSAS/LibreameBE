<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbDispusuarios extends \Libreame\BackendBundle\Entity\LbDispusuarios implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'indispusuario', 'txdisid', 'txdisnombre', 'txdismarca', 'txdismodelo', 'txdisso', 'indisusuario');
        }

        return array('__isInitialized__', 'indispusuario', 'txdisid', 'txdisnombre', 'txdismarca', 'txdismodelo', 'txdisso', 'indisusuario');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbDispusuarios $proxy) {
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
    public function getIndispusuario()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getIndispusuario();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIndispusuario', array());

        return parent::getIndispusuario();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxdisid($txdisid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxdisid', array($txdisid));

        return parent::setTxdisid($txdisid);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxdisid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxdisid', array());

        return parent::getTxdisid();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxdisnombre($txdisnombre)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxdisnombre', array($txdisnombre));

        return parent::setTxdisnombre($txdisnombre);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxdisnombre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxdisnombre', array());

        return parent::getTxdisnombre();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxdismarca($txdismarca)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxdismarca', array($txdismarca));

        return parent::setTxdismarca($txdismarca);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxdismarca()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxdismarca', array());

        return parent::getTxdismarca();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxdismodelo($txdismodelo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxdismodelo', array($txdismodelo));

        return parent::setTxdismodelo($txdismodelo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxdismodelo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxdismodelo', array());

        return parent::getTxdismodelo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxdisso($txdisso)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxdisso', array($txdisso));

        return parent::setTxdisso($txdisso);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxdisso()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxdisso', array());

        return parent::getTxdisso();
    }

    /**
     * {@inheritDoc}
     */
    public function setIndisusuario(\Libreame\BackendBundle\Entity\LbUsuarios $indisusuario = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIndisusuario', array($indisusuario));

        return parent::setIndisusuario($indisusuario);
    }

    /**
     * {@inheritDoc}
     */
    public function getIndisusuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIndisusuario', array());

        return parent::getIndisusuario();
    }

    /**
     * {@inheritDoc}
     */
    public function creaDispusuario($usuario, $pSolicitud)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'creaDispusuario', array($usuario, $pSolicitud));

        return parent::creaDispusuario($usuario, $pSolicitud);
    }

}
