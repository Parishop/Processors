<?php
namespace Parishop;

/**
 * Class ORMWrappers
 * @package Parishop
 * @since   1.0.1
 */
class ORMWrappers extends \PHPixie\ORM\Wrappers\Implementation
{
    /**
     * @type \PHPixie\DefaultBundle\Builder
     * @since 1.0.1
     */
    protected $builder;

    /**
     * Wrappers constructor.
     * @param \PHPixie\DefaultBundle\Builder $builder
     * @since 1.0.1
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Query $query
     * @return Wrappers\Query
     * @since 1.0.1
     */
    public function databaseQueryWrapper($query)
    {
        $class = __NAMESPACE__ . '\ORMWrappers\\' . ucfirst($query->modelName()) . '\Query';
        if(class_exists($class)) {
            return new $class($query, $this->builder);
        }

        return new ORMWrappers\Query($query, $this->builder);
    }

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Repository $repository
     * @return Wrappers\Repository
     * @since 1.0.1
     */
    public function databaseRepositoryWrapper($repository)
    {
        $class = __NAMESPACE__ . '\ORMWrappers\\' . ucfirst($repository->modelName()) . '\Repository';
        if(class_exists($class)) {
            return new $class($repository, $this->builder);
        }

        return new ORMWrappers\Repository($repository, $this->builder);
    }

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Entity $entity
     * @return Wrappers\Entity
     * @since 1.0.1
     */
    protected function entityWrapper($entity)
    {
        $class = __NAMESPACE__ . '\ORMWrappers\\' . ucfirst($entity->modelName()) . '\Entity';
        if(class_exists($class)) {
            return new $class($entity, $this->builder);
        }

        return new ORMWrappers\Entity($entity, $this->builder);
    }

}

