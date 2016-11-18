<?php
namespace Parishop\Processors;

/**
 * Class Processor
 * @package Parishop\Processors
 * @since   1.0
 */
class Processor extends \PHPixie\DefaultBundle\Processor\HTTP\Actions
{
    /**
     * @type \PHPixie\DefaultBundle\Builder
     * @since 1.0
     */
    protected $builder;

    /**
     * Processor constructor.
     * @param \PHPixie\DefaultBundle\Builder $builder
     * @since 1.0
     */
    public function __construct(\PHPixie\DefaultBundle\Builder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * @return \Parishop\Wrappers\Customer\Entity
     * @since 1.0
     */
    protected function customer()
    {
        return $this->domain('customer')->user();
    }

    /**
     * @return \PHPixie\Database
     * @since 1.0
     */
    protected function database()
    {
        return $this->builder->components()->database();
    }

    /**
     * @param string $name
     * @return \PHPixie\Auth\Domains\Domain
     * @since 1.0
     */
    protected function domain($name = 'default')
    {
        return $this->builder->components()->auth()->domain($name);
    }

    /**
     * @return \PHPixie\ORM
     * @since 1.0
     */
    protected function orm()
    {
        return $this->builder->components()->orm();
    }

    /**
     * @param \PHPixie\HTTP\Messages\URI|string $url
     * @param int                               $statusCode
     * @return \PHPixie\HTTP\Responses\Response
     * @since 1.0
     */
    protected function redirect($url, $statusCode = 302)
    {
        return $this->builder->components()->http()->responses()->redirect((string)$url, $statusCode);
    }

    /**
     * @return \PHPixie\Route\Translator
     * @since 1.0
     */
    protected function routeTranslator()
    {
        return $this->builder->frameworkBuilder()->http()->routeTranslator();
    }

    /**
     * @return \PHPixie\Template
     * @since 1.0
     */
    protected function template()
    {
        return $this->builder->components()->template();
    }

    /**
     * @return \PHPixie\Template\Extensions
     * @since 1.0
     */
    protected function templateExtensions()
    {
        return $this->template()->builder()->extensions();
    }

    /**
     * @return \Parishop\Wrappers\User\Entity
     * @since 1.0
     */
    protected function user()
    {
        return $this->domain('default')->user();
    }

}

