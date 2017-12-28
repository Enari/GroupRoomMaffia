<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KronoxSession;

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

    public function add(Request $request){
        $url = 'https://webbschema.mdh.se/ajax/ajax_session.jsp?op=anvandarId';

        $options = array(
          'http' => array(
              'header'  => "Content-type: application/x-www-form-urlencoded\r\n" .
              "Cookie: JSESSIONID=" . $request->JSESSIONID . ";\r\n",
              'method'  => 'GET',
          )
        );

        $context  = stream_context_create($options);
        try {
            $result = file_get_contents($url, false, $context);
            if($result == "INLOGGNING KRÄVS"){
                return redirect('/sessions')->withErrors(array('message' => 'The supplied JSESSIONID is not logged in.'));
            }
            $newsession = new KronoxSession;
            $newsession->MdhUsername = $result;
            $newsession->JSESSIONID = $request->JSESSIONID;
            $newsession->sessionActive = true;
            $newsession->save();
            return redirect('/sessions');
        }
        catch (\Exception $e) {
            return "Add Session Exeption". $e;
        }
    }

    public function delete(kronoxSession $session){
        $session->delete();
        return redirect('/');
    }
}
