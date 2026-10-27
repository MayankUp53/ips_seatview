<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class LocationsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('locations');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        /*$this->belongsTo('CreatedUsers', [
            'foreignKey' => 'created_user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UpdatedUsers', [
            'foreignKey' => 'updated_user_id'
        ]);
        $this->belongsTo('DeletedUsers', [
            'foreignKey' => 'deleted_user_id'
        ]);*/

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): \Cake\Validation\Validator
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        /*$validator
            ->scalar('disp_cd')
            ->maxLength('disp_cd', 20)
            ->requirePresence('disp_cd', 'create')
            ->notEmpty('disp_cd');*/

        $validator
            ->scalar('location')
            ->maxLength('location', 100)
            ->requirePresence('location', 'create')
            ->notEmpty('location');

        $validator
            ->scalar('user_id')
            ->maxLength('user_id', 100)
            ->requirePresence('user_id', 'create')
            ->allowEmpty('user_id');

        /*$validator
            ->integer('auth')
            ->allowEmpty('auth');

        $validator
            ->scalar('loginid')
            ->maxLength('loginid', 100)
            ->allowEmpty('loginid');

        $validator
            ->scalar('password')
            ->maxLength('password', 20)
            ->allowEmpty('password');*/

        /*$validator
            ->scalar('remark1')
            ->maxLength('remark1', 200)
            ->allowEmpty('remark1');

        $validator
            ->scalar('remark2')
            ->maxLength('remark2', 200)
            ->allowEmpty('remark2');

        $validator
            ->scalar('remark3')
            ->maxLength('remark3', 200)
            ->allowEmpty('remark3');*/

        $validator
            ->dateTime('deleted')
            ->allowEmpty('deleted');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): \Cake\ORM\RulesChecker
    {
        //$rules->add($rules->existsIn(['created_user_id'], 'CreatedUsers'));
        //$rules->add($rules->existsIn(['updated_user_id'], 'UpdatedUsers'));
        //$rules->add($rules->existsIn(['deleted_user_id'], 'DeletedUsers'));

        return $rules;
    }
}
