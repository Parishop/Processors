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
     * @var \Parishop\Mailer
     * @since 1.0.5
     */
    private $mailer;

    /**
     * AppProcessor constructor.
     * @param \PHPixie\DefaultBundle\Builder $builder
     * @since 1.0.5
     */
    public function __construct(\PHPixie\DefaultBundle\Builder $builder)
    {
        parent::__construct($builder);
        $this->document = $this->document();
        $this->messages = $this->messages();
        $this->images   = $this->images();
    }

    /**
     * @return \Parishop\Mailer
     * @since 1.0.5
     */
    public function mailer()
    {
        if($this->mailer === null) {
            $this->mailer = new \Parishop\Mailer($this->builder->components()->template(), $this->builder->frameworkBuilder()->configuration()->config()->arraySlice('mailer'));
        }

        return $this->mailer;
    }

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
        return $this->document->path($processor, $action, $id, $attributes, $resolverPath);
    }

    /**
     * @param \PHPixie\HTTP\Request $value
     * @return \PHPixie\Template\Container|\PHPixie\HTTP\Responses\Response
     * @since 1.0
     */
    public function process($value)
    {
        try {
            if(strtolower($value->server()->get('HTTP_X_REQUESTED_WITH') !== 'xmlhttprequest')) {
                $this->getTemplate(null, $value);
            }
            $result = parent::process($value);

            return $result ? $result : $this->container;
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
    public function url($processor = null, $action = null, $id = null, array $attributes = [], $resolverPath = null)
    {
        return $this->document->url($processor, $action, $id, $attributes, $resolverPath);
    }

    /**
     * @param string                $templateName
     * @param \PHPixie\HTTP\Request $request
     * @return \PHPixie\Template\Container
     * @since 1.0.4
     */
    protected function getTemplate($templateName = null, $request = null)
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
    private function document()
    {
        return $this->templateExtensions()->get('document');
    }

    /**
     * @return \Parishop\Images
     * @since 1.0
     */
    private function images()
    {
        return $this->templateExtensions()->get('images');
    }

    /**
     * @return \Parishop\Messages
     * @since 1.0
     */
    private function messages()
    {
        return $this->templateExtensions()->get('messages');
    }


}

