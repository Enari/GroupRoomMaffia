<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\SchedulledBooking;

class SchedulledBookingsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $bookings = SchedulledBooking::where(['user' => Auth::user()->username])->get();
        return view('schedulledbookings', compact(['bookings']));
    }

    public function delete(SchedulledBooking $booking)
    {
        if($booking->user != Auth::user()->username)
        {
            flash('You did not make that schedulled booking...')->error();
            return redirect(action('SchedulledBookingsController@index'));
        }

        $booking->delete();
        flash('Deleted Schedulled Booking');
        return redirect(action('SchedulledBookingsController@index'));
    }
}
