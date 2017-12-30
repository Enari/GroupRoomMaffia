@extends('layouts.master')
@section('title', 'Group Room Maffia')
@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet">
@endsection
@section('content')
<div class="row mb-2 ">
    <div class="col-sm-4 mr-auto"><h1>All Bookings</h1></div>
    <div class="col-sm-1">
      <label for="date" class="col-form-label">Date:</label>
    </div>
    <div class="col-sm-2">
      <div class="input-group date">
        <input type="text" class="form-control" onchange="window.location.replace('{{ action('BookingsController@allBookings') }}/' + this.value)" id="date" name="date" value="{{$date}}">
        <div class="input-group-addon">
          <span class="fa fa-calendar"></span>
        </div>
      </div>
    </div>
</div>
<div class="table">
<table class="table table-bordered table-striped table-hover table-fixed">
    <thead>
        <tr>
            <th>Room</th>
            <th>08:15-10:00</th>
            <th>10:15-12:00</th>
            <th>12:15-14:00</th>
            <th>14:15-16:00</th>
            <th>16:15-18:00</th>
            <th>18:15-20:00</th>
        </tr>
    </thead>
    <tbody>
@unless(empty($rows))
  @foreach ($rows as $row)
    <tr>
    @foreach ($row as $i => $cell)
      @if($cell == "Free")
        <td><a href="#" style="color: #00f000;" data-toggle="modal" data-target="#BookingModal" data-room="{{ $row[0] }}" data-time="{{ $i-1 }}">Free</a></td>
      @else
        @if(in_array($cell, $friends))
          <td><p style="color:blue">{{ $cell }}</p></td>
        @else
          <td>{{ $cell }}</td>
        @endif
      @endif
    @endforeach
    </tr>
  @endforeach
@endunless
    </tbody>
</table>
{{-- <div class="pagination-wrapper"> {!! $sessions->render() !!} </div> --}}
</div>
{{-- Modal --}}
<div class="modal fade" id="BookingModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Booking</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="newBookingForm" method="post" action="{{ action('BookingsController@book') }}">
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
            <input type="text" class="form-control" id="room" name="room" value=""></input>
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
  $oneWeekFromNow = new Date()
  $oneWeekFromNow.setDate($todaysDate.getDate() + 7)
  $oneWeekFromNow = $oneWeekFromNow.toISOString().slice(0,10)
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
  $('.input-group.date').datepicker({
    format: "yyyy-mm-dd",
    weekStart: 1,
    startDate: $todaysDate,
    endDate: $oneWeekFromNow,
    maxViewMode: 0,
    todayBtn: true,
    autoclose: true,
    todayHighlight: true
});

</script>
<script type="text/javascript">
  $('#BookingModal').on('show.bs.modal', function (event) {
  var link = $(event.relatedTarget) // Button that triggered the modal
  var room = link.data('room') // Extract info from data-* attributes
  var time = link.data('time')
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  modal.find('.modal-body #time').val(time)
  modal.find('.modal-body #room').val(room)
  modal.find('.modal-body #date').val('{{$date}}')
})
</script>
@endsection