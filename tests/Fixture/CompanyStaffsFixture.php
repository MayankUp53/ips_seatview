<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompanyStaffsFixture
 *
 */
class CompanyStaffsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'POST ID', 'autoIncrement' => true, 'precision' => null],
        'vessel' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'VESSEL', 'precision' => null, 'fixed' => null],
        'msi' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'MSI', 'precision' => null, 'fixed' => null],
        'tsi' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'TSI', 'precision' => null, 'fixed' => null],
        'ope' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'OPE', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '登録日時', 'precision' => null],
        'created_user_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '登録者', 'precision' => null, 'autoIncrement' => null],
        'updated' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '更新日時', 'precision' => null],
        'updated_user_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '更新者', 'precision' => null, 'autoIncrement' => null],
        'deleted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '削除日時', 'precision' => null],
        'deleted_user_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '削除者', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'IDX' => ['type' => 'index', 'columns' => ['id'], 'length' => []],
        ],
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
            'vessel' => 'Lorem ipsum dolor sit amet',
            'msi' => 'Lorem ipsum dolor sit amet',
            'tsi' => 'Lorem ipsum dolor sit amet',
            'ope' => 'Lorem ipsum dolor sit amet',
            'created' => '2018-04-09 05:53:20',
            'created_user_id' => 1,
            'updated' => '2018-04-09 05:53:20',
            'updated_user_id' => 1,
            'deleted' => '2018-04-09 05:53:20',
            'deleted_user_id' => 1
        ],
    ];
}
