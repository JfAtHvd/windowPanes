@extends('layouts.master')

@section('content')
    <div class="text-center">
		@if(Auth::check())
			<div>Player's name goes here</div>
			<a href="{{ action('PuzzleController@play') }}" class="btn btn-primary btn-lg">Play</a>
			<div>Player's highest level goes here</div>
			<div>Player's fastest times go here</div>
		@else
			<a href="{{ action('PuzzleController@play') }}" class="btn btn-primary btn-lg">Play as Guest</a>
			<h2>Link for Demo Video</h2>
		@endif
    </div>
@endsection
