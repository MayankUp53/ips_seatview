<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostsFixture
 *
 */
class PostsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'POST ID', 'autoIncrement' => true, 'precision' => null],
        'res_id' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'RES ID', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'タイトル', 'precision' => null, 'fixed' => null],
        'name' => ['type' => 'string', 'length' => 30, 'null' => false, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '名前', 'precision' => null, 'fixed' => null],
        'content' => ['type' => 'string', 'length' => 0, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '内容', 'precision' => null, 'fixed' => null],
        'img_name' => ['type' => 'string', 'length' => 0, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '画像名', 'precision' => null, 'fixed' => null],
        'img_ext' => ['type' => 'string', 'length' => 10, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '画像拡張子', 'precision' => null, 'fixed' => null],
        'img_size' => ['type' => 'integer', 'length' => 4, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '画像サイズ', 'precision' => null, 'autoIncrement' => null],
        'extra' => ['type' => 'string', 'length' => 0, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => 'その他', 'precision' => null, 'fixed' => null],
        'comments' => ['type' => 'string', 'length' => 0, 'null' => true, 'default' => null, 'collate' => 'utf8_bin', 'comment' => '備考', 'precision' => null, 'fixed' => null],
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
    public array $records = [
        [
            'id' => 1,
            'res_id' => 1,
            'title' => 'Lorem ipsum dolor sit amet',
            'name' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet',
            'img_name' => 'Lorem ipsum dolor sit amet',
            'img_ext' => 'Lorem ip',
            'img_size' => 1,
            'extra' => 'Lorem ipsum dolor sit amet',
            'comments' => 'Lorem ipsum dolor sit amet',
            'created' => '2018-03-30 10:25:44',
            'created_user_id' => 1,
            'updated' => '2018-03-30 10:25:44',
            'updated_user_id' => 1,
            'deleted' => '2018-03-30 10:25:44',
            'deleted_user_id' => 1
        ],
    ];
}
