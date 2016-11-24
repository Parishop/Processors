<?php
namespace Parishop\Processors;

/**
 * Class AdminProtected
 * @package Parishop\Processors
 * @since   1.0
 */
class AdminProtected extends AppProcessor
{
    /**
     * @param \PHPixie\HTTP\Request $value
     * @return \PHPixie\Template\Container
     * @throws \PHPixie\Processors\Exception
     * @since 1.0
     */
    public function process($value)
    {
        if($this->user()) {
            return parent::process($value);
        }

        return $this->container($value->attributes()->get('bundle', 'admin') . ':auth/login');
    }

}

