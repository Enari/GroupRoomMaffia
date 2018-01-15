@extends('layouts.master')
@section('title', 'Group Room Maffia')
@section('content')
<div class="row mb-2 ">
    <div class="col-sm-4 mr-auto">
        <h1>Sessions</h1>
    </div>
    <div class="col-sm-1">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSessionModal" title="Add Category">Add</button>
    </div>
</div>
                <div class="table">
                <table class="table table-bordered table-striped table-hover table-fixed">
                    <thead>
                        <tr>
                            <th> MDH Username </th>
                            <th> JSESSIONID </th>
                            <th> Active </th>
                            <th> No. Bookings </th>
                            <th> Last poll </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
@if ($sessions->isEmpty())
                        <tr><td colspan="6">There are no sessions</td></tr>
@else
{{-- var_dump($sessions) --}}
@foreach($sessions as $session)
                        <tr>
                            <td>{{ $session->MdhUsername }}</td>
                            <td><samp>{{ $session->JSESSIONID }}</samp></td>
                            <td>{{ $session->sessionActive }}</td>
                            <td>{{ $session->getNumberOfBookings() }}</td>
                            <td>{{ \Carbon\Carbon::parse($session->updated_at)->diffForHumans() }}</td>
                            <td>
                                <a href="{{ action('KronoxSessionController@poll', $session->id) }}" role="button" class="btn btn-primary btn-sm" title="Poll the session">
                                    <span class="fa fa-refresh" aria-hidden="true"/>
                                </a>
                                <a href="{{ action('KronoxSessionController@delete', $session->id) }}" role="button" class="btn btn-danger btn-sm" title="Remove the session from your account">
                                    <span class="fa fa-trash" aria-hidden="true"/>
                                </a>
                                <a href="{{ action('KronoxSessionController@logout', $session->id) }}" role="button" class="btn btn-danger btn-sm" title="Sign out session and remove">
                                    <span class="fa fa-sign-out" aria-hidden="true"/>
                                </a>
                            </td>
                        </tr>
@endforeach
@endif
                    </tbody>
                </table>
                </div>
                {{-- Modal --}}
                <div class="modal fade" id="addSessionModal" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Session</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form id="addSessionForm" method="post">
                          <div class="form-group">
                            <label for="JSESSIONID" class="col-form-label">JSESSIONID:</label>
                            <input type="text" class="form-control" id="JSESSIONID" name="JSESSIONID"></input>
                            {{ csrf_field() }}
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" form="addSessionForm" value="Submit" class="btn btn-primary">Add Session</button>
                      </div>
                    </div>
                  </div>
                </div>
@endsection
