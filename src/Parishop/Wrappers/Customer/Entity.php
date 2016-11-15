<?php
namespace Parishop\Wrappers\Customer;

/**
 * Class Entity
 * @package Parishop\Wrappers\Customer
 * @since   1.0
 */
class Entity extends \Parishop\Wrappers\Entity
{
    /**
     * @return string
     * @since 1.0
     */
    public function passwordHash()
    {
        return $this->getField('passwordHash');
    }

}

