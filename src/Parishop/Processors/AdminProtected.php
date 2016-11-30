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
            if(strtolower($value->server()->get('HTTP_X_REQUESTED_WITH') !== 'xmlhttprequest')) {
                $this->getTemplate(null, $value);
                $this->container->set('user', $this->user());
            }
            $result = parent::process($value);

            return $result ? $result : $this->container;
        }

        return $this->getTemplate($value->attributes()->get('bundle', 'admin') . ':auth/login');
    }

}

