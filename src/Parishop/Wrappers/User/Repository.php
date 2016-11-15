<?php
namespace Parishop\Wrappers\User;

/**
 * Class Repository
 * @package Parishop\Wrappers\User
 * @since   1.0
 */
class Repository extends \Parishop\Wrappers\Repository
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
        return array('username');
    }

}

