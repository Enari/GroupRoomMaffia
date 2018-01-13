<?php

namespace App\Http\Controllers;

use App\Models\SchedulledBooking;
use Illuminate\Support\Facades\Auth;

class SchedulledBookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $bookings = SchedulledBooking::where(['user' => Auth::user()->username])->orderBy('date', 'ASC')->orderBy('time', 'ASC')->get();

        return view('schedulledbookings', compact(['bookings']));
    }

    public function delete(SchedulledBooking $booking)
    {
        if ($booking->user != Auth::user()->username) {
            flash('You did not make that schedulled booking...')->error();

            return redirect(action('SchedulledBookingsController@index'));
        }

        $booking->delete();
        flash('Deleted Schedulled Booking');

        return redirect(action('SchedulledBookingsController@index'));
    }
}
