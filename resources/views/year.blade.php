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
                                <tr>
                                    <td>{{ $module->module_code }}</td>
                                    <td>{{ $module->module_name }}</td>
                                    <td>{{ $module->credits }}</td>
                                    <td>{{ $averages[$module->id] }}%</td>
                                </tr>
                            @endforeach
                                </tbody>
                            </table>
                        @else
                            You don't have any modules or assignments yet.<br>You can add some by <a href="{{ url('/add') }}">clicking here</a>.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
