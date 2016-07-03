@extends('layouts.app')

@section('content')
    <h1>Login</h1>
    <form action="{{ action('AuthController@login') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="userName">Username</label>
            <input name="userName" type="text" class="form-control" id="userName" placeholder="Username">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Password">
        </div>
        <button type="submit" class="btn btn-default">Submit</button> or <a href="{{ action('AuthController@showRegistrationForm') }}">Register</a>
    </form>
@stop