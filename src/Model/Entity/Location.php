<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 */
//use Cake\Auth\DefaultPasswordHasher;
//use Cake\ORM\Entity;

class Location extends Entity
{


    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected array $_accessible = [
        'location' => true,
        'extension' => true,
        'user_id' => true,
        'memo' => true,
        'created' => true,
        'created_user_id' => true,
        'updated' => true,
        'updated_user_id' => true,
        'deleted' => true,
        'deleted_user_id' => true,
        'created_user' => true,
        'updated_user' => true,
        'deleted_user' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    //protected $_hidden = [
    //    'password'
    //];

    /**
     * パスワードのhashを保存する
     */
    /*protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher)->hash($password);
        }
    }*/
}
