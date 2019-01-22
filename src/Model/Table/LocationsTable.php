<?php

namespace Skeleton\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 *
 * @property \Skeleton\Model\Table\UsersTable|\Cake\ORM\Association\HasMany $Users
 *
 * @method \Skeleton\Model\Entity\Location get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\Location newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\Location[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Location|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\Location|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Location[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Location findOrCreate($search, callable $callback = null, $options = [])
 */
class LocationsTable extends Table
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

        $this->setTable('locations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Users', [
            'foreignKey' => 'location_id'
        ]);
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
            ->scalar('name')
            ->maxLength('name', 45)
            ->allowEmptyString('name');

        $validator
            ->scalar('iso_country_code')
            ->maxLength('iso_country_code', 30)
            ->allowEmptyString('iso_country_code');

        $validator
            ->scalar('country')
            ->maxLength('country', 45)
            ->allowEmptyString('country');

        $validator
            ->scalar('postal_code')
            ->maxLength('postal_code', 20)
            ->allowEmptyString('postal_code');

        $validator
            ->scalar('administrative_area')
            ->maxLength('administrative_area', 45)
            ->allowEmptyString('administrative_area');

        $validator
            ->scalar('sub_administrative_area')
            ->maxLength('sub_administrative_area', 45)
            ->allowEmptyString('sub_administrative_area');

        $validator
            ->scalar('locality')
            ->maxLength('locality', 45)
            ->allowEmptyString('locality');

        $validator
            ->scalar('sub_locality')
            ->maxLength('sub_locality', 45)
            ->allowEmptyString('sub_locality');

        $validator
            ->scalar('thoroughfare')
            ->maxLength('thoroughfare', 45)
            ->allowEmptyString('thoroughfare');

        $validator
            ->scalar('sub_thoroughfare')
            ->maxLength('sub_thoroughfare', 45)
            ->allowEmptyString('sub_thoroughfare');

        $validator
            ->scalar('time_zone')
            ->maxLength('time_zone', 50)
            ->allowEmptyString('time_zone');

        return $validator;
    }
}
