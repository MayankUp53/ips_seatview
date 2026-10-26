<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CrewListsFixture
 *
 */
class CrewListsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID', 'autoIncrement' => true, 'precision' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '名前', 'precision' => null, 'fixed' => null],
        'rank' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'RANK', 'precision' => null, 'fixed' => null],
        'sign_on' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'SIGN ON', 'precision' => null],
        'vessel' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'VESSEL', 'precision' => null, 'fixed' => null],
        'remark' => ['type' => 'string', 'length' => 200, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '備考', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '登録日時', 'precision' => null],
        'created_user_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '登録者', 'precision' => null, 'autoIncrement' => null],
        'updated' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '更新日時', 'precision' => null],
        'updated_user_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '更新者', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '削除日時', 'precision' => null],
        'deleted_user_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '削除者', 'precision' => null, 'autoIncrement' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'MyISAM',
            'collation' => 'utf8_bin'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public array $records = [
        [
            'id' => 1,
            'name' => 'Lorem ipsum dolor sit amet',
            'rank' => 'Lorem ipsum dolor sit amet',
            'sign_on' => '2018-04-09 05:51:40',
            'vessel' => 'Lorem ipsum dolor sit amet',
            'remark' => 'Lorem ipsum dolor sit amet',
            'created' => '2018-04-09 05:51:40',
            'created_user_id' => 1,
            'updated' => '2018-04-09 05:51:40',
            'updated_user_id' => 1,
            'deleted' => '2018-04-09 05:51:40',
            'deleted_user_id' => 1
        ],
    ];
}
