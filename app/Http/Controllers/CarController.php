<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use App\Car;

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
     * @return Car - Car object
     */
    public function getCarById($id)
    {
        //handle if the id is null
        if (is_null($id))
        {
            //error handling would go here
        }

        return Car::find($id);
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

        $car->year = $request->input('year');
        $car->make = $request->input('make');
        $car->model = $request->input('model');

        $result = $car->save();

        return $result;
    }

    /**
     * Deletes the specified car object from the database.
     * 
     * @param request - request object
     * 
     * @return result - true if delete was successful, false otherwise
     */
    public function deleteCar(Request $request)
    {
        //validate the input
        $request->validate([
            'id' => 'required|integer'
        ]);

        $result = Car::where('id', $request->input('id'))->delete();

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

    }
}
