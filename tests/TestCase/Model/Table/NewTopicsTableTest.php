<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\NewTopicsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\NewTopicsTable Test Case
 */
class NewTopicsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\NewTopicsTable
     */
    public $NewTopics;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.new_topics',
        'app.posted_users',
        'app.created_users',
        'app.updated_users',
        'app.deleted_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('NewTopics') ? [] : ['className' => NewTopicsTable::class];
        $this->NewTopics = TableRegistry::get('NewTopics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NewTopics);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
