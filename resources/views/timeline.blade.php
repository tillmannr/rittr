@extends('layouts.app')

@section('content')
    @foreach ($tweets as $tweet)
        <div class="panel panel-default">
            <div class="panel-body">
                {{ $tweet['username'] }}
                {{ $tweet['body'] }}
                {{ $tweet['time'] }}
            </div>
        </div>
    @endforeach
@stop