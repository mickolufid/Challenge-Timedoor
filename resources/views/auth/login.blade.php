<html>

<head>
  <title>Timedoor Challenge - Level 8 | Login</title>

  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/tmdrPreset.css">
  <!-- CSS End -->

  <!-- Javascript -->
  <script type="text/javascript" src="assets/js/jquery.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <!-- Javascript End -->
</head>

<body id="login">
  <form action="{{route('login')}}" method="POST">
    {{ csrf_field() }}
    <div class="box login-box">
      <div class="login-box-head">
        <h1 class="mb-5">Login</h1>
        <p class="text-lgray">Please login to continue...</p>

      </div>
      <div class="login-box-body">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Email" name="email">
          @error('email')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" name="password">
          @error('password')
          <small class="text-danger">{{ $message }}</small>
          @enderror
        </div>
      </div>
      <div class="login-box-footer">
        <div class="text-right">
          <a href="/" class="btn btn-default">Back</a>
          <button type="submit" class="btn btn-primary">Login</button>
        </div>
      </div>
    </div>
  </form>
</body>

</html>