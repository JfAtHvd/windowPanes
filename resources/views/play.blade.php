@extends('layouts.master')

@section('title')
    WindowPanes | Play
@endsection
		
@section('content')
    
	<div class="text-center">
		<div id="winReport">Click and drag within grid of colored squares to select an area.
			Click "Flip" to flip your selection.</div>
		<!--<button id="btnStart" class="btn btn-primary btn-lg" class="writing">Start New Game</button>-->
		<h2 id="levelLabel"></h2>
		<!--<div id="displayFlip" class="writing">No selection</div>-->
	<!--</div>-->
		<div id="puzzleFlip"></div>
	<!--<div class="text-center">-->
		<div id="gameControls">
			<button id="btnFlip" class="btn btn-primary btn-lg" class="writing">Flip</button>
			<button id="btnReset" class="btn btn-primary btn-lg" class="writing">Reset</button>
			<span id="timerSpan"></span>
		</div>
		<!--<div id="winReport"></div>-->
	</div>
	@auth
		<form id="saveDataForm" method='POST' action='/save' class="invisible">
			{{ csrf_field() }}
            <input type='text' name='level' id='level'>
            <input type='text' name='solve_time' id='solve_time'>
            <input type='text' name='total_solve_time' id='total_solve_time'>
			<input type='text' name='pattern_json' id='pattern_json'>
			<input type='text' name='level_json' id='level_json'>
		</form>
		<div id="userLoginTrue"></div>
		@if($new)
            <div id="newGameTrue"></div>
        @endif
	@endauth
@endsection

@push('body')
	<script type="text/javascript" src="/js/windowPanes.js"></script>
@endpush

