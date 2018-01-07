@extends('layouts.master')
@section('title', 'Group Room Maffia')
@section('content')
<div class="row mb-2 ">
  <div class="col-sm-4 mr-auto">
    <h1>Friends</h1>
  </div>
  <div class="col-sm-1">
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addFriendModal">Add</button>
  </div>
</div>
<div class="table">
<table class="table table-bordered table-striped table-hover table-fixed">
  <thead>
    <tr>
      <th> Friend </th>
      <th> MDH Username </th>
      <th> Color </th>
      <th> Actions </th>
    </tr>
  </thead>
  <tbody>
@if ($friends->count() == 0)
    <tr><td colspan="4">You have no friends</td></tr>
@else
@foreach($friends as $friend)
    <tr>
      <td>{{ $friend->name }}</td>
      <td>{{ $friend->mdhUsername }}</td>
      <td><samp>{{ $friend->color }}</samp></td>
      <td><a href="{{ action('FriendsController@delete', $friend->id) }}">
      <button type="button" class="btn btn-danger btn-sm" title="Delete">
      <span class="fa fa-trash" aria-hidden="true"/>
      </button></a></td>
    </tr>
@endforeach
@endif
  </tbody>
</table>
</div>
{{-- Modal --}}
<div class="modal fade" id="addFriendModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
    <div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Add Friend</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
    </div>
    <div class="modal-body">
    <form id="addFriendForm" method="post">
      {{ csrf_field() }}
      <div class="form-group">
        <label for="name" class="col-form-label">Name:</label>
        <input type="text" class="form-control" id="name" name="name"></input>
      </div>
      <div class="form-group">
        <label for="mdhUsername" class="col-form-label">MDH Username:</label>
        <input type="text" class="form-control" id="mdhUsername" name="mdhUsername"></input>
      </div>
      <div class="form-group">
        <label for="color" class="col-form-label">Color:</label>
        <input type="text" class="form-control" id="color" name="color"></input>
      </div>
    </form>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" form="addFriendForm" value="Submit" class="btn btn-primary">Add Friend</button>
    </div>
  </div>
  </div>
</div>
@endsection
