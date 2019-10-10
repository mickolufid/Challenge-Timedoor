<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- CSS -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">
  <link rel="stylesheet" type="text/css" href="assets/css/tmdrPreset.css">
  <!-- CSS End -->
  <!-- Javascript -->
  <script type="text/javascript" src="assets/js/jquery.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
  <!-- Javascript End -->
</head>

<body class="bg-lgray">
  <header>
    @include('layouts.header')
  </header>
  <main>
    @yield('content')
  </main>

  <footer>
    @include('layouts.footer')
  </footer>

  {{-- @include('template.script') --}}
  @yield('script')
</body>

</html>