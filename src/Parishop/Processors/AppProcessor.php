<?php
namespace Parishop\Processors;

/**
 * Class AppProcessor
 * @package Parishop\Processors
 * @since   1.0
 */
class AppProcessor extends Processor
{
    /**
     * @var \PHPixie\Template\Container
     * @since 1.0
     */
    protected $container;

    /**
     * @var \Parishop\Document
     * @since 1.0
     */
    protected $document;

    /**
     * @var \Parishop\Messages
     * @since 1.0
     */
    protected $messages;

    /**
     * @var \Parishop\Images
     * @since 1.0
     */
    protected $images;

    /**
     * @param string $processor
     * @param string $action
     * @param string $id
     * @param array  $attributes
     * @param string $resolverPath
     * @return string
     * @since 1.0
     */
    public function path($processor, $action = null, $id = null, array $attributes = [], $resolverPath = null)
    {
        if($resolverPath === null) {
            $resolverPath = $this->builder->bundleName() . '.processor';
            if($action !== null) {
                $resolverPath = $this->builder->bundleName() . '.action';
                if($id !== null) {
                    $resolverPath = $this->builder->bundleName() . '.id';
                }
            }
        }
        $attributes['processor'] = $processor;
        $attributes['action']    = $action;
        $attributes['id']        = $id;

        return $this->routeTranslator()->generatePath($resolverPath, $attributes);
    }

    /**
     * @param \PHPixie\HTTP\Request $value
     * @return \PHPixie\Template\Container|\PHPixie\HTTP\Responses\Response
     * @since 1.0
     */
    public function process($value)
    {
        try {
            return parent::process($value);
        } catch(\Exception $e) {
            $frameworkProcessors = $this->builder->frameworkBuilder()->processors();
            $httpConfig          = $this->builder->frameworkBuilder()->configuration()->httpConfig();

            return $frameworkProcessors->httpNotFoundResponse($httpConfig->slice('notFoundResponse'))->process($value);
        }
    }

    /**
     * @param string $processor
     * @param string $action
     * @param string $id
     * @param array  $attributes
     * @param string $resolverPath
     * @return \PHPixie\HTTP\Messages\URI\SAPI
     * @since 1.0
     */
    public function url($processor, $action = null, $id = null, array $attributes = [], $resolverPath = null)
    {
        if($resolverPath === null) {
            $resolverPath = $this->builder->bundleName() . '.processor';
            if($action !== null) {
                $resolverPath = $this->builder->bundleName() . '.action';
                if($id !== null) {
                    $resolverPath = $this->builder->bundleName() . '.id';
                }
            }
        }
        $attributes['processor'] = $processor;
        $attributes['action']    = $action;
        $attributes['id']        = $id;

        return $this->routeTranslator()->generateUri($resolverPath, $attributes);
    }

    /**
     * @param string                $templateName
     * @param \PHPixie\HTTP\Request $request
     * @return \PHPixie\Template\Container
     * @since 1.0
     */
    protected function container($templateName = null, $request = null)
    {
        if($templateName === null && $request !== null) {
            $attributes   = $request->attributes();
            $bundle       = $attributes->get('bundle');
            $processor    = $attributes->get('processor');
            $action       = $attributes->get('action');
            $templateName = $bundle . ':' . $processor . '/' . $action;
        }
        $this->container = $this->template()->get($templateName);

        return $this->container;
    }

    /**
     * @return \Parishop\Document
     * @since 1.0
     */
    protected function document()
    {
        return $this->templateExtensions()->get('document');
    }

    /**
     * @return \Parishop\Images
     * @since 1.0
     */
    protected function images()
    {
        return $this->templateExtensions()->get('images');
    }

    /**
     * @return \Parishop\Messages
     * @since 1.0
     */
    protected function messages()
    {
        return $this->templateExtensions()->get('messages');
    }

}

