<?php
namespace Parishop\Wrappers\Customer;

/**
 * Class Repository
 * @package Parishop\Wrappers\Customer
 * @since   1.0
 */
class Repository extends \Parishop\ORMWrappers\Repository
{
    /**
     * @param string $login
     * @return Entity
     * @since 1.0
     */
    public function getByLogin($login)
    {
        $query = $this->query();
        foreach($this->loginFields() as $field) {
            $query->orWhere($field, $login);
        }

        return $query->findOne();
    }

    /**
     * @return array
     * @since 1.0
     */
    protected function loginFields()
    {
        return array('email');
    }

}

