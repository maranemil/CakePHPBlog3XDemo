<?php

namespace App\Model\Table;

use App\Model\Entity\Article;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Behavior\TimestampBehavior;
#use Cake\ORM\Query;
#use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Articles Model
 * @method Article get($primaryKey, $options = [])
 * @method Article newEntity($data = null, array $options = [])
 * @method Article[] newEntities(array $data, array $options = [])
 * @method Article|bool save(EntityInterface $entity, $options = [])
 * @method Article|bool saveOrFail(EntityInterface $entity, $options = [])
 * @method Article patchEntity(EntityInterface $entity, array $data, array $options = [])
 * @method Article[] patchEntities($entities, array $data, array $options = [])
 * @method Article findOrCreate($search, callable $callback = null, $options = [])
 * @mixin TimestampBehavior
 */
class ArticlesTable extends Table {

   /**
	* Initialize method
	*
	* @param array $config The configuration for the Table.
	*
	* @return void
	*/
   public function initialize(array $config) {
	  parent::initialize($config);

	  $this->setTable('articles');
	  $this->setDisplayField('title');
	  $this->setPrimaryKey('id');

	  $this->addBehavior('Timestamp');
   }

   /**
	* Default validation rules.
	*
	* @param Validator $validator Validator instance.
	*
	* @return Validator
	*/
   public function validationDefault(Validator $validator) {
	  $validator
		  ->integer('id')
		  ->allowEmpty('id', 'create');

	  $validator
		  ->scalar('title')
		  ->maxLength('title', 50)
		  ->allowEmpty('title');

	  $validator
		  ->scalar('body')
		  ->allowEmpty('body');

	  return $validator;
   }

   public function isOwnedBy($articleId, $userId) {
	  return $this->exists(['id' => $articleId, 'user_id' => $userId]);
   }

   /* public function validationDefault(Validator $validator)
   {
	   $validator
		   ->notEmpty('title')
		   ->requirePresence('title')
		   ->notEmpty('body')
		   ->requirePresence('body');

	   return $validator;
   } */
}
