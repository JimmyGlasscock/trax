<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Car;
use Illuminate\Support\Facades\DB;

/**
 * This controller is used for anything pertaining to the Car object.
 * This includes getCar(by Id), getCars, addCar and delete Car.
 */
class CarController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Returns the Car object at the specified id.
     * 
     * @param id - id of the Car to be returned
     * 
     * @return result - array containing car data
     */
    public function getCarById($id)
    {
        //handle if the id is null
        if (is_null($id))
        {
            //error handling would go here
        }

        $result = [];

        $car = Car::find($id)->toArray();

        //add trip count
        $car['trip_count'] = $this->getTripCount($car['id']);

        //add trip miles
        $car['trip_miles'] = $this->getTripMiles($car['id']);

        $result['data'] = $car;

        return $result;
    }

    /**
     * Returns all the Cars from the database.
     * 
     * @return Cars - Array of Car objects
     *
     */
    public function getCars()
    {
        $cars = [];

        $cars['data'] = Car::all()->toArray();

        return $cars;
    }

    /**
     * Adds a new car to the database
     * 
     * @param request - request object
     * @return result - true if car was saved to the database successfully, false otherwise
     */
    public function addCar(Request $request)
    {
        //validate the input
        $request->validate([
            'year' => 'required|integer',
            'make' => 'required|string',
            'model' => 'required|string'
        ]);

        $car = new Car;

        $car->year = $request->get('year');
        $car->make = $request->get('make');
        $car->model = $request->get('model');

        $result = $car->save();

        return $result;
    }

    /**
     * Deletes the specified car object from the database.
     * 
     * @param Car - car object to be deleted
     * 
     * @return result - true if delete was successful, false otherwise
     */
    public function deleteCar(Car $car)
    {
        $result = $car->delete();

        return $result;
    }

    /**
     * Returns the number of trips the car has been on.
     * 
     * @param id - the id of the car specified
     * 
     * @return count - the number of trips the car has been on
     */
    public function getTripCount($id)
    {
        $count = DB::table('trips')
            ->selectRaw('count(car_id) as count')
            ->where('car_id', '=', $id)
            ->first();

        return $count->count;
    }

    /**
     * Returns the number of miles the car has been on during all of its trips.
     * 
     * @param id - the id of the car specified
     * 
     * @return miles - the number of miles the car has gone on trips
     */
    public function getTripMiles($id)
    {
        $miles = DB::table('trips')
            ->selectRaw('sum(miles) as miles')
            ->where('car_id', '=', $id)
            ->first();

        return $miles->miles;
    }
}
