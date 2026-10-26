<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FleetListsFixture
 *
 */
class FleetListsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID', 'autoIncrement' => true, 'precision' => null],
        'vessel_type' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'VESSEL TYPE', 'precision' => null, 'autoIncrement' => null],
        'vessel_name' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'VESSEL NAME', 'precision' => null, 'fixed' => null],
        'flag' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'FLAG', 'precision' => null, 'fixed' => null],
        'imo_number' => ['type' => 'string', 'length' => 30, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'IMO NUMBER', 'precision' => null, 'fixed' => null],
        'classification' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'CLASSFICATION', 'precision' => null, 'fixed' => null],
        'call_sign' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'CALL_SIGN', 'precision' => null, 'fixed' => null],
        'builder' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'BUILDER', 'precision' => null, 'fixed' => null],
        'built_date' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'BUILT DATE', 'precision' => null],
        'management_change' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => 'MANAGEMENT CHANGE', 'precision' => null],
        'dead_weight' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'DEAD WEIGHT', 'precision' => null, 'fixed' => null],
        'gross_tonage' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'GROSS TONAGE', 'precision' => null, 'fixed' => null],
        'main_engine' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'MAIN ENGINE', 'precision' => null, 'fixed' => null],
        'ecdis_type' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'EDCIS TYPE', 'precision' => null, 'fixed' => null],
        'msc' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'MSC', 'precision' => null, 'fixed' => null],
        'tsc' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'TSC', 'precision' => null, 'fixed' => null],
        'operation' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'OPERATION', 'precision' => null, 'fixed' => null],
        'assistant' => ['type' => 'string', 'length' => 255, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'ASSISTANT', 'precision' => null, 'fixed' => null],
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
    public $records = [
        [
            'id' => 1,
            'vessel_type' => 1,
            'vessel_name' => 'Lorem ipsum dolor sit amet',
            'flag' => 'Lorem ipsum dolor sit amet',
            'imo_number' => 'Lorem ipsum dolor sit amet',
            'classification' => 'Lorem ipsum dolor sit amet',
            'call_sign' => 'Lorem ipsum dolor sit amet',
            'builder' => 'Lorem ipsum dolor sit amet',
            'built_date' => '2018-04-09 05:51:52',
            'management_change' => '2018-04-09 05:51:52',
            'dead_weight' => 'Lorem ipsum dolor sit amet',
            'gross_tonage' => 'Lorem ipsum dolor sit amet',
            'main_engine' => 'Lorem ipsum dolor sit amet',
            'ecdis_type' => 'Lorem ipsum dolor sit amet',
            'msc' => 'Lorem ipsum dolor sit amet',
            'tsc' => 'Lorem ipsum dolor sit amet',
            'operation' => 'Lorem ipsum dolor sit amet',
            'assistant' => 'Lorem ipsum dolor sit amet',
            'remark' => 'Lorem ipsum dolor sit amet',
            'created' => '2018-04-09 05:51:52',
            'created_user_id' => 1,
            'updated' => '2018-04-09 05:51:52',
            'updated_user_id' => 1,
            'deleted' => '2018-04-09 05:51:52',
            'deleted_user_id' => 1
        ],
    ];
}
