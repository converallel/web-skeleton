<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Logins Model
 *
 * @property \Skeleton\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \Skeleton\Model\Table\DevicesTable|\Cake\ORM\Association\BelongsTo $Devices
 *
 * @method \Skeleton\Model\Entity\Login get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\Login newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\Login[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Login|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\Login|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\Login patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Login[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Login findOrCreate($search, callable $callback = null, $options = [])
 */
class LoginsTable extends Table
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

        $this->setTable('logins');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Devices', [
            'foreignKey' => 'device_id'
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
            ->ip('ip_address')
            ->requirePresence('ip_address', 'create')
            ->allowEmptyString('ip_address', false);

        $validator
            ->scalar('browser')
            ->maxLength('browser', 255)
            ->allowEmptyString('browser');

        $validator
            ->latitude('latitude')
            ->allowEmptyString('latitude');

        $validator
            ->longitude('longitude')
            ->allowEmptyString('longitude');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['device_id'], 'Devices'));

        return $rules;
    }
}
