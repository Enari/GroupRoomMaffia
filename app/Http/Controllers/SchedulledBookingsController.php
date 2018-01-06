<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SchedulledBooking;
use App\Models\KronoxSession;

class SchedulledBookingsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $bookings = SchedulledBooking::all();
        $sessions = KronoxSession::where('sessionActive', 1)->orderBy('MdhUsername', 'asc')->get();
        return view('schedulledbookings', compact(['bookings', 'sessions']));
    }

    public function delete(SchedulledBooking $booking){
        $booking->delete();
        flash('Deleted Schedulled Booking');
        return redirect(action('SchedulledBookingsController@index'));
    }
}
