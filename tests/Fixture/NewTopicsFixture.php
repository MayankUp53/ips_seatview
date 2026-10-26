<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * NewTopicsFixture
 *
 */
class NewTopicsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'POST ID', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'タイトル', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '名前', 'precision' => null, 'fixed' => null],
        'content' => ['type' => 'string', 'length' => 0, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '内容', 'precision' => null, 'fixed' => null],
        'img_name' => ['type' => 'string', 'length' => 0, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '画像名', 'precision' => null, 'fixed' => null],
        'img_ext' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '画像拡張子', 'precision' => null, 'fixed' => null],
        'img_size' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '画像サイズ', 'precision' => null, 'autoIncrement' => null],
        'posted' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => '投稿日時', 'precision' => null],
        'posted_user_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '投稿者', 'precision' => null, 'autoIncrement' => null],
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
            'title' => 'Lorem ipsum dolor sit amet',
            'name' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet',
            'img_name' => 'Lorem ipsum dolor sit amet',
            'img_ext' => 'Lorem ip',
            'img_size' => 1,
            'posted' => '2018-04-09 05:52:08',
            'posted_user_id' => 1,
            'created' => '2018-04-09 05:52:08',
            'created_user_id' => 1,
            'updated' => '2018-04-09 05:52:08',
            'updated_user_id' => 1,
            'deleted' => '2018-04-09 05:52:08',
            'deleted_user_id' => 1
        ],
    ];
}
