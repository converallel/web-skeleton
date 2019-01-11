<?php

namespace Skeleton\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contacts Model
 *
 * @property \Skeleton\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 *
 * @method \Skeleton\Model\Entity\Contact get($primaryKey, $options = [])
 * @method \Skeleton\Model\Entity\Contact newEntity($data = null, array $options = [])
 * @method \Skeleton\Model\Entity\Contact[] newEntities(array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Contact|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\Contact|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Skeleton\Model\Entity\Contact patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Contact[] patchEntities($entities, array $data, array $options = [])
 * @method \Skeleton\Model\Entity\Contact findOrCreate($search, callable $callback = null, $options = [])
 */
class ContactsTable extends Table
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

        $this->setTable('contacts');
        $this->setDisplayField('contact');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
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
            ->scalar('type')
            ->requirePresence('type', 'create')
            ->notEmpty('type');

        $validator
            ->scalar('contact')
            ->maxLength('contact', 60)
            ->requirePresence('contact', 'create')
            ->notEmpty('contact')
            ->add('contact', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

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
        $rules->add($rules->isUnique(['contact']));
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }
}
