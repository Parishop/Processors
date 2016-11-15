<?php
namespace Parishop\Wrappers;

/**
 * Class Entity
 * @package Parishop\Wrappers
 * @since   1.0
 */
class Entity extends \PHPixie\ORM\Wrappers\Type\Database\Entity
{
    /**
     * @type \PHPixie\DefaultBundle\Builder
     * @since 1.0
     */
    protected $builder;

    /**
     * @param                                $entity
     * @param \PHPixie\DefaultBundle\Builder $builder
     * @since 1.0
     */
    public function __construct($entity, $builder)
    {
        parent::__construct($entity);
        $this->builder = $builder;
    }

    /**
     * @return \PHPixie\HTTP\Messages\URI
     * @since 1.0
     */
    public function url()
    {
        $inflector  = $this->builder->components()->orm()->builder()->configs()->inflector();
        $http       = $this->builder->frameworkBuilder()->http();
        $attributes = [
            'processor' => $inflector->plural($this->modelName()),
            'action'    => 'view',
            'id'        => $this->id(),
        ];

        return $http->generateUri($this->builder->bundleName() . '.id', $attributes);
    }

}
