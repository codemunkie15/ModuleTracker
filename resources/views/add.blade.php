@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Module</div>

                    <div class="panel-body">
                        @if(count($errors->module) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->module->all() as $error)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        @if(session('module_success_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('module_success_message') }}</div>
                        @endif
                        <form role="form" method="POST" action="{{ route('addNewModule') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="module_code" class="form-control" placeholder="Module Code" value="{{ Request::old('module_code') }}">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="module_name" class="form-control" placeholder="Module Name" value="{{ Request::old('module_name') }}">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success float-right" value="Add Module">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Assignment</div>

                    <div class="panel-body">
                        @if(count($errors->assignment) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->assignment->all() as $error)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        @if(session('assignment_success_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('assignment_success_message') }}</div>
                        @endif
                        @if(count($modules) > 0)
                            <form role="form" method="POST" action="{{ route('addNewAssignment') }}">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select name="module_id" class="form-control">
                                                <option value="null" disabled hidden selected>Choose a module...</option>
                                                @foreach($modules as $module)
                                                    <option value="{{ $module->id }}" {{ (Request::old('module_id') == $module->id) ? 'selected' : '' }}>{{ '[' . $module->module_code . '] ' . $module->module_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="assignment_name" class="form-control" placeholder="Assignment Name" value="{{ Request::old('assignment_name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="assignment_percentage" class="form-control" placeholder="Assignment percentage e.g. 40" value="{{ Request::old('assignment_percentage') }}">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="assignment_mark" class="form-control" placeholder="Current mark e.g. 0" value="{{ Request::old('assignment_mark') }}">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="assignment_deadline" class="form-control" placeholder="Deadline e.g. 15-05-2016" value="{{ Request::old('assignment_deadline') }}">
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-success float-right" value="Add Assignment">
                            </form>
                        @else
                            You need to add a module before you can add any assignments.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
