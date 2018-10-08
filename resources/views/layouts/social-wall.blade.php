<!DOCTYPE html>
<html>
  <head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/vnd.microsoft.icon" href="/favicon.ico">

    <link rel="stylesheet" type="text/css" href="/css/app.css">

    <title>OpenText Enterprise World - Social Wall</title>

  </head>
  <body class="social-wall">

    <div id="app">

      <div class="container-fluid">

        <div class="row">
          <div
            class="
              col-xs-12
              col-sm-12
              col-md-12
              col-lg-12
            "
          >
            <div class="social-wall-header text-center">
              <img
                class="social-wall-header-logo"
                src="/images/opentext-logos/OpenText-Logo-2017.png"
              >
              |
              The EW Games
            </div>
          </div>
        </div>

        <div class="row">
          <div
            class="
              col-xs-12
              col-sm-12
              col-md-12
              col-lg-12
            "
          >
            @yield('content')
          </div>
        </div>

      </div>

    </div>

    <script src="{{ mix('js/app.js') }}"></script>
    @yield('js-static')
    @yield('script')

  </body>
</html>
