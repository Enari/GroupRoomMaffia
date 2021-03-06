@extends('layouts.master')
@include('modals.newBooking')
@section('title', 'Group Room Maffia')
@section('content')
<div class="row mb-2 ">
    <div class="col-sm-6 mr-auto">
      <h1>Schedulled Bookings</h1>
    </div>
    <div class="col-sm-1">
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newBookingModal" title="Add Category">Add</button>
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
            <th>Recurring</th>
            <th>Result</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
@if($bookings->isEmpty())
             <tr><td colspan="8">No schedulled bookings</td></tr>
@else
  @foreach ($bookings as $booking)
    <tr>
      <td>{{ $booking->date }}</td>
      <td>{{ HelperFunctions::bookingIntervallToTime($booking->time) }}</td>
      <td>{{ $booking->room }}</td>
      <td>{{ $booking->booker }}</td>
      <td>{{ $booking->message }}</td>
      <td><input type="checkbox" data-id="{{ $booking->id}}"{{ $booking->recurring ? " checked" : ""}}></label></td>
      <td>{{ $booking->result }}</td>
      <td>
        <a href="{{ action('SchedulledBookingsController@addNextWeek', $booking->id) }}" role="button" class="btn btn-primary btn-sm" title="New next week from this">
          <span class="fa fa-arrow-down" aria-hidden="true"/>
        </a>
        <a href="{{ action('SchedulledBookingsController@delete', $booking->id) }}" role="button" class="btn btn-danger btn-sm" title="Delete">
          <span class="fa fa-trash" aria-hidden="true"/>
        </a>
      </td>
    </tr>
  @endforeach
@endif
    </tbody>
</table>
</div>
@endsection
@push('scripts')
<script type="text/javascript">
  $(document).ready(function(){
    $("input:checkbox").change(function() { 
      var isChecked = (this.checked) ? 1:0; 
      //console.log('Checkbox ' + $(this).data("id") + ' is ' +isChecked)
      $.ajax({
        url: '/schedulled',
        type: 'POST',
        data: {_token: "{{ csrf_token() }}", id: $(this).data("id"), checked: (this.checked)}
      });
    });        
  });
</script>
@endpush
