<?php

namespace Proxies\__CG__\Libreame\BackendBundle\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class LbLibros extends \Libreame\BackendBundle\Entity\LbLibros implements \Doctrine\ORM\Proxy\Proxy
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
            return array('__isInitialized__', 'inlibro', 'txlibtipopublica', 'txlibtitulo', 'txlibautores', 'txlibidioma', 'txlibeditorial', 'txlibedicionanio', 'txlibedicionnum', 'txlibedicionpais', 'txlibcodigoofic', 'txlibresumen', 'txlibtomo', 'txlibvolumen', 'txpaginas', 'txediciondescripcion', 'txlibcodigoofic13');
        }

        return array('__isInitialized__', 'inlibro', 'txlibtipopublica', 'txlibtitulo', 'txlibautores', 'txlibidioma', 'txlibeditorial', 'txlibedicionanio', 'txlibedicionnum', 'txlibedicionpais', 'txlibcodigoofic', 'txlibresumen', 'txlibtomo', 'txlibvolumen', 'txpaginas', 'txediciondescripcion', 'txlibcodigoofic13');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (LbLibros $proxy) {
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
    public function getInlibro()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getInlibro();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getInlibro', array());

        return parent::getInlibro();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibtipopublica($txlibtipopublica)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibtipopublica', array($txlibtipopublica));

        return parent::setTxlibtipopublica($txlibtipopublica);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibtipopublica()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibtipopublica', array());

        return parent::getTxlibtipopublica();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibtitulo($txlibtitulo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibtitulo', array($txlibtitulo));

        return parent::setTxlibtitulo($txlibtitulo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibtitulo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibtitulo', array());

        return parent::getTxlibtitulo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibautores($txlibautores)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibautores', array($txlibautores));

        return parent::setTxlibautores($txlibautores);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibautores()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibautores', array());

        return parent::getTxlibautores();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibidioma($txlibidioma)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibidioma', array($txlibidioma));

        return parent::setTxlibidioma($txlibidioma);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibidioma()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibidioma', array());

        return parent::getTxlibidioma();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibeditorial($txlibeditorial)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibeditorial', array($txlibeditorial));

        return parent::setTxlibeditorial($txlibeditorial);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibeditorial()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibeditorial', array());

        return parent::getTxlibeditorial();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibedicionanio($txlibedicionanio)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibedicionanio', array($txlibedicionanio));

        return parent::setTxlibedicionanio($txlibedicionanio);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibedicionanio()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibedicionanio', array());

        return parent::getTxlibedicionanio();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibedicionnum($txlibedicionnum)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibedicionnum', array($txlibedicionnum));

        return parent::setTxlibedicionnum($txlibedicionnum);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibedicionnum()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibedicionnum', array());

        return parent::getTxlibedicionnum();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibedicionpais($txlibedicionpais)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibedicionpais', array($txlibedicionpais));

        return parent::setTxlibedicionpais($txlibedicionpais);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibedicionpais()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibedicionpais', array());

        return parent::getTxlibedicionpais();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibcodigoofic($txlibcodigoofic)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibcodigoofic', array($txlibcodigoofic));

        return parent::setTxlibcodigoofic($txlibcodigoofic);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibcodigoofic()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibcodigoofic', array());

        return parent::getTxlibcodigoofic();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibresumen($txlibresumen)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibresumen', array($txlibresumen));

        return parent::setTxlibresumen($txlibresumen);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibresumen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibresumen', array());

        return parent::getTxlibresumen();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibtomo($txlibtomo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibtomo', array($txlibtomo));

        return parent::setTxlibtomo($txlibtomo);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibtomo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibtomo', array());

        return parent::getTxlibtomo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibvolumen($txlibvolumen)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibvolumen', array($txlibvolumen));

        return parent::setTxlibvolumen($txlibvolumen);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibvolumen()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibvolumen', array());

        return parent::getTxlibvolumen();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxpaginas($txpaginas)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxpaginas', array($txpaginas));

        return parent::setTxpaginas($txpaginas);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxpaginas()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxpaginas', array());

        return parent::getTxpaginas();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxediciondescripcion($txediciondescripcion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxediciondescripcion', array($txediciondescripcion));

        return parent::setTxediciondescripcion($txediciondescripcion);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxediciondescripcion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxediciondescripcion', array());

        return parent::getTxediciondescripcion();
    }

    /**
     * {@inheritDoc}
     */
    public function setTxlibcodigoofic13($txlibcodigoofic13)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTxlibcodigoofic13', array($txlibcodigoofic13));

        return parent::setTxlibcodigoofic13($txlibcodigoofic13);
    }

    /**
     * {@inheritDoc}
     */
    public function getTxlibcodigoofic13()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTxlibcodigoofic13', array());

        return parent::getTxlibcodigoofic13();
    }

}
