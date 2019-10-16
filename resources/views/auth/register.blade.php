@extends('layouts.user.layout')
@section('content')
      <form action="{{ Url('detailRegister') }}" method="POST">
        {{ csrf_field() }}

          <div class="box login-box">
              <div class="login-box-head">
                  <h1 class="mb-5">Register</h1>
                  <p class="text-lgray">Please fill the information below...</p>
                  @if (isset($error))
                    <small class="text-danger text-small">{{ $error }}</small>
                  @endif
                </div>
                <div class="login-box-body">
                @error('name')
                <p>{{$message}}</p>
                @enderror
                    <div class="form-group">
                        <input type="text" class="form-control" value="" placeholder="Name" name="name">
                    </div>
                
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="E-mail" name="email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Password" name="password">
                    </div>
                </div>
                <div class="login-box-footer">
                    <div class="text-right">
                        <a href="{{ Url('/') }}" class="btn btn-default">Back</a>
                        <button type="submit" class="btn btn-primary">Confirm</button>
                    </div>
                </div>
            </div>
        </form>
 @endsection