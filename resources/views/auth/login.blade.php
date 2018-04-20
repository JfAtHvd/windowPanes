@extends('layouts.app')

@section('content')
	<form id='login' method="POST" action="/login">

        {{ csrf_field() }}

        <label for="email">E-Mail Address</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        @if($errors->has('email'))
            <div class="error">{{ $errors->first('email') }}</div>
        @endif

        <label for="password">Password</label>
        <input id="password" type="password"name="password" required>
        @if ($errors->has('password'))
            <div class="error">{{ $errors->first('email') }}</div>
        @endif

        <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me</label>

        <br>
        <button type="submit" class="btn btn-primary">Login</button>

        <a class="btn btn-link" href="/password/reset">Forgot Your Password?</a>

    </form>
@endsection
