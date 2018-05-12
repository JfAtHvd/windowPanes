@extends('layouts.master')

@section('content')
<div class="text-center">
    <h1>Reset Password</h1>
    <div class="form-group">
		<form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
			{{ csrf_field() }}

			<input type="hidden" name="token" value="{{ $token }}">

			<label for="email" class="control-label">E-Mail Address</label>

			<input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

			@if ($errors->has('email'))
				<div class="error">{{ $errors->first('email') }}</div>
			@endif

			<label for="password" class="control-label">Password</label>

			<input id="password" type="password" class="form-control" name="password" required>

			@if ($errors->has('password'))
				<div class="error">{{ $errors->first('password') }}</div>
			@endif

			<label for="password-confirm" class="control-label">Confirm Password</label>
			<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

			@if ($errors->has('password_confirmation'))
				<div class="error">{{ $errors->first('password_confirmation') }}</div>
			@endif

			<button type="submit" class="btn btn-primary btn-lg">
				Reset Password
			</button>
		</form>
	</div>
</div>
@endsection
