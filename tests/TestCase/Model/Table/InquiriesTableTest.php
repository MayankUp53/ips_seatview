<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\InquiriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\InquiriesTable Test Case
 */
class InquiriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\InquiriesTable
     */
    public $Inquiries;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.inquiries',
        'app.created_users',
        'app.updated_users',
        'app.deleted_users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = TableRegistry::exists('Inquiries') ? [] : ['className' => InquiriesTable::class];
        $this->Inquiries = \Cake\ORM\TableRegistry::getTableLocator()->get('Inquiries', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Inquiries);

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
