@extends('layouts.master')
@include('modals.newBooking')
@section('title', 'Group Room Maffia')
@section('content')
<div class="row mb-2 ">
    <div class="col-sm-6 mr-auto"><h1>All Bookings</h1></div>
    <div class="col-sm-1">
      <label for="date" class="col-form-label">Date:</label>
    </div>
    <div class="col-sm-3">
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
      @if($cell["text"] == "Free")
        <td><div class="text-center"><a href="#" style="color: #00f000;" data-toggle="modal" data-target="#newBookingModal" data-room="{{ $row[0]["text"] }}" data-time="{{ $i-1 }}">Free</a></div></td>
      @else
          <td data-container="body" data-toggle="popover" data-placement="top" data-content="{{ array_key_exists("toltip", $cell) ?  $cell["toltip"] : '' }}">
        @if($friends->firstWhere('mdhUsername', $cell["text"]) != NULL)
            <div class="text-center text-white" style="border-radius: 5px; background-color: {{ $friends->firstWhere('mdhUsername', $cell["text"])->color }}">{{ $cell["text"] }}</div>
        {{-- If it's a teacher who made the booking make the name red. --}}
        @elseif(strlen($cell["text"]) == 5) 
          <div class="text-center" style="color:red;">{{ $cell["text"] }}</div>
        {{-- Trying to match multiple teachers on one booking and make thier names red. --}}
        @elseif(preg_match('/[a-z]{3}[0-9]{2}\D/', $cell["text"], $matches, PREG_OFFSET_CAPTURE) == 1)
          <div class="text-center" style="color:red;">{{ $cell["text"] }}</div>
        @else
          <div class="text-center">{{ $cell["text"] }}</div>
        @endif
          </td>
      @endif
    @endforeach
    </tr>
  @endforeach
@endunless
    </tbody>
</table>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover({trigger: 'hover'})
});
</script>
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
<script type="text/javascript">
  $('#newBookingModal').on('show.bs.modal', function (event) {
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
@endpush