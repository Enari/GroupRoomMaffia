<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KronoxSession;

class BookingsController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

    public function index()
    {
        $sessions = KronoxSession::where('sessionActive', 1)->orderBy('MdhUsername', 'asc')->get();
        return view('bookings', compact(['sessions']));
    }

    public function add(Request $request){
    }
}
