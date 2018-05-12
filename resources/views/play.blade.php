@extends('layouts.master')

@section('title')
    WindowPanes | Play
@endsection
		
@section('content')
    
	<div class="text-center">
		<h2 id="levelLabel"></h2>
		<p>Click and drag down or right to select, then press Flip to flip your selection</p>
		<div id="puzzleFlip"></div>
		<div id="winReport" class="alert-success"></div>
		<div id="gameControls">
			<button id="btnFlip" class="btn btn-primary btn-lg" class="writing">Flip</button>
			<button id="btnReset" class="btn btn-primary btn-lg" class="writing">Reset</button>
			<span id="timerSpan"></span>
		</div>
	</div>
	@auth
		<form id="saveDataForm" method='POST' action='/save' class="invisible">
			{{ csrf_field() }}
            <input type='text' name='level' id='level'>
            <input type='text' name='solve_time' id='solve_time'>
            <input type='text' name='total_solve_time' id='total_solve_time'>
			<input type='text' name='pattern_json' id='pattern_json'>
			<input type='text' name='level_json' id='level_json'>
			<input type='text' name='puzzle_resets' id='puzzle_resets'>
			<input type='text' name='number_flips' id='number_flips'>
			<input type='text' name='total_number_flips' id='total_number_flips'>
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
