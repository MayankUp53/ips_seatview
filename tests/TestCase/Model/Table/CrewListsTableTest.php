<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CrewListsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CrewListsTable Test Case
 */
class CrewListsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CrewListsTable
     */
    public $CrewLists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.crew_lists',
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
        $config = TableRegistry::exists('CrewLists') ? [] : ['className' => CrewListsTable::class];
        $this->CrewLists = TableRegistry::get('CrewLists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CrewLists);

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
