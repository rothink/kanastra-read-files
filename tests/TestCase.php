<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $baseUrl = 'http://localhost';


    /**
     * Migrates the database and set the mailer to 'pretend'.
     * This will cause the tests to run quickly.
     *
     */
    private function prepareForTests()
    {
        Artisan::call('migrate');
        Artisan::call('db:seed');
    }

    /**
     * Default preparation for each test
     *
     */
    public function setUp() :void
    {
        parent::setUp();
        DB::beginTransaction();
        $this->prepareForTests();
    }

    public function tearDown() :void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function makeParams()
    {
        return [
            'name' => fake()->name,
            'governmentId' => fake()->numerify,
            'email' => fake()->email,
            'debtAmount' => fake()->numerify,
            'debtDueDate' => fake()->numerify,
            'debtID' => fake()->uuid,
        ];
    }
}
