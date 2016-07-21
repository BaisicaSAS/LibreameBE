<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbPlanesusuarios extends \Libreame\BackendBundle\Entity\LbPlanesusuarios implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'inplanusuario', 'feplusinicio', 'feplusfin', 'inplusplanes', 'inusuplan');
        }

        return array('__isInitialized__', 'inplanusuario', 'feplusinicio', 'feplusfin', 'inplusplanes', 'inusuplan');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbPlanesusuarios $proxy) {
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
    public function getInplanusuario()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getInplanusuario();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInplanusuario', array());

        return parent::getInplanusuario();
    }

    /**
     * {@inheritDoc}
     */
    public function setFeplusinicio($feplusinicio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFeplusinicio', array($feplusinicio));

        return parent::setFeplusinicio($feplusinicio);
    }

    /**
     * {@inheritDoc}
     */
    public function getFeplusinicio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeplusinicio', array());

        return parent::getFeplusinicio();
    }

    /**
     * {@inheritDoc}
     */
    public function setFeplusfin($feplusfin)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFeplusfin', array($feplusfin));

        return parent::setFeplusfin($feplusfin);
    }

    /**
     * {@inheritDoc}
     */
    public function getFeplusfin()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFeplusfin', array());

        return parent::getFeplusfin();
    }

    /**
     * {@inheritDoc}
     */
    public function setInplusplanes(\Libreame\BackendBundle\Entity\LbPlanes $inplusplanes = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInplusplanes', array($inplusplanes));

        return parent::setInplusplanes($inplusplanes);
    }

    /**
     * {@inheritDoc}
     */
    public function getInplusplanes()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInplusplanes', array());

        return parent::getInplusplanes();
    }

    /**
     * {@inheritDoc}
     */
    public function setInusuplan(\Libreame\BackendBundle\Entity\LbUsuarios $inusuplan = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setInusuplan', array($inusuplan));

        return parent::setInusuplan($inusuplan);
    }

    /**
     * {@inheritDoc}
     */
    public function getInusuplan()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInusuplan', array());

        return parent::getInusuplan();
    }

}
