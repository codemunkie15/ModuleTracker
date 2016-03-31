@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Module</div>

                    <div class="panel-body">
                        @if(count($modules) > 0)
                            @if(session('module_success_message'))
                                <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('module_success_message') }}</div>
                            @endif
                            <table class="table table-hover sortable" width="100%">
                                <thead>
                                <tr>
                                    <th>Module Code</th>
                                    <th>Module Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($modules as $module)
                                    <tr>
                                        <td>{{ $module->module_code }}</td>
                                        <td>{{ $module->module_name }}</td>
                                        <td><a href="{{ url('') }}">Edit</a> | <a href="{{ url('') }}">Delete</a></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            You don't have any modules to edit.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Assignment</div>

                    <div class="panel-body">
                        @if(count($assignments) > 0)

                        @else
                            You don't have any assignments to edit.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
