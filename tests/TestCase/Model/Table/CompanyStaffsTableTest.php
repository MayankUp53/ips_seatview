<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompanyStaffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompanyStaffsTable Test Case
 */
class CompanyStaffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CompanyStaffsTable
     */
    public $CompanyStaffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public array $fixtures = [
        'app.company_staffs',
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
        $config = TableRegistry::exists('CompanyStaffs') ? [] : ['className' => CompanyStaffsTable::class];
        $this->CompanyStaffs = \Cake\ORM\TableRegistry::getTableLocator()->get('CompanyStaffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->CompanyStaffs);

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
