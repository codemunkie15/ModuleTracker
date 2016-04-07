@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>

                <div class="panel-body">
                    Module Tracker is a website designed to help you keep track of your modules in school or university. You can add your modules, assignments, predicted grades and current percentages and the website will work out what you need to get for each assignment and let you know if you're on track etc.
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Inside Look</div>

                <div class="panel-body">
                    <img src="{{ asset('bootstrap/img/screenshot.png') }}" class="img-responsive">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
