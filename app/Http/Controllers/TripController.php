<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Trip;

/**
 * This controller is used for anything pertaining to the Trip object.
 * This includes getTrips and addTrip.
 */
class TripController extends Controller
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
     * Returns all trips in the database.
     * 
     * @return trips - an array containing all the trips in the database
     */
    public function getTrips()
    {
        $trips = [];

        //Sort by date
        //Add up miles as we go
        $trips = DB::table('trips')->orderBy('date')->selectRaw('date, miles, car_id, sum(miles) over total')->get();

        //make date look nice

        $trips['data'] = $trips->toArray();

        return $trips;
    }

    /**
     * Adds a new trip to the database
     * 
     * @param request - request object
     * @return result - true if trip was saved to the database successfully, false otherwise
     */
    public function addTrip(Request $request)
    {
        $request->validate([
            'date' => 'required|date', // ISO 8601 string
            'car_id' => 'required|integer',
            'miles' => 'required|numeric'
        ]);

        //trim the date
        $endOfDate = strpos($request->get('date'), 'T');
        $date = substr($request->get('date'), 0, $endOfDate);

        $trip = new Trip();

        $trip->date = $date;
        $trip->car_id = $request->get('car_id');
        $trip->miles = $request->get('miles');

        $result = $trip->save();

        return $result;
    }
}