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
            $result = parent::process($value);
            if($this->container instanceof \PHPixie\Template\Container) {
                $this->container->set('customer', $this->customer());
            }

            return $result ? $result : $this->container;
        }

        return $this->getTemplate($value->attributes()->get('bundle', 'app') . ':auth/login');
    }

}

