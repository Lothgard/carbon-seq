<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Dashboard - Analytics</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="height=device-height, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap-theme.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">

    @yield('substyles')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>

</head>

<body class="container-fluid">
    <main class="row">
        <div class="col-md-2 full-height clean-padding"  id="sidebar">
            @section('sidebar')
                <div>
                    <span class="h3" id="applicationName">{{ env('APP_NAME') }}</span>
                </div>
                <div id="navigation">
                    <a class="h4" href="{{ url('/dashboard/analytics') }}"><i class="glyphicon glyphicon-signal"></i>Analytics</a>
                    <a class="h4"><i class="glyphicon glyphicon-list"></i>Data</a>
                </div>
            @show
        </div>
        <div class="col-md-10 full-height" id="content">
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

</body>

</html>