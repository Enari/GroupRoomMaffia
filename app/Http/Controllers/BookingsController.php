<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\KronoxSession;
use App\Helpers\KronoxCommunicator;
use App\Models\Booking;


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

        return view('bookings', compact(['sessions', 'bookings']));
    }

    public function book(Request $request)
    {
        $url = 'https://webbschema.mdh.se/ajax/ajax_resursbokning.jsp?op=boka';
        $url = $url . '&datum=' . substr($request->date, 2, 8);
        $url = $url . '&id=' . $request->room;
        $url = $url . '&typ=RESURSER_LOKALER';
        $url = $url . '&intervall=' . $request->time;
        $url = $url . '&moment=' . $request->message;
        $url = $url . '&flik=FLIK_0001';

        $result = KronoxCommunicator::httpGet($url, $request->user);
        return redirect(action('BookingsController@index'))->withErrors(array('result' => $result));
    }

    public function unBook($booker, $id)
    {
        $session = KronoxSession::where(['sessionActive' => 1, 'MdhUsername' => $booker])->first();

        $url = 'https://webbschema.mdh.se/ajax/ajax_resursbokning.jsp?op=avboka';
        $url = $url . '&bokningsId=' . $id;

        $result = KronoxCommunicator::httpGet($url, $session->JSESSIONID);

        return redirect(action('BookingsController@index'))->withErrors(array('result' => $result));
    }

    public function allBookings($date = null)
    {
        if($date == null)
        {
            $date = substr(Carbon::now(), 0, 10);
        }

        $sessions = KronoxSession::where('sessionActive', 1)->orderBy('MdhUsername', 'asc')->get();
        $rows = KronoxCommunicator::getAllBookings($date);
        return view('allbookings', compact(['sessions', 'rows', 'date']));
    }
}
