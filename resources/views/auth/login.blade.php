@extends('layouts.master')

@section('content')
	<div class="text-center">
		<div class="form-group">
			<form id='login' method="POST" action="/login">

				{{ csrf_field() }}

				<label for="email" class="control-label">E-Mail Address</label>
				<input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control" required autofocus><br/>
				@if($errors->has('email'))
					<div class="error">{{ $errors->first('email') }}</div><br/>
				@endif

				<label for="password" class="control-label">Password</label>
				<input id="password" type="password"name="password" class="form-control" required><br/>
				@if ($errors->has('password'))
					<div class="error">{{ $errors->first('email') }}</div><br/>
				@endif

				<label class="control-label"><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</label><br/>

				<br>
				<button type="submit" class="btn btn-primary btn-lg">Login</button><br/>

				<a class="btn btn-link btn-lg" href="/password/reset">Forgot Your Password?</a>

			</form>
		</div>
    </div>
@endsection
