<?php

namespace Skeleton\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TimeZones Model
 *
 * @method \Skeleton\Model\Entity\TimeZone get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\TimeZone newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\TimeZone[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\TimeZone|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\TimeZone|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\TimeZone patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\TimeZone[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\TimeZone findOrCreate($search, callable $callback = null, $options = [])
 */
class TimeZonesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('time_zones');
        $this->setDisplayField('identifier');
        $this->setPrimaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->latitude('latitude')
            ->requirePresence('latitude', 'create')
            ->allowEmptyString('latitude', false);

        $validator
            ->longitude('longitude')
            ->requirePresence('longitude', 'create')
            ->allowEmptyString('longitude', false);

        $validator
            ->scalar('identifier')
            ->maxLength('identifier', 50)
            ->requirePresence('identifier', 'create')
            ->allowEmptyString('identifier', false);

        return $validator;
    }
}
