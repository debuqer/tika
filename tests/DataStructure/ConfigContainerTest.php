<?php


namespace Debuqer\TikaFormBuilder\Tests\DataStructure;


use Debuqer\TikaFormBuilder\DataStructure\ConfigContainer;

class ConfigContainerTest extends \PHPUnit\Framework\TestCase
{
    protected $data = [
        'seasons' => [
            'spring' => [
                'months' => [
                    'farvardin' => [
                        'has_31_days' => true,
                        'is_rainy' => true,
                        'avg_temp' => 20
                    ],
                ]
            ],
            'summer' => [
                'tir' => [
                    'has_31_days' => true,
                    'is_rainy' => false,
                    'avg_temp' => 30,
                ]
            ],
        ],
        'months' => [
            'farvardin',
            'ordibehesh'
        ]
    ];
    /** @var ConfigContainer */
    protected $cc;

    public function setUp(): void
    {
        $this->cc = new ConfigContainer($this->data);
    }

    public function test_can_load_data()
    {
        $this->assertEquals($this->data, $this->cc->get()->toArray());
        $this->assertEquals($this->data['seasons']['spring'], $this->cc->get('seasons.spring')->toArray());
        $this->assertEquals($this->data['months'][0], $this->cc->get('months.0'));
        $this->assertNull($this->cc->get('seasons.winter'));
        $this->assertEquals('not_defined', $this->cc->get('seasons.winter', 'not_defined'));
        $this->assertTrue($this->cc->has('seasons.spring'));
        $this->assertFalse($this->cc->has('seasons.winter'));
    }

    public function test_set_data()
    {
        $this->cc->set('years', '2022');
        $configContainer = new ConfigContainer([
            'nested_config_container' => true,
        ]);
        $this->cc->set('new_cc', $configContainer);

        $this->assertEquals('2022', $this->cc->get('years'));
        $this->assertEquals($configContainer, $this->cc->get('new_cc'));
    }

    public function test_unset_data()
    {
        $this->cc->unset('seasons.spring.months.farvardin');
        $this->assertFalse($this->cc->has('seasons.spring.months.farvardin'));
        $this->assertArrayNotHasKey('farvardin', $this->cc->get('seasons.spring.months')->toArray());
    }

    public function test_to_array()
    {
        $this->assertEquals($this->data, $this->cc->toArray());
    }

    public function test_merge()
    {
        $this->cc->merge([
            'seasons' => [
                'winter' => [
                    'has_31_days' => false,
                ]
            ]
        ]);

        $this->assertFalse($this->cc->get('seasons.winter.has_31_days'));
    }

}