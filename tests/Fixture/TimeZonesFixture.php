<?php
namespace Skeleton\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TimeZonesFixture
 *
 */
class TimeZonesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => true, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'latitude' => ['type' => 'float', 'length' => 10, 'precision' => 7, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'longitude' => ['type' => 'float', 'length' => 10, 'precision' => 7, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => ''],
        'identifier' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'latitude' => ['type' => 'unique', 'columns' => ['latitude', 'longitude'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'latitude' => 1,
                'longitude' => 1,
                'identifier' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
