@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Add New Module</div>

                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('/modules/add_modules') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input type="text" name="module_code" class="form-control" placeholder="Module Code">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <input type="text" name="module_name" class="form-control" placeholder="Module Name">
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
                        <form role="form" method="POST" action="{{ url('/modules/add_modules') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="module" class="form-control">
                                            <option value="null" disabled hidden selected>Choose a module...</option>
                                            <option value="1">Module 1</option>
                                            <option value="2">Module 2</option>
                                            <option value="3">Module 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" name="assignment_name" class="form-control" placeholder="Assignment Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="assignment_percentage" class="form-control" placeholder="Percentage of marks e.g. 40">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-group">
                                        <input type="text" name="assignment_name" class="form-control" placeholder="Deadline e.g. 15/05/2016">
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success float-right" value="Add Assignment">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
