@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Whole year grade
                    </div>

                    <div class="panel-body">
                        @if(session('success_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('success_message') }}</div>
                        @endif
                        <p>Here you can view your overall marks for each of your modules and your overall year grade (year classification). Obviously it will only be accurate if you input all your marks for the year, so if you haven't completed all your assignments yet it will show an incomplete percentage.</p>
                        <div class="checkbox">
                            <form method="POST" action="{{ route('post.drop_module') }}">
                                {{ csrf_field() }}
                                <label>
                                    <input type="checkbox" name="drop_module" onchange="this.form.submit()" {{ (Auth::user()->drop_module == 1) ? 'checked' : '' }}> <b>Don't include my lowest mark module (excluding double credit modules)</b>
                                </label>
                            </form>
                        </div>
                        @if(count($modules) > 0)
                            <table class="table table-hover sortable" width="100%">
                                <thead>
                                <tr>
                                    <th>Module Code</th>
                                    <th>Module Name</th>
                                    <th>Credits</th>
                                    <th>Overall Mark</th>
                                </tr>
                                </thead>
                                <tbody>
                            @foreach($modules as $module)
                                <tr{{ ($module->id == $worst_id) ? ' class=strike' : '' }}>
                                    <td>{{ $module->module_code }}</td>
                                    <td>{{ $module->module_name }}</td>
                                    <td>{{ $module->credits }}</td>
                                    <td>{{ $module->overallMark() }}%</td>
                                </tr>
                            @endforeach
                                </tbody>
                            </table>
                            <div class="total">Total Mark For Year: {{ $year_total }}% {{ $year_class }}</div>
                            <div class="total">Total Mark Not Including 0%'s: {{ $year_total_no_zero }}% {{ $year_class_no_zero }}</div>
                        @else
                            You don't have any modules or assignments yet.<br>You can add some by <a href="{{ url('/add') }}">clicking here</a>.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
