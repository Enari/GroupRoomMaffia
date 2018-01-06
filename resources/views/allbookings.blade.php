@extends('layouts.master')
@include('modals.newBooking')
@section('title', 'Group Room Maffia')
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
        <td><a href="#" style="color: #00f000;" data-toggle="modal" data-target="#newBookingModal" data-room="{{ $row[0] }}" data-time="{{ $i-1 }}">Free</a></td>
      @else
        @if(in_array($cell, $friends))
          <td><div style="color:blue">{{ $cell }}</div></td>
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
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script type="text/javascript">

  $todaysDate = new Date()
  $oneWeekFromNow = new Date()
  $oneWeekFromNow.setDate($todaysDate.getDate() + 7)
  $oneWeekFromNow = $oneWeekFromNow.toISOString().slice(0,10)
  $todaysDate = $todaysDate.toISOString().slice(0,10)

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
@endpush