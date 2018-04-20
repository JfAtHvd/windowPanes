@extends('layouts.app')

@section('content')
<h1>Reset Password</h1>

	@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
	@endif

	<form method="POST" action="{{ route('password.email') }}">
		{{ csrf_field() }}

			<label for="email" class="col-md-4 control-label">E-Mail Address</label>

			<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

			@if ($errors->has('email'))
				<div class="error">{{ $errors->first('email') }}</div>
			@endif
		</div>

		<button type="submit" class="btn btn-primary">
			Send Password Reset Link
		</button>
	</form>
@endsection
