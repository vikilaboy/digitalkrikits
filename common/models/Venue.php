<?php

namespace DigitalKrikits\Models;

class Venue extends ModelBase
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var integer
     */
    protected $idVenueType;

    /**
     *
     * @var string
     */
    protected $name;

    /**
     *
     * @var string
     */
    protected $address;

    /**
     *
     * @var string
     */
    protected $dateAdd;

    /**
     * Method to set the value of field id
     *
     * @param integer $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Method to set the value of field idVenueType
     *
     * @param integer $idVenueType
     * @return $this
     */
    public function setIdvenuetype($idVenueType)
    {
        $this->idVenueType = $idVenueType;

        return $this;
    }

    /**
     * Method to set the value of field name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Method to set the value of field address
     *
     * @param string $address
     * @return $this
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Method to set the value of field dateAdd
     *
     * @param string $dateAdd
     * @return $this
     */
    public function setDateadd($dateAdd)
    {
        $this->dateAdd = $dateAdd;

        return $this;
    }

    /**
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the value of field idVenueType
     *
     * @return integer
     */
    public function getIdvenuetype()
    {
        return $this->idVenueType;
    }

    /**
     * Returns the value of field name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the value of field address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Returns the value of field dateAdd
     *
     * @return string
     */
    public function getDateadd()
    {
        return $this->dateAdd;
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'venue';
    }

    /**
     * hook beforeValidationOnCreate
     *
     */
    public function beforeValidationOnCreate()
    {
        $this->dateAdd = date('Y-m-d H:i:s');
    }

    public function initialize()
    {
        $this->setSource('venue');
        $this->useDynamicUpdate(true);

        $this->hasOne('idVenueType', __NAMESPACE__ . '\VenueType', 'id', ['reusable' => true, 'alias' => 'venueType']);
    }

    public function validation()
    {
        $validators = [
            [
                'validator' => 'uniqueness',
                'params' => [
                    'field' => ['name', 'idVenueType'],
                    'message' => sprintf('Another venue with same the name [%s] already exists.', $this->getName())
                ]
            ]
        ];

        return parent::validator($validators);
    }
}
