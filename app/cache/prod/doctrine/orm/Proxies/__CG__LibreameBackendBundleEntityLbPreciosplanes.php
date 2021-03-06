<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbPreciosplanes extends \Libreame\BackendBundle\Entity\LbPreciosplanes implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'inidprepid', 'dbprepprecioplanmes', 'dbprepprecioplananio', 'feprepiniciovigencia', 'feprepfinvigencia', 'inidprepidplan');
        }

        return array('__isInitialized__', 'inidprepid', 'dbprepprecioplanmes', 'dbprepprecioplananio', 'feprepiniciovigencia', 'feprepfinvigencia', 'inidprepidplan');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbPreciosplanes $proxy) {
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
    public function getInidprepid()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getInidprepid();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInidprepid', array());

        return parent::getInidprepid();
    }

    /**
     * {@inheritDoc}
     */
    public function setDbprepprecioplanmes($dbprepprecioplanmes)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDbprepprecioplanmes', array($dbprepprecioplanmes));

        return parent::setDbprepprecioplanmes($dbprepprecioplanmes);
    }

    /**
     * {@inheritDoc}
     */
    public function getDbprepprecioplanmes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDbprepprecioplanmes', array());

        return parent::getDbprepprecioplanmes();
    }

    /**
     * {@inheritDoc}
     */
    public function setDbprepprecioplananio($dbprepprecioplananio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDbprepprecioplananio', array($dbprepprecioplananio));

        return parent::setDbprepprecioplananio($dbprepprecioplananio);
    }

    /**
     * {@inheritDoc}
     */
    public function getDbprepprecioplananio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDbprepprecioplananio', array());

        return parent::getDbprepprecioplananio();
    }

    /**
     * {@inheritDoc}
     */
    public function setFeprepiniciovigencia($feprepiniciovigencia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFeprepiniciovigencia', array($feprepiniciovigencia));

        return parent::setFeprepiniciovigencia($feprepiniciovigencia);
    }

    /**
     * {@inheritDoc}
     */
    public function getFeprepiniciovigencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeprepiniciovigencia', array());

        return parent::getFeprepiniciovigencia();
    }

    /**
     * {@inheritDoc}
     */
    public function setFeprepfinvigencia($feprepfinvigencia)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFeprepfinvigencia', array($feprepfinvigencia));

        return parent::setFeprepfinvigencia($feprepfinvigencia);
    }

    /**
     * {@inheritDoc}
     */
    public function getFeprepfinvigencia()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeprepfinvigencia', array());

        return parent::getFeprepfinvigencia();
    }

    /**
     * {@inheritDoc}
     */
    public function setInidprepidplan(\Libreame\BackendBundle\Entity\LbPlanes $inidprepidplan = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInidprepidplan', array($inidprepidplan));

        return parent::setInidprepidplan($inidprepidplan);
    }

    /**
     * {@inheritDoc}
     */
    public function getInidprepidplan()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInidprepidplan', array());

        return parent::getInidprepidplan();
    }

}
