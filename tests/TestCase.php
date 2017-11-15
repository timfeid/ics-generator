<?php

use Faker\Factory;

abstract class TestCase extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->faker = Factory::create();
    }
}
