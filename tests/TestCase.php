<?php

namespace Tests;

use App\Main\Todo\Todo;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions, WithFaker;

    protected $todo;

    public function arrayResponse($item) {
        return [
            "data" => [$item]
        ];
    }


    protected function setUp() {
        parent::setUp();

        $this->todo = factory(Todo::class)->create();
    }

    protected function tearDown() {
        parent::tearDown();
    }


}
