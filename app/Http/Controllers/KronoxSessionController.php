<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KronoxSession;
use App\Helpers\KronoxCommunicator;

class KronoxSessionController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $sessions = KronoxSession::orderBy('MdhUsername', 'asc')->paginate(20);
        return view('sessions', compact(['sessions']));
    }

    public function add(Request $request)
    {
        $url = 'https://webbschema.mdh.se/ajax/ajax_session.jsp?op=anvandarId';
        $result = KronoxCommunicator::httpGet($url, $request->JSESSIONID);

        if($result == "INLOGGNING KRÄVS"){
            return redirect('/sessions')->withErrors(array('message' => 'The supplied JSESSIONID is not logged in.'));
        }
        
        $newsession = KronoxSession::create(['MdhUsername' => $result, 'JSESSIONID' => $request->JSESSIONID, 'sessionActive' => true]);
        $newsession->save();
        return redirect('/sessions');
    }

    public function delete(kronoxSession $session){
        $session->delete();
        return redirect('/');
    }
}
