<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Friend;

class FriendsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function index()
  {
    $friends = Friend::where('user', Auth::user()->username)->orderBy('name', 'asc')->get();
    return view('friends', compact(['friends']));
  }

  public function add(Request $request)
  {
    Friend::create([
      'user' => Auth::user()->username, 
      'name' => $request->name, 
      'mdhUsername' => $request->mdhUsername,
      'color' => $request->color,
    ]);
    return redirect(action('FriendsController@index'));
  }

  public function delete(Friend $friend)
  {
    if($friend->user == Auth::user()->username)
    {
      $friend->delete();
      flash('Removed friend');
    }
    else
    {
      flash('Error');
    }

    return redirect(action('FriendsController@index'));
  }
}
