<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SchedulledBooking;

class SchedulledBookingsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $bookings = SchedulledBooking::all();
        return view('schedulledbookings', compact(['bookings']));
    }

    public function delete(SchedulledBooking $booking){
        $booking->delete();
        flash('Deleted Schedulled Booking');
        return redirect(action('SchedulledBookingsController@index'));
    }
}
