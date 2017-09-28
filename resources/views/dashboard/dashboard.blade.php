<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Dashboard - Analytics</title>

    <meta name="viewport" content="width=device-width  , initial-scale=1">
    <meta name="viewport" content="height=device-height, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/main.css') }}">

    @yield('substyles')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.min.js"></script>
</head>

<body class="container-fluid">
    
    <div class="row header">
        <div id="appName" class="col-md-4 col-md-offset-4">
            <span><span class="glyphicon glyphicon-leaf"></span> {{ env('APP_NAME') }}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <span id="txtDashboard">Dashboard</span>
        </div>
    </div>
    <div class="panel panel-success app-panel" id="dashboardMessage">
        <div class="panel-body" id="body">
            <div id="bodyLabel"><span class="glyphicon glyphicon-th-large"></span>   Viewing Options</div>
            <ul class="nav nav-pills" id="viewFrequencyList">
                <li role="presentation" {{ $frequency == 1 ? 'class=active' : '' }}><a {{ $frequency != 1 ? 'href='.url('/dashboard?frequency=1') : '' }}>Daily</a></li>
                <li role="presentation" {{ (isset($frequency) && $frequency == 2) ? 'class=active' : ''}}><a {{ $frequency != 2 ? 'href='.url('/dashboard?frequency=2') : '' }}>Weekly</a></li>
                <li role="presentation" {{ (isset($frequency) && $frequency == 3) ? 'class=active' : ''}}><a {{ $frequency != 3 ? 'href='.url('/dashboard?frequency=3') : '' }}>Monthly</a></li>
            </ul>
        </div>
    </div>
    <div class="panel panel-success app-panel">
        <div class="panel-body">
            <div class="row">
                <div id="colCarbon" class="col-md-4">
                    <span class="chart-title"><span class="glyphicon glyphicon-tree-deciduous"></span>   Carbon Dioxide</span>
                    {!! $carbon->render() !!}
                </div>
                <div id="colHumidity" class="col-md-4">
                    <span class="chart-title"><span class="glyphicon glyphicon-tint"></span>   Humidity</span>
                    {!! $humidity->render() !!}
                </div>
                <div id="colTemperature" class="col-md-4">
                    <span class="chart-title"><span class="glyphicon glyphicon-cloud"></span>   Temperature in C</span>
                    {!! $temperature->render() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-success app-panel">
       {{--  <div class="panel-body">
            <label class="checkbox-inline">
                <input type="checkbox" value="1" checked>Arduino 1
            </label>
            <label class="checkbox-inline">
                <input type="checkbox" value="2" checked>Arduino 2
            </label>
        </div> --}}
        <table class="table table-striped table-bordered">
            <thead>
                @if($frequency != 3)
                    <th>Date</th>
                    <th>Time</th>
                @else
                    <th>Month</th>
                @endif
                <th>Arduino No.</th>
                <th>CO2 in PPM</th>
                <th>Humidity</th>
                <th>Temperature (C)</th>
            </thead>
            <tbody>
                @foreach($arduinodata as $item)
                    <tr>
                        @if($frequency != 3)
                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('M d, Y') }}</td>
                            <td>{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('h:i a') }}</td>
                        @else
                            <td>{{ $item->created_at }}</td>
                        @endif
                        <td>{{ $item->arduino_id }}</td>
                        <td>{{ $item->ppm }}</td>
                        <td>{{ $item->humidity }}</td>
                        <td>{{ $item->temp_in_c }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="server-time">
        {{ 'Today is '.Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'))->format('M d, Y') }}
    </div>

    <script src="{{ asset('js/jquery-3.2.1.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>

    {{-- my js --}}
    <script>
        // $('#chrCarbon').click(function() {
        //     $('#colCarbon').toggleClass('col-md-4');
        //     $('#colCarbon').toggleClass('col-md-12');
        // });

        // $('#chrHumidity').click(function() {
        //     $('#colHumidity').toggleClass('col-md-4');
        //     $('#colHumidity').toggleClass('col-md-12');
        // });

        // $('#chrTemperature').click(function() {
        //     $('#colTemperature').toggleClass('col-md-4');
        //     $('#colTemperature').toggleClass('col-md-12');
        // });
    </script>

</body>

</html>