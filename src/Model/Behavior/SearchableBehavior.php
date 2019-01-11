<?php

namespace Skeleton\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\ElasticSearch\IndexRegistry;
use Cake\Event\Event;
use Cake\ORM\Behavior;

/**
 * Searchable behavior
 */
class SearchableBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * @var IndexRegistry
     */
    protected $index;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->index = IndexRegistry::get($this->_table->getAlias());
    }

    public function afterSave(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        $this->index->save($entity, (array)$options);
    }

    public function afterDelete(Event $event, EntityInterface $entity, \ArrayObject $options)
    {
        $this->index->delete($entity, (array)$options);
    }
}
