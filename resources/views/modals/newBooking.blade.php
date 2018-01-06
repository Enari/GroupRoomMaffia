@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.css" rel="stylesheet">
@endpush
@push('modals')
<div class="modal fade" id="newBookingModal" tabindex="-1" role="dialog" aria-hidden="true">
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
@endpush
@push('scripts')
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
@endpush