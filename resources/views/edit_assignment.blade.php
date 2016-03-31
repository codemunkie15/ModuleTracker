@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Assignment</div>

                    <div class="panel-body">
                        @if(count($assignment) > 0)
                            @if(count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            @if(session('assignment_success_message'))
                                <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('assignment_success_message') }}</div>
                            @endif
                            <form role="form" method="POST" action="{{ route('editAssignment') }}">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select name="module_id" class="form-control">
                                                <option value="null" disabled hidden selected>Choose a module...</option>
                                                @foreach($modules as $module)
                                                    <option value="{{ $module->id }}" {{ ($assignment->module_id == $module->id) ? 'selected' : '' }}>{{ '[' . $module->module_code . '] ' . $module->module_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="form-group">
                                            <input type="text" name="assignment_name" class="form-control" placeholder="Assignment Name" value="{{ (Request::old('assignment_name') == "") ? $assignment->assignment_name : Request::old('assignment_name') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="assignment_percentage" class="form-control" placeholder="Percentage of marks e.g. 40" value="{{ (Request::old('assignment_percentage') == "") ? $assignment->mark_percentage : Request::old('assignment_percentage') }}">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <input type="text" name="assignment_deadline" class="form-control" placeholder="Deadline e.g. 15-05-2016" value="{{ (Request::old('assignment_deadline') == "") ? $assignment->deadline : Request::old('assignment_deadline') }}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="assignment_id" value="{{ $assignment->id }}">
                                <div class="form-inline float-right">
                                    <div class="form-group">
                                        <a class="btn btn-danger" href="{{ url('delete/assignment/'.$assignment->id) }}" role="button">Delete Assignment</a>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="Edit Assignment">
                                    </div>
                                </div>
                            </form>
                        @else
                            This assignment doesn't exist.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
