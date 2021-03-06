<?php

namespace DoctrineORMModule\Proxy\__CG__\Application\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Cars extends \Application\Entity\Cars implements \Doctrine\ORM\Proxy\Proxy
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
            return ['__isInitialized__', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'id', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'description', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'platNumber', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorMake', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorType', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorColor', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorClass', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorTransmission', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'doors', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'fuel', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorName', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isAirBag', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isAbs', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isGps', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isInsurance', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isMusic', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isCarkit', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isBluetooth', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'createdOn', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'updatedOn'];
        }

        return ['__isInitialized__', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'id', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'description', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'platNumber', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorMake', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorType', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorColor', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorClass', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorTransmission', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'doors', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'fuel', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'motorName', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isAirBag', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isAbs', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isGps', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isInsurance', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isMusic', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isCarkit', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'isBluetooth', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'createdOn', '' . "\0" . 'Application\\Entity\\Cars' . "\0" . 'updatedOn'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Cars $proxy) {
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
    public function getDescription()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescription', []);

        return parent::getDescription();
    }

    /**
     * {@inheritDoc}
     */
    public function getMotorMake()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMotorMake', []);

        return parent::getMotorMake();
    }

    /**
     * {@inheritDoc}
     */
    public function getMotorType()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMotorType', []);

        return parent::getMotorType();
    }

    /**
     * {@inheritDoc}
     */
    public function getMotorColor()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMotorColor', []);

        return parent::getMotorColor();
    }

    /**
     * {@inheritDoc}
     */
    public function getAverageRentPrice()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getAverageRentPrice', []);

        return parent::getAverageRentPrice();
    }

    /**
     * {@inheritDoc}
     */
    public function getMotorTransmission()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMotorTransmission', []);

        return parent::getMotorTransmission();
    }

    /**
     * {@inheritDoc}
     */
    public function getDoors()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDoors', []);

        return parent::getDoors();
    }

    /**
     * {@inheritDoc}
     */
    public function getFuel()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getFuel', []);

        return parent::getFuel();
    }

    /**
     * {@inheritDoc}
     */
    public function getMotorName()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMotorName', []);

        return parent::getMotorName();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsAirBag()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsAirBag', []);

        return parent::getIsAirBag();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsAbs()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsAbs', []);

        return parent::getIsAbs();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsGps()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsGps', []);

        return parent::getIsGps();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsInsurance()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsInsurance', []);

        return parent::getIsInsurance();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsMusic()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsMusic', []);

        return parent::getIsMusic();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsCarkit()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsCarkit', []);

        return parent::getIsCarkit();
    }

    /**
     * {@inheritDoc}
     */
    public function getIsBluetooth()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getIsBluetooth', []);

        return parent::getIsBluetooth();
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
    public function getUpdatedOn()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUpdatedOn', []);

        return parent::getUpdatedOn();
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
    public function setDescription($description)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescription', [$description]);

        return parent::setDescription($description);
    }

    /**
     * {@inheritDoc}
     */
    public function setMotorMake($motorMake)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMotorMake', [$motorMake]);

        return parent::setMotorMake($motorMake);
    }

    /**
     * {@inheritDoc}
     */
    public function setMotorType($motorType)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMotorType', [$motorType]);

        return parent::setMotorType($motorType);
    }

    /**
     * {@inheritDoc}
     */
    public function setMotorColor($motorColor)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMotorColor', [$motorColor]);

        return parent::setMotorColor($motorColor);
    }

    /**
     * {@inheritDoc}
     */
    public function setAverageRentPrice($averageRentPrice)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setAverageRentPrice', [$averageRentPrice]);

        return parent::setAverageRentPrice($averageRentPrice);
    }

    /**
     * {@inheritDoc}
     */
    public function setMotorTransmission($motorTransmission)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMotorTransmission', [$motorTransmission]);

        return parent::setMotorTransmission($motorTransmission);
    }

    /**
     * {@inheritDoc}
     */
    public function setDoors($doors)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDoors', [$doors]);

        return parent::setDoors($doors);
    }

    /**
     * {@inheritDoc}
     */
    public function setFuel($fuel)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setFuel', [$fuel]);

        return parent::setFuel($fuel);
    }

    /**
     * {@inheritDoc}
     */
    public function setMotorName($motorName)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMotorName', [$motorName]);

        return parent::setMotorName($motorName);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsAirBag($isAirBag)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsAirBag', [$isAirBag]);

        return parent::setIsAirBag($isAirBag);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsAbs($isAbs)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsAbs', [$isAbs]);

        return parent::setIsAbs($isAbs);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsGps($isGps)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsGps', [$isGps]);

        return parent::setIsGps($isGps);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsInsurance($isInsurance)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsInsurance', [$isInsurance]);

        return parent::setIsInsurance($isInsurance);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsMusic($isMusic)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsMusic', [$isMusic]);

        return parent::setIsMusic($isMusic);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsCarkit($isCarkit)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsCarkit', [$isCarkit]);

        return parent::setIsCarkit($isCarkit);
    }

    /**
     * {@inheritDoc}
     */
    public function setIsBluetooth($isBluetooth)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setIsBluetooth', [$isBluetooth]);

        return parent::setIsBluetooth($isBluetooth);
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
    public function setUpdatedOn($updatedOn)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUpdatedOn', [$updatedOn]);

        return parent::setUpdatedOn($updatedOn);
    }

    /**
     * {@inheritDoc}
     */
    public function getPlatNumber()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getPlatNumber', []);

        return parent::getPlatNumber();
    }

    /**
     * {@inheritDoc}
     */
    public function getMotorClass()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getMotorClass', []);

        return parent::getMotorClass();
    }

    /**
     * {@inheritDoc}
     */
    public function setPlatNumber($platNumber)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setPlatNumber', [$platNumber]);

        return parent::setPlatNumber($platNumber);
    }

    /**
     * {@inheritDoc}
     */
    public function setMotorClass($motorClass)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setMotorClass', [$motorClass]);

        return parent::setMotorClass($motorClass);
    }

}
