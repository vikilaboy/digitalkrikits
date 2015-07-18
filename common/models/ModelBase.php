<?php

namespace DigitalKrikits\Models;

use Phalcon\DI\FactoryDefault;
use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple as Resultset;

/**
 * Class ModelBase
 *
 * @package DigitalKrikits\Models
 */
class ModelBase extends Model
{
    /**
     * @return mixed
     */
    protected static function getBuilder()
    {
        $di = FactoryDefault::getDefault();

        return $di->get('modelsManager')->createBuilder();
    }

    protected function getDb()
    {
        return $this->getDI()->get('db');
    }

    protected static function getConnection()
    {
        $di = FactoryDefault::getDefault();

        return $di->get('db');
    }

    /**
     * @param array $attributes
     *
     * @return bool
     * @throws \Exception
     */
    protected function validator(array $attributes = [])
    {
        if (empty($attributes)) {
            return false;
        }

        foreach ($attributes as $attribute) {

            $validator = null;

            if (class_exists('Phalcon\Mvc\Model\Validator\\' . $attribute['validator'])) {
                $validator = 'Phalcon\Mvc\Model\Validator\\' . $attribute['validator'];
            } elseif (class_exists(PROJECT_BASE_NAMESPACE . '\Validators\\' . $attribute['validator'])) {
                $validator = PROJECT_BASE_NAMESPACE . '\Validators\\' . $attribute['validator'];
            } else {
                throw new \Exception('Validator '. $attribute['validator']. ' does not exist.');
            }

            $this->validate(new $validator($attribute['params']));
        }

        if ($this->validationHasFailed() == true) {
            return false;
        }

        return true;
    }
}
