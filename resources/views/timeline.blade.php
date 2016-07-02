@extends('layouts.app')

@section('content')
    <h1>Timeline</h1>
    <p>
    <form action="{{ action('TweetController@createTweet') }}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
            <textarea name="tweet" class="form-control" rows="3" placeholder="Say something"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Tweet</button>
    </form>
    </p>

    <p>
    @foreach ($tweets as $tweet)
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-unstyled">
                    <li><strong>{{ $tweet['username'] }}</strong></li>
                    <li>{{ $tweet['body'] }}</li>
                    <li>{{ date('Y-m-d H:i:s', $tweet['time']) }}</li>
                </ul>
            </div>
        </div>
    @endforeach
    </p>
@stop