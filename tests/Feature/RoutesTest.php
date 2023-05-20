<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\User;

class RoutesTest extends TestCase
{
    /**
     * tests the get-cars route if the user is not logged in
     *
     * @return void
     */
    public function test_get_cars_not_logged_in()
    {

        $response = $this->get('/api/get-cars');

        $response->assertRedirect(route('login'));
    }

    /**
     * tests the get-cars route if the user is logged in
     *
     * @return void
     */
    public function test_get_cars_logged_in()
    {
        // I am not sure why this does not properly log in the user.
        // This test is not working because of this.
        $user = User::first();
        $response = $this->actingAs($user)->get('/api/get-cars');

        $response->assertStatus(200);
    }
}
