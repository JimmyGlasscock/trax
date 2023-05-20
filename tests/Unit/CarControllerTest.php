<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Controllers\CarController;

class CarControllerTest extends TestCase
{
    /**
     * Tests that get cars returns results
     *
     * @return void
     */
    public function test_get_cars()
    {
        $controller = new CarController();
        $this->assertTrue(is_array($controller->getCars()));   
    }

    /**
     * Tests that get car by id will work with a null value
     *
     * @return void
     */
    public function test_get_car_by_id_with_null()
    {
        $controller = new CarController();

        $this->assertTrue($controller->getCarById(null) == []);
    }
}
