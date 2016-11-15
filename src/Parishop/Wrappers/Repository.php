<?php
namespace Parishop\Wrappers;

/**
 * Class Repository
 * @method Entity create($data = null)
 * @method Query query()
 * @method \PHPixie\Slice\Type\ArrayData config()
 * @package Parishop\Wrappers
 * @since   1.0
 */
class Repository extends \PHPixie\ORM\Wrappers\Type\Database\Repository
{
    /**
     * @type \PHPixie\DefaultBundle\Builder
     * @since 1.0
     */
    protected $builder;

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Repository $repository
     * @param \PHPixie\DefaultBundle\Builder             $builder
     * @since 1.0
     */
    public function __construct($repository, $builder)
    {
        parent::__construct($repository);
        $this->builder = $builder;
    }

}

