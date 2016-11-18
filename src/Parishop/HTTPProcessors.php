<?php
namespace Parishop;

/**
 * Class HTTPProcessors
 * @package Parishop
 * @since   1.0.1
 */
class HTTPProcessors extends \PHPixie\DefaultBundle\Processor\HTTP\Builder
{
    /**
     * @var \PHPixie\DefaultBundle\Builder
     * @since 1.0.1
     */
    protected $builder;

    /**
     * HTTPProcessors constructor.
     * @param \PHPixie\DefaultBundle\Builder $builder
     * @since 1.0.1
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * @param $name
     * @return Processors\AppProcessor
     * @since 1.0.1
     */
    public function processor($name)
    {
        if(!array_key_exists($name, $this->processors)) {
            $class = __NAMESPACE__ . '\\HTTPProcessors\\' . ucfirst($name);
            if(!class_exists($class)) {
                return parent::processor($name);
            }
            $this->processors[$name] = new $class($this->builder);
        }

        return $this->processors[$name];
    }

}

