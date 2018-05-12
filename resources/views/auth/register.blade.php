@extends('layouts.master')

@section('content')

	<div class="text-center">
        <div class="form-group">
			<form method="POST" id='register' action="{{ route('register') }}" class="form-horizontal">

				{{ csrf_field() }}

				<p>* Required fields</p>

				<label for="name" class="control-label">* User Name</label>
				<input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" required autofocus><br/>
				@if($errors->has('name'))
					<div class="error">{{ $errors->first('name') }}</div><br/>
				@endif
			
				<label for="email" class="control-label">* E-Mail Address</label>
				<input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required><br/>
				@if ($errors->has('email'))
					<div class="error">{{ $errors->first('email') }}</div><br/>
				@endif

				<label for="password" class="control-label">* Password (min: 6)</label>
				<input id="password" type="password" name="password" class="form-control" required><br/>
				@if ($errors->has('password'))
					<div class="error">{{ $errors->first('password') }}</div><br/>
				@endif

				<label for="password-confirm" class="control-label">* Confirm Password</label>
				<input id="password-confirm" type="password" name="password_confirmation" class="form-control" required>

				<br>
				<button type="submit" class="btn btn-primary btn-lg">Register</button>
			</form>
		</div>
	</div>
@endsection
