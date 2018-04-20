@extends('layouts.app')

@section('content')
<h1>Reset Password</h1>

	<form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
		{{ csrf_field() }}

	    <input type="hidden" name="token" value="{{ $token }}">

		<label for="email" class="col-md-4 control-label">E-Mail Address</label>

		<input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

		@if ($errors->has('email'))
			<div class="error">{{ $errors->first('email') }}</div>
		@endif

		<label for="password" class="col-md-4 control-label">Password</label>

		<input id="password" type="password" class="form-control" name="password" required>

		@if ($errors->has('password'))
			<div class="error">{{ $errors->first('password') }}</div>
		@endif

		<label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
		<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

		@if ($errors->has('password_confirmation'))
			<div class="error">{{ $errors->first('password_confirmation') }}</div>
		@endif

		<button type="submit" class="btn btn-primary">
			Reset Password
		</button>
	</form>
@endsection
