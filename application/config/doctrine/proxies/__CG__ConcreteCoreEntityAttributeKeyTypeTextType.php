<?php

namespace DoctrineProxies\__CG__\Concrete\Core\Entity\Attribute\Key\Type;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class TextType extends \Concrete\Core\Entity\Attribute\Key\Type\TextType implements \Doctrine\ORM\Proxy\Proxy
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
    public static $lazyPropertiesDefaults = [];



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
            return ['__isInitialized__', 'akTextPlaceholder', 'akTypeID', 'akTypeHandle', 'key'];
        }

        return ['__isInitialized__', 'akTextPlaceholder', 'akTypeID', 'akTypeHandle', 'key'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (TextType $proxy) {
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
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
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
    public function getAttributeValue()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeValue', []);

        return parent::getAttributeValue();
    }

    /**
     * {@inheritDoc}
     */
    public function getPlaceholder()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlaceholder', []);

        return parent::getPlaceholder();
    }

    /**
     * {@inheritDoc}
     */
    public function setPlaceholder($placeholder)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlaceholder', [$placeholder]);

        return parent::setPlaceholder($placeholder);
    }

    /**
     * {@inheritDoc}
     */
    public function getKeyTypeID()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getKeyTypeID', []);

        return parent::getKeyTypeID();
    }

    /**
     * {@inheritDoc}
     */
    public function setKeyTypeID($akTypeID)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setKeyTypeID', [$akTypeID]);

        return parent::setKeyTypeID($akTypeID);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeTypeHandle()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeTypeHandle', []);

        return parent::getAttributeTypeHandle();
    }

    /**
     * {@inheritDoc}
     */
    public function setAttributeTypeHandle($akTypeHandle)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAttributeTypeHandle', [$akTypeHandle]);

        return parent::setAttributeTypeHandle($akTypeHandle);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeKey()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeKey', []);

        return parent::getAttributeKey();
    }

    /**
     * {@inheritDoc}
     */
    public function setAttributeKey($key)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAttributeKey', [$key]);

        return parent::setAttributeKey($key);
    }

    /**
     * {@inheritDoc}
     */
    public function getAttributeType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAttributeType', []);

        return parent::getAttributeType();
    }

    /**
     * {@inheritDoc}
     */
    public function createController()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'createController', []);

        return parent::createController();
    }

    /**
     * {@inheritDoc}
     */
    public function getController()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getController', []);

        return parent::getController();
    }

}
