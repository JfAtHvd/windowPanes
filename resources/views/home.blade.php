@extends('layouts.master')

@section('content')
    <div class="text-center">
		@if(Auth::check())
			<div>Player's name goes here: {{ $user["name"] }}</div>
			<a href="{{ action('PuzzleController@playNew') }}" class="btn btn-primary btn-lg">Play</a>
			<div>Player's highest level goes here: {{ $user["highest_level"] }}</div>
			<div>
			Player's fastest times go here: {{ $user["fastest_times_json"] }}
			</div>
		@else
			<a href="{{ action('PuzzleController@play') }}" class="btn btn-primary btn-lg">Play as Guest</a>
			<h2>Link for Demo Video</h2>
		@endif
    </div>
@endsection
