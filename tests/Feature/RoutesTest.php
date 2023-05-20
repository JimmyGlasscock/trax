<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutesTest extends TestCase
{
    /**
     * tests the get-cars route
     *
     * @return void
     */
    public function test_get_cars()
    {
        $response = $this->get('/get-cars');

        $response->assertStatus(200);
    }

    /**
     * tests the get-car/{id} route
     *
     * @return void
     */
    public function test_get_car_by_id()
    {
        //Create a Car so that we have something access
        $addResponse = $this->postJson('/add-car', ['year' => '2012', 'make' => 'Mini', 'model' => 'Cooper']);

        $addResponse->assertStatus(201);

        //get the car we just made
        $response = $this->get('/get-car/1');

        $response->assertStatus(200);
    }

    /**
     * tests the add-car route
     *
     * @return void
     */
    public function test_add_car()
    {
        $response = $this->postJson('/add-car', ['year' => '2012', 'make' => 'Mini', 'model' => 'Cooper']);

        $response->assertStatus(201);
    }
}
