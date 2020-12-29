<?php

namespace Tests\Unit;

use App\Logic\Countries;
use PHPUnit\Framework\TestCase;

class CountriesLogicTest extends TestCase
{
    /**
     * @var Countries
     */
    protected $countries;

    public function setUp(): void
    {
        parent::setUp();

        $this->countries = new Countries;
    }

    public function testGetListOfCountries()
    {
        $countries = $this->countries->countries();

        $this->assertEquals(['name' => 'Afghanistan'], $countries[0]);
    }
}
