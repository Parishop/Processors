<?php
namespace Parishop\Wrappers\User;

/**
 * Class Entity
 * @package Parishop\Wrappers\User
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

