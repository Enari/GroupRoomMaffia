@extends('layouts.master')
@section('title', 'Group Room Maffia')
@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet">
@endsection
@section('content')
<div class="row mb-2 ">
    <div class="col-sm-4 mr-auto">
      <h1>My Bookings</h1>
    </div>
    <div class="col-sm-1">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSessionModal" title="Add Category">Add</button>
    </div>
</div>
<div class="table">
<table class="table table-bordered table-striped table-hover table-fixed">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Room</th>
            <th>Booker</th>
            <th>Message</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
@if(empty($bookings))
             <tr><td>No bookings for any of the active sessions</td><td></td><td></td><td></td><td></td><td></td></tr>
@else
  @foreach ($bookings as $booking)
    <tr>
      <td>{{ $booking->date }}</td>
      <td>{{ $booking->time }}</td>
      <td>{{ $booking->room }}</td>
      <td>{{ $booking->booker }}</td>
      <td>{{ $booking->message }}</td>
      <td>
        <a href="{{ action('BookingsController@unBook', ['booker' => $booking->booker, 'id' => $booking->bookingID]) }}">
          <button type="button" class="btn btn-danger btn-sm" title="Delete">
            <span class="fa fa-trash" aria-hidden="true"/>
          </button>
        </a>
      </td>
    </tr>
  @endforeach
@endif
    </tbody>
</table>
{{-- <div class="pagination-wrapper"> {!! $sessions->render() !!} </div> --}}
</div>
{{-- Modal --}}
<div class="modal fade" id="addSessionModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Booking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="newBookingForm" method="post">
          <div class="form-group">
            <label for="user">User:</label>
            <select class="form-control" id="user" name="user" {{ ($sessions->count() == 0) ? ' disabled' : ''}}>
@if($sessions->count() == 0)
              <option>No active sessions</option>
@else
  @foreach ($sessions as $session)
    <option value="{{ $session->JSESSIONID }}">{{ $session->MdhUsername}} ({{ $session->getNumberOfBookings()}}/8)</option>
  @endforeach
@endif
            </select>
          </div>
          <div class="form-group date">
            <label for="date" class="col-form-label">Date:</label>
            <div class="input-group date">
              <input type="text" class="form-control" id="date" name="date">
              <div class="input-group-addon">
                <span class="fa fa-calendar"></span>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="time">Time</label>
            <select class="form-control" id="time" name="time">
              <option value="0">08:15-10:00</option>
              <option value="1">10:15-12:00</option>
              <option value="2">12:15-14:00</option>
              <option value="3">14:15-16:00</option>
              <option value="4">16:15-18:00</option>
              <option value="5">18:15-20:00</option>
            </select>
          </div>
          <div class="form-group">
            <label for="room" class="col-form-label">Room:</label>
            <input type="text" class="form-control" id="room" name="room" value="U2-271"></input>
          </div>
          <div class="form-group">
            <label for="message" class="col-form-label">Message:</label>
            <input type="text" class="form-control" id="message" name="message"></input>
          </div>
          {{ csrf_field() }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" form="newBookingForm" value="Submit" class="btn btn-primary">Make Booking</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('footer')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  $todaysDate = new Date()
  $todaysDate = $todaysDate.toISOString().slice(0,10)
  $('#newBookingForm .input-group.date').datepicker({
    format: "yyyy-mm-dd",
    weekStart: 1,
    startDate: $todaysDate,
    maxViewMode: 0,
    todayBtn: true,
    autoclose: true,
    todayHighlight: true
});

</script>
@endsection
