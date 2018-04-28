@extends('layouts.master')

@section('content')
    @if(Auth::check())
        <div>Player's name goes here</div>
        <a href="{{ action('PuzzleController@play') }}">Play</a>
        <div>Player's highest level goes here</div>
        <div>Player's fastest times go here</div>
    @else
        <a href="{{ route('login') }}">Login</a>
        <a href="{{ route('register') }}">Register</a>
        <a href="{{ action('PuzzleController@play') }}">Play as Guest</a>
    @endif
@endsection
