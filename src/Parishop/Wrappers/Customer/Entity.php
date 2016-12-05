<?php
namespace Parishop\Wrappers\Customer;

/**
 * Class Entity
 * @package Parishop\Wrappers\Customer
 * @since   1.0
 */
class Entity extends \Parishop\ORMWrappers\Entity implements \PHPixie\AuthLogin\Repository\User
{
    /**
     * @return string
     * @since 1.0.5
     */
    public function email()
    {
        return $this->getField('email');
    }

    /**
     * @return string
     * @since 1.0
     */
    public function passwordHash()
    {
        return $this->getField('passwordHash');
    }

    /**
     * @param bool $resetPassword
     * @return string
     * @since 1.0.5
     */
    public function resetPassword($resetPassword = false)
    {
        if($resetPassword !== false) {
            $this->setField('resetPassword', $resetPassword);
            $this->save();
        }

        return $this->getField('resetPassword');
    }

}

