<?php
namespace Parishop\Processors;

/**
 * Class AdminList
 * @package Parishop\Processors
 * @since   1.0.4
 */
abstract class AdminList extends AdminProtected
{
    /**
     * @var string
     * @since 1.0.4
     */
    protected $modelName;

    /**
     * @var \Parishop\ORMWrappers\Query
     * @since 1.0.4
     */
    protected $query;

    /**
     * @var \PHPixie\Slice\Type\ArrayData\Editable
     * @since 1.0.4
     */
    protected $data;

    /**
     * Processor constructor.
     * @param \PHPixie\DefaultBundle\Builder $builder
     * @since 1.0.4
     */
    public function __construct(\PHPixie\DefaultBundle\Builder $builder)
    {
        parent::__construct($builder);
        $reflectionClass = new \ReflectionClass(get_class($this));
        $shortName       = $reflectionClass->getShortName();
        $this->modelName = lcfirst($this->orm()->builder()->configs()->inflector()->singular($shortName));
        $this->data      = $this->slice()->editableArrayData($this->session()->get($this->modelName));
    }

    /**
     * @param \PHPixie\HTTP\Request $request
     * @return \PHPixie\Template\Container
     * @throws \PHPixie\Paginate\Exception
     * @since 1.0.4
     */
    public function defaultAction(\PHPixie\HTTP\Request $request)
    {
        $post = $request->data()->get(null, []);
        $get  = $request->query()->get(null, []);
        $this->bind(array_merge($this->data->get(), $post, $get));
        $this->search($this->get('filter.search'));
        $this->filter();
        $this->sorting();

        $paginate = $this->builder->components()->paginateOrm();
        /** @var \PHPixie\Paginate\Pager $pager */
        $pager = $paginate->queryPager($this->query(), $this->get('list.limit', $this->builder->config()->get('settings.pageCount', 20)));
        if($page = $request->query()->get('pageId')) {
            $pager->setCurrentPage($page);
        }

        $this->container->set('pager', $pager);
        $this->container->set('filterActive', $this->data()->arraySlice('filter'));

        return $this->container;
    }

    /**
     * @param array $data
     * @since 1.0.4
     */
    protected function bind(array $data = [])
    {
        $this->session()->set($this->modelName, $data);
        $this->data = $this->slice()->editableArrayData($data);
    }

    /**
     * @return \PHPixie\Slice\Type\ArrayData\Editable
     * @since 1.0.4
     */
    protected function data()
    {
        return $this->data;
    }

    /**
     * @since 1.0.4
     */
    protected function filter()
    {
        /** @var \Parishop\ORMWrappers\Repository $repository */
        $repository = $this->orm()->repository($this->query()->modelName());
        foreach($this->get('filter', []) as $fieldName => $value) {
            if($repository->fields()->exists($fieldName)) {
                $this->query()->where($fieldName, $value);
            }
        }
    }

    /**
     * @param string $key
     * @param mixed  $default
     * @return mixed
     * @since 1.0.4
     */
    protected function get($key, $default = null)
    {
        return $this->data->get($key, $default);
    }

    /**
     * @param string $id
     * @return string
     * @since 1.0.4
     */
    protected function id($id = '')
    {
        $id .= ':' . $this->get('list.start');
        $id .= ':' . $this->get('list.limit');
        $id .= ':' . $this->get('list.ordering');
        $id .= ':' . $this->get('list.direction');

        return md5($id);
    }

    /**
     * @return \Parishop\ORMWrappers\Query
     * @since 1.0.4
     */
    protected function query()
    {
        if($this->query === null) {
            $this->query = $this->getQuery();
        }

        return $this->query;
    }

    /**
     * @param string $string
     * @since 1.0.4
     */
    protected function search($string)
    {
        if(substr($string, 0, 3) === 'id:') {
            $this->query()->where('id', substr($string, 3, strlen($string) - 3));
        }
    }

    /**
     * @since 1.0.4
     */
    protected function sorting()
    {
        try {
            if($ordering = $this->get('list.ordering')) {
                list($fieldName, $direction) = explode('.', $ordering, 2);
                /** @var \Parishop\ORMWrappers\Repository $repository */
                $repository = $this->orm()->repository($this->query()->modelName());
                if($repository->fields()->exists($fieldName)) {
                    switch(strtolower($direction)) {
                        case 'asc':
                            $this->query()->orderAscendingBy($fieldName);
                            break;
                        case 'desc':
                            $this->query()->orderDescendingBy($fieldName);
                            break;
                    }
                }
            }
        } catch(\Exception $e) {

        }
    }

    /**
     * @return \Parishop\ORMWrappers\Query
     * @since 1.0.4
     */
    public abstract function getQuery(): \Parishop\ORMWrappers\Query;

}

