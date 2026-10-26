<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentsFixture
 *
 */
class DocumentsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ID', 'autoIncrement' => true, 'precision' => null],
        'doc_number' => ['type' => 'string', 'length' => 20, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '文書No', 'precision' => null, 'fixed' => null],
        'file_name' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'ファイル名', 'precision' => null, 'fixed' => null],
        'file_size' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => 'ファイルサイズ', 'precision' => null, 'autoIncrement' => null],
        'file_path' => ['type' => 'string', 'length' => 100, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'ファイルパス', 'precision' => null, 'fixed' => null],
        'file_extension' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'ファイル拡張子', 'precision' => null, 'fixed' => null],
        'view_counter' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '参照カウンター', 'precision' => null, 'autoIncrement' => null],
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
            'doc_number' => 'Lorem ipsum dolor ',
            'file_name' => 'Lorem ipsum dolor sit amet',
            'file_size' => 1,
            'file_path' => 'Lorem ipsum dolor sit amet',
            'file_extension' => 'Lorem ip',
            'view_counter' => 1,
            'remark' => 'Lorem ipsum dolor sit amet',
            'created' => '2018-04-09 05:50:48',
            'created_user_id' => 1,
            'updated' => '2018-04-09 05:50:48',
            'updated_user_id' => 1,
            'deleted' => '2018-04-09 05:50:48',
            'deleted_user_id' => 1
        ],
    ];
}
