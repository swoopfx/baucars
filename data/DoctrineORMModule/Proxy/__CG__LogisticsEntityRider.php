<?php

namespace DoctrineORMModule\Proxy\__CG__\Logistics\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Rider extends \Logistics\Entity\Rider implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Proxy\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array<string, null> properties to be lazy loaded, indexed by property name
     */
    public static $lazyPropertiesNames = array (
);

    /**
     * @var array<string, mixed> default values of properties to be lazy loaded, with keys being the property names
     *
     * @see \Doctrine\Common\Proxy\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array (
);



    public function __construct(?\Closure $initializer = null, ?\Closure $cloner = null)
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
            return ['__isInitialized__', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'id', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'isActive', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'riderUid', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'dispatch', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverSince', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverImage', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverDob', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'updatedOn', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'height', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'weight', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'eyeColor', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'complexion', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'createdOn', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'user', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverState'];
        }

        return ['__isInitialized__', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'id', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'isActive', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'riderUid', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'dispatch', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverSince', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverImage', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverDob', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'updatedOn', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'height', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'weight', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'eyeColor', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'complexion', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'createdOn', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'user', '' . "\0" . 'Logistics\\Entity\\Rider' . "\0" . 'driverState'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Rider $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy::$lazyPropertiesDefaults as $property => $defaultValue) {
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
     * @deprecated no longer in use - generated code now relies on internal components rather than generated public API
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsActive()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsActive', []);

        return parent::getIsActive();
    }

    /**
     * {@inheritDoc}
     */
    public function getRiderUid()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRiderUid', []);

        return parent::getRiderUid();
    }

    /**
     * {@inheritDoc}
     */
    public function getDispatch()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDispatch', []);

        return parent::getDispatch();
    }

    /**
     * {@inheritDoc}
     */
    public function getDriverSince()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDriverSince', []);

        return parent::getDriverSince();
    }

    /**
     * {@inheritDoc}
     */
    public function getDriverImage()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDriverImage', []);

        return parent::getDriverImage();
    }

    /**
     * {@inheritDoc}
     */
    public function getDriverDob()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDriverDob', []);

        return parent::getDriverDob();
    }

    /**
     * {@inheritDoc}
     */
    public function getUpdatedOn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedOn', []);

        return parent::getUpdatedOn();
    }

    /**
     * {@inheritDoc}
     */
    public function getHeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getHeight', []);

        return parent::getHeight();
    }

    /**
     * {@inheritDoc}
     */
    public function getWeight()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getWeight', []);

        return parent::getWeight();
    }

    /**
     * {@inheritDoc}
     */
    public function getEyeColor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getEyeColor', []);

        return parent::getEyeColor();
    }

    /**
     * {@inheritDoc}
     */
    public function getComplexion()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComplexion', []);

        return parent::getComplexion();
    }

    /**
     * {@inheritDoc}
     */
    public function getCreatedOn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getCreatedOn', []);

        return parent::getCreatedOn();
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUser', []);

        return parent::getUser();
    }

    /**
     * {@inheritDoc}
     */
    public function getDriverState()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDriverState', []);

        return parent::getDriverState();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', [$id]);

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsActive($isActive)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsActive', [$isActive]);

        return parent::setIsActive($isActive);
    }

    /**
     * {@inheritDoc}
     */
    public function setRiderUid($riderUid)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRiderUid', [$riderUid]);

        return parent::setRiderUid($riderUid);
    }

    /**
     * {@inheritDoc}
     */
    public function setDispatch($dispatch)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDispatch', [$dispatch]);

        return parent::setDispatch($dispatch);
    }

    /**
     * {@inheritDoc}
     */
    public function setDriverSince($driverSince)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDriverSince', [$driverSince]);

        return parent::setDriverSince($driverSince);
    }

    /**
     * {@inheritDoc}
     */
    public function setDriverImage($driverImage)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDriverImage', [$driverImage]);

        return parent::setDriverImage($driverImage);
    }

    /**
     * {@inheritDoc}
     */
    public function setDriverDob($driverDob)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDriverDob', [$driverDob]);

        return parent::setDriverDob($driverDob);
    }

    /**
     * {@inheritDoc}
     */
    public function setUpdatedOn($updatedOn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedOn', [$updatedOn]);

        return parent::setUpdatedOn($updatedOn);
    }

    /**
     * {@inheritDoc}
     */
    public function setHeight($height)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setHeight', [$height]);

        return parent::setHeight($height);
    }

    /**
     * {@inheritDoc}
     */
    public function setWeight($weight)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setWeight', [$weight]);

        return parent::setWeight($weight);
    }

    /**
     * {@inheritDoc}
     */
    public function setEyeColor($eyeColor)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setEyeColor', [$eyeColor]);

        return parent::setEyeColor($eyeColor);
    }

    /**
     * {@inheritDoc}
     */
    public function setComplexion($complexion)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setComplexion', [$complexion]);

        return parent::setComplexion($complexion);
    }

    /**
     * {@inheritDoc}
     */
    public function setCreatedOn($createdOn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setCreatedOn', [$createdOn]);

        return parent::setCreatedOn($createdOn);
    }

    /**
     * {@inheritDoc}
     */
    public function setUser($user)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUser', [$user]);

        return parent::setUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function setDriverState($driverState)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDriverState', [$driverState]);

        return parent::setDriverState($driverState);
    }

}