<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\kronoxSession;

class KronoxSessionController extends Controller
{
	public function __construct()
    {
      //$this->middleware('auth');
    }

    public function index()
    {
        $sessions = kronoxSession::orderBy('MdhUsername', 'asc')->paginate(20);
        return view('sessions', compact(['sessions']));
    }

    public function delete(kronoxSession $session){
        $session->delete();
        return redirect('/');
    }
}
