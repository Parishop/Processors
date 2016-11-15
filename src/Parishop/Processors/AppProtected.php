<?php
namespace Parishop\Processors;

/**
 * Class AppProtected
 * @package Parishop\Processors
 * @since   1.0
 */
class AppProtected extends AppProcessor
{
    /**
     * @param \PHPixie\HTTP\Request $value
     * @return \PHPixie\Template\Container
     * @throws \PHPixie\Processors\Exception
     * @since 1.0
     */
    public function process($value)
    {
        if($this->customer()) {
            return parent::process($value);
        }

        return $this->container('app:auth/login', $value);
    }

}

