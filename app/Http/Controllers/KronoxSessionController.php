<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KronoxSession;
use App\Helpers\KronoxCommunicator;
use Illuminate\Support\Facades\Auth;

class KronoxSessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $sessions = KronoxSession::where('user', Auth::user()->username)->orderBy('MdhUsername', 'asc')->get();

        return view('sessions', compact(['sessions']));
    }

    public function add(Request $request)
    {
        $url = 'https://webbschema.mdh.se/ajax/ajax_session.jsp?op=anvandarId';
        $result = KronoxCommunicator::httpGet($url, $request->JSESSIONID);

        if (empty($result) || $result == 'INLOGGNING KRÄVS') {
            flash('The supplied JSESSIONID is not logged in.')->error();

            return redirect(action('KronoxSessionController@index'));
        }

        $newsession = KronoxSession::create([
            'MdhUsername' => $result,
            'JSESSIONID' => $request->JSESSIONID,
            'sessionActive' => true,
            'user' => Auth::user()->username,
        ]);

        $newsession->save();
        flash('Sucess')->success();

        return redirect(action('KronoxSessionController@index'));
    }

    public function delete(kronoxSession $session)
    {
        if ($session->user == Auth::user()->username) {
            $session->delete();
            flash('Deleted Session');
        } else {
            flash('Error: Access Denied');
        }

        return redirect(action('KronoxSessionController@index'));
    }

    public function logout(kronoxSession $session)
    {
        if ($session->user == Auth::user()->username) {
            $url = 'https://webbschema.mdh.se/logout.jsp';
            $result = KronoxCommunicator::httpGet($url, $session->JSESSIONID);
            $session->delete();
            flash('Success, probbably...')->success();
        } else {
            flash('Error: Access Denied');
        }

        return redirect(action('KronoxSessionController@index'));
    }

    public function poll(kronoxSession $session)
    {
        if ($session->user == Auth::user()->username) {
            $session->Poll();
            flash('Session Polled')->success();
        } else {
            flash('Error: Access Denied');
        }

        return redirect(action('KronoxSessionController@index'));
    }

    public function getActiveSessionsMdhUsernameAndNumberOfBookings()
    {
        $sessions = KronoxSession::where(['user' => Auth::user()->username, 'sessionActive' => 1])->orderBy('MdhUsername', 'asc')->get();

        $usernamesAndBookings = [];

        foreach ($sessions as $session) {
            $usernamesAndBookings[] = [
                'MdhUsername' => $session->MdhUsername,
                'numberOfBookings' => $session->getNumberOfBookings(),
                'JSESSIONID' => $session->JSESSIONID,
            ];
        }

        return $usernamesAndBookings;
    }
}
