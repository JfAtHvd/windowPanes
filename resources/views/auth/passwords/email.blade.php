@extends('layouts.master')

@section('content')
<h2 class="text-center">Reset Password</h2>

	@if (session('status'))
		<div class="alert alert-success">
			{{ session('status') }}
		</div>
	@endif
    <div class="text-center">
		<div class="form-group">
			<form method="POST" action="{{ route('password.email') }}">
				{{ csrf_field() }}

					<label for="email" class="col-md-4 control-label">E-Mail Address</label>

					<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

					@if ($errors->has('email'))
						<div class="error">{{ $errors->first('email') }}</div>
					@endif
				</div>

				<button type="submit" class="btn btn-primary btn-lg">
					Send Password Reset Link
				</button>
			</form>
		</div>
	</div>
@endsection
