<?php

namespace DigitalKrikits\Models;

class VenueType extends ModelBase
{

    /**
     *
     * @var integer
     */
    protected $id;

    /**
     *
     * @var string
     */
    protected $name;

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
     * Returns the value of field id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
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
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSource('venueType');
        $this->useDynamicUpdate(true);
    }

    public function validation()
    {
        $validators = [
            [
                'validator' => 'uniqueness',
                'params' => [
                    'field' => 'name',
                    'message' => sprintf('Another type of venue with same the name [%s] already exists.', $this->getName())
                ]
            ]
        ];

        return parent::validator($validators);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'venueType';
    }

}
