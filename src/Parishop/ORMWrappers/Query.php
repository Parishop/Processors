<?php
namespace Parishop\ORMWrappers;

/**
 * Class Query
 * @method \PHPixie\ORM\Loaders\Loader\Proxy\Caching|Entity[] find($preload = array(), $fields = null)
 * @method Entity findOne($preload = array(), $fields = null)
 * @package Parishop\ORMWrappers
 * @since   1.0
 */
class Query extends \PHPixie\ORM\Wrappers\Type\Database\Query
{
    /**
     * @var \PHPixie\DefaultBundle\Builder
     * @since 1.0
     */
    private $bundleBuilder;

    /**
     * @param \PHPixie\ORM\Drivers\Driver\PDO\Query $query
     * @param \PHPixie\DefaultBundle\Builder        $bundleBuilder
     * @since 1.0
     */
    public function __construct($query, $bundleBuilder)
    {
        parent::__construct($query);
        $this->bundleBuilder = $bundleBuilder;
    }

}

