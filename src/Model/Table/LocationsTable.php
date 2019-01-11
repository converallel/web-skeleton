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

        $this->hasMany('Activities', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('ActivityFilters', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('ActivityItineraries', [
            'foreignKey' => 'location_id'
        ]);
        $this->hasMany('LocationSelectionHistories', [
            'foreignKey' => 'location_id'
        ]);
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
            ->allowEmpty('id', 'create');

        $validator
            ->latitude('latitude')
            ->requirePresence('latitude', 'create')
            ->notEmpty('latitude');

        $validator
            ->longitude('longitude')
            ->requirePresence('longitude', 'create')
            ->notEmpty('longitude');

        $validator
            ->scalar('name')
            ->maxLength('name', 45)
            ->allowEmpty('name');

        $validator
            ->scalar('iso_country_code')
            ->maxLength('iso_country_code', 30)
            ->allowEmpty('iso_country_code');

        $validator
            ->scalar('country')
            ->maxLength('country', 45)
            ->allowEmpty('country');

        $validator
            ->scalar('postal_code')
            ->maxLength('postal_code', 20)
            ->allowEmpty('postal_code');

        $validator
            ->scalar('administrative_area')
            ->maxLength('administrative_area', 45)
            ->allowEmpty('administrative_area');

        $validator
            ->scalar('sub_administrative_area')
            ->maxLength('sub_administrative_area', 45)
            ->allowEmpty('sub_administrative_area');

        $validator
            ->scalar('locality')
            ->maxLength('locality', 45)
            ->allowEmpty('locality');

        $validator
            ->scalar('sub_locality')
            ->maxLength('sub_locality', 45)
            ->allowEmpty('sub_locality');

        $validator
            ->scalar('thoroughfare')
            ->maxLength('thoroughfare', 45)
            ->allowEmpty('thoroughfare');

        $validator
            ->scalar('sub_thoroughfare')
            ->maxLength('sub_thoroughfare', 45)
            ->allowEmpty('sub_thoroughfare');

        $validator
            ->scalar('time_zone')
            ->maxLength('time_zone', 50)
            ->allowEmpty('time_zone');

        return $validator;
    }
}
