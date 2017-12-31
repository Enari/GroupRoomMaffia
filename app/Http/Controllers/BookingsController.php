<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Helpers\KronoxCommunicator;
use App\Models\KronoxSession;
use App\Models\Booking;
use App\Models\SchedulledBooking;


class BookingsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $sessions = KronoxSession::where('sessionActive', 1)->orderBy('MdhUsername', 'asc')->get();
        $bookings = [];

        foreach ($sessions as $session) {
            $bookings = array_merge($bookings, KronoxCommunicator::getMyBookings($session->JSESSIONID));
        }

        // Now sort the, so we get them in propper order
        $collection = collect($bookings);
        $collection = $collection->sortBy('time');
        $bookings = $collection->sortBy('date');

        return view('bookings', compact(['sessions', 'bookings']));
    }

    public function book(Request $request)
    {
        if(Carbon::parse($request->date)->gt(Carbon::now()->addWeek()))
        {
            $booking = new SchedulledBooking;
            $booking->date = $request->date;
            $booking->room = $request->room;
            $booking->time = $request->time;
            $booking->booker = KronoxSession::where('JSESSIONID', $request->user)->first()->MdhUsername;
            $booking->message = $request->message;
            $booking->save();

            flash('The Booking was more than a week out and has been schedulled');

            return redirect(action('BookingsController@index'));
        }

        $url = 'https://webbschema.mdh.se/ajax/ajax_resursbokning.jsp?op=boka';
        $url = $url . '&datum=' . urlencode(substr($request->date, 2, 8));
        $url = $url . '&id=' . urlencode($request->room);
        $url = $url . '&typ=RESURSER_LOKALER';
        $url = $url . '&intervall=' . urlencode($request->time);
        $url = $url . '&moment=' . (empty($request->message) ? "%20" : urlencode($request->message));
        $url = $url . '&flik=FLIK_0001';

        $result = KronoxCommunicator::httpGet($url, $request->user);

        if($result == 'OK'){
            flash('Sucessfully room ' . $request->room . '!')->success();
            return redirect(action('BookingsController@index'));
        }

        flash('Booking failed: ' . $result)->error();
        return redirect(action('BookingsController@allBookings', ['date' => $request->date]));
    }

    public function unBook($booker, $id)
    {
        $session = KronoxSession::where(['sessionActive' => 1, 'MdhUsername' => $booker])->first();

        $url = 'https://webbschema.mdh.se/ajax/ajax_resursbokning.jsp?op=avboka';
        $url = $url . '&bokningsId=' . $id;

        $result = KronoxCommunicator::httpGet($url, $session->JSESSIONID);

        if($result == 'OK'){
            flash('Sucessfully unbooked!')->success();
        }
        else{
            flash('Unbooking failed: ' . $result)->error();
        }

        return redirect(action('BookingsController@index'));
    }

    public function allBookings($date = null)
    {
        if($date == null)
        {
            // If time is after 20 (last grouproom time) display bookings for next day instead.
            $date = (Carbon::createFromTime(20, 0, 0)->lt(Carbon::now('Europe/Stockholm')) ? Carbon::tomorrow() : Carbon::now()); 
            $date = $date->toDateString();
        }

        // Friends is used to highlight bookings in the table, currently sessions is friends.
        $friends= [];
        $sessions = KronoxSession::all();
        foreach ($sessions as $session) {
            $friends[] = $session->MdhUsername;
        }

        $sessions = KronoxSession::where('sessionActive', 1)->orderBy('MdhUsername', 'asc')->get();
        $rows = KronoxCommunicator::getAllBookings($date);
        return view('allbookings', compact(['sessions', 'rows', 'date', 'friends']));
    }
}
