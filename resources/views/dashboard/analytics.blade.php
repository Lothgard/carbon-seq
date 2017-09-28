@extends('dashboard.main') 

@section('substyles')
    <style>
        #dropdownGroup
        {
            margin-left: 20px;    
            margin-right: 20px;
        }

        #btnDataValue, #btnFrequency
        { 
            display: block;
            padding: 10px;
            margin-bottom: 20px;
            background-color: transparent;
            border-style: none;
            border-bottom: 1px solid white;
            color: white;
            text-decoration: none;
        }

        #btnDataValue:hover, #btnFrequency:hover
        {
            text-decoration: none;
            cursor: pointer;
        }

        #btnDataValue > span { }

        #dropdownMenu
        {
            background-color: #363636;
        }

        #dropdownMenu a
        {
            color: white;
        }

        #dropdownMenu a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            cursor: pointer;
        }

        #chartTitle {
            display: inline-block;
            padding: 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
            background-color: #212121;
        }

    </style>
@endsection

@section('sidebar')
    @parent
    <hr>

    <div>
        <span class="heading">Showing</span>
    </div>

    <div class="dropdown" id="dropdownGroup">
        <a type="button" id="btnDataValue" data-toggle="dropdown" aria-hashpopup="true" aria-expanded="true">
            <b>Carbon Dioxide</b>
        </a>
        
        <ul class="dropdown-menu" id="dropdownMenu" aria-labelledby="btnDataValue">
            <li><a>Temperature</a></li>
            <li><a>Humidity</a></li>
        </ul>
    </div>

    <div class="dropdown" id="dropdownGroup">
        <a type="button" id="btnFrequency" data-toggle="dropdown" aria-hashpopup="true" aria-expanded="true">
            <b>Daily</b>
        </a>
        
        <ul class="dropdown-menu" id="dropdownMenu" aria-labelledby="btnFrequency">
            <li><a>Weekly</a></li>
            <li><a>Monthly</a></li>
        </ul>
    </div>
@endsection

@section('content')
    <div class="h3" id="chartTitle">Daily Carbon Dioxide</div>
    <div>{!! $carbon->render() !!}</div>
@endsection