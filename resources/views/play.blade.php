@extends('layouts.master')

@section('title')
    WindowPanes | Play
@endsection
		
@section('content')
	<p>Click and drag within grid of colored squares to select an area.
		Click "Flip" to flip your selection.</p>
	<button id="btnStart" class="btn btn-primary" class="writing">Start New Game</button>
	<h2 id="levelLabel"></h2>
	<div id="displayFlip" class="writing">No selection</div>
	<div id="puzzleFlip"></div>
	<button id="btnFlip" class="btn btn-primary" class="writing">Flip</button>
	<button id="btnReset" class="btn btn-primary" class="writing">Reset</button>
@endsection

@push('body')
	<script type="text/javascript" src="/js/windowPanes.js"></script>
@endpush

