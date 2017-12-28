@extends('layouts.master')
@section('title', 'Group Room Maffia - Login')
@section('content')
<div class="card" style="width: 20rem;">
  <div class="card-body">
    <h4 class="card-title">Login</h4>
        <form method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="username" class="control-label">Username</label>
                    <input id="username" type="text" class="form-control{{ $errors->has('login') ? ' is-invalid' : ''}}" name="username" value="{{ old('username') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input id="password" type="password" class="form-control{{ $errors->has('login') ? ' is-invalid' : ''}}" name="password" required>
            </div>

            <div class="form-group">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>
    </div>
</div>
@endsection
