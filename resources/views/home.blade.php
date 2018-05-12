@extends('layouts.master')

@section('content')
    <div class="text-center">
		@if(Auth::check())
			<h3>{{ $user["name"] }}</h3>
			<a href="{{ action('PuzzleController@playNew') }}" class="btn btn-primary btn-lg">Play</a><br/>
			@if($user["highest_level"])
				<strong>Highest level:</strong></br>
				<span>{{ $user["highest_level"] }}</span></br>
            @endif
			@if($fastestTimes[0] != "")
				<strong>Fastest times:</strong><br/>
				@for($i = 0; $i <sizeof($fastestTimes); $i++)
					<span>{{  "Level ".($i + 1)." - ".$fastestTimes[$i]  }}</span><br/>
				@endfor
			@endif
		@else
			<a href="{{ action('PuzzleController@play') }}" class="btn btn-primary btn-lg">Play as Guest</a><br/>
			<h2>Watch a Demonstration Video</h2>
			<iframe width="560" height="315" src="https://www.youtube.com/embed/grdeFnb8LAE?rel=0&amp;showinfo=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		@endif
    </div>
@endsection
