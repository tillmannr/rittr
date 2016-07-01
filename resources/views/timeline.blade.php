@extends('layouts.app')

@section('content')
    <h1>Timeline</h1>
    <form action="{{ action('TweetController@createTweet') }}" method="POST">
        {{ csrf_field() }}
        <textarea name="tweet" class="form-control" rows="3" placeholder="Say something"></textarea>
        <button type="submit" class="btn btn-primary">Tweet</button>
    </form>

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