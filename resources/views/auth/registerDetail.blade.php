@extends('layouts.user.layout')
@section('content')
    <div class="box login-box">
      <div class="login-box-head">
        <h1>Register</h1>
      </div>
      <div class="login-box-body">
        <table class="table table-no-border">
          <tbody>
            <tr>
              <th>Name</th>
              <td>{{ $name }}</td>
            </tr>
            <tr>
              <th>E-mail</th>
              <td>{{ $email }}</td>
            </tr>
            <tr>
              <th>Password</th>
              <td>{{ $password }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="login-box-footer">
        <div class="text-right">
            <form action="{{ Url('successRegister') }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="name" value="{{ $name }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <input type="hidden" name="password" value="{{ $password }}">
                <a href="{{ Url('/register') }}" class="btn btn-default">Back</a>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
        </div>
      </div>
    </div>
@endsection