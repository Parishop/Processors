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
     * @param \PHPixie\Social\OAuth\User $socialUser
     * @return Entity
     * @throws \Exception
     * @since 1.0.5
     */
    public function createSocialUser($socialUser)
    {
        /** @var \stdClass $loginData */
        $loginData = $socialUser->loginData();
        switch($socialUser->providerName()) {
            case 'vk':
            case 'facebook';
                if($customer = $this->getByLogin($loginData->email)) {
                    $customer->setField($socialUser->providerName() . 'Id', $socialUser->id());
                } else {
                    $customer = $this->create(
                        [
                            $socialUser->providerName() . 'Id' => $socialUser->id(),
                            'firstname'                        => $loginData->first_name,
                            'lastname'                         => $loginData->last_name,
                            'email'                            => $loginData->email,
                        ]
                    );
                    $customer->save();

                    return $customer;
                }
                break;
            case 'google';
                $email = null;
                foreach($loginData->emails as $email) {
                    if($customer = $this->getByLogin($email)) {
                        $customer->setField($socialUser->providerName() . 'Id', $socialUser->id());
                    } else {
                        $customer = $this->create(
                            [
                                'googleId'  => $socialUser->id(),
                                'firstname' => $loginData->name->familyName,
                                'lastname'  => $loginData->name->givenName,
                                'email'     => $email,
                            ]
                        );
                    }
                    $customer->save();

                    return $customer;
                    break;
                }
                break;
            default:
                throw new \Exception('Неизвестный провайдер ' . $socialUser->providerName());
                break;
        }

        return null;
    }

    /**
     * @param mixed $id
     * @return Entity
     * @since 1.0.4
     */
    public function getById($id)
    {
        return $this->query()->in($id)->findOne();
    }

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
     * @param \PHPixie\Social\OAuth\User $socialUser
     * @return \Parishop\ORMWrappers\Entity
     * @since 1.0.5
     */
    public function getBySocialUser($socialUser)
    {
        return $this->query()->where($socialUser->providerName() . 'Id', $socialUser->id())->findOne();
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

