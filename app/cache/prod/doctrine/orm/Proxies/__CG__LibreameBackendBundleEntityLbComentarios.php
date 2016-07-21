<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbComentarios extends \Libreame\BackendBundle\Entity\LbComentarios implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'inidcomentario', 'txcomcomentario', 'fecomfeccomentario', 'incomactivo', 'incomcompadre', 'incomejemplar', 'incomusuario');
        }

        return array('__isInitialized__', 'inidcomentario', 'txcomcomentario', 'fecomfeccomentario', 'incomactivo', 'incomcompadre', 'incomejemplar', 'incomusuario');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbComentarios $proxy) {
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
    public function getInidcomentario()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getInidcomentario();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInidcomentario', array());

        return parent::getInidcomentario();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxcomcomentario($txcomcomentario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxcomcomentario', array($txcomcomentario));

        return parent::setTxcomcomentario($txcomcomentario);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxcomcomentario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxcomcomentario', array());

        return parent::getTxcomcomentario();
    }

    /**
     * {@inheritDoc}
     */
    public function setFecomfeccomentario($fecomfeccomentario)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFecomfeccomentario', array($fecomfeccomentario));

        return parent::setFecomfeccomentario($fecomfeccomentario);
    }

    /**
     * {@inheritDoc}
     */
    public function getFecomfeccomentario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFecomfeccomentario', array());

        return parent::getFecomfeccomentario();
    }

    /**
     * {@inheritDoc}
     */
    public function setIncomactivo($incomactivo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIncomactivo', array($incomactivo));

        return parent::setIncomactivo($incomactivo);
    }

    /**
     * {@inheritDoc}
     */
    public function getIncomactivo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIncomactivo', array());

        return parent::getIncomactivo();
    }

    /**
     * {@inheritDoc}
     */
    public function setIncomcompadre(\Libreame\BackendBundle\Entity\LbComentarios $incomcompadre = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIncomcompadre', array($incomcompadre));

        return parent::setIncomcompadre($incomcompadre);
    }

    /**
     * {@inheritDoc}
     */
    public function getIncomcompadre()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIncomcompadre', array());

        return parent::getIncomcompadre();
    }

    /**
     * {@inheritDoc}
     */
    public function setIncomejemplar(\Libreame\BackendBundle\Entity\LbEjemplares $incomejemplar = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIncomejemplar', array($incomejemplar));

        return parent::setIncomejemplar($incomejemplar);
    }

    /**
     * {@inheritDoc}
     */
    public function getIncomejemplar()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIncomejemplar', array());

        return parent::getIncomejemplar();
    }

    /**
     * {@inheritDoc}
     */
    public function setIncomusuario(\Libreame\BackendBundle\Entity\LbUsuarios $incomusuario = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIncomusuario', array($incomusuario));

        return parent::setIncomusuario($incomusuario);
    }

    /**
     * {@inheritDoc}
     */
    public function getIncomusuario()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIncomusuario', array());

        return parent::getIncomusuario();
    }

}