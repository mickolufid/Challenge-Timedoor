@extends('users.layouts.layout')
@section('content')
  <form action="{{ route('loginSubmit') }}" method="POST">
    {{ csrf_field() }}
    <div class="box login-box">
      <div class="login-box-head">
        <h1 class="mb-5">Login</h1>
        <p class="text-lgray">Please login to continue...</p>

      </div>
      <div class="login-box-body">
		@if (session()->has('error'))
            <p class="small text-danger">{{ session('error') }}</p>
        @endif
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}">
          @error('email')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" name="password" value="{{ old('password') }}">
          @error('password')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="login-box-footer">
        <div class="text-right">
          <a href="{{ Url('/') }}" class="btn btn-default">Back</a>
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>
    </div>
  </form>
@endsection