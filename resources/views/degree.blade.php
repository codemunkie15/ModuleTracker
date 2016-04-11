@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Degree classification calculator
                    </div>

                    <div class="panel-body">
                        <form method="POST">
                            <div class="form-group">
                                <table class="table table-hover year-list sortable" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="50%">Year Name</th>
                                        <th width="25%">Year Percentage</th>
                                        <th width="25%">Year Mark</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>Current Year</td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="year[0][percentage]" placeholder="60" value="{{ Request::old('year[0][percentage]') }}">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="year[0][mark]" value="{{ Request::old('year[0][mark]') }}">
                                                <div class="input-group-addon">%</div>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <input type="submit" class="btn btn-success float-right" value="Calculate classification">
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
                    <div class="panel-heading">
                        Add previous year marks
                    </div>

                    <div class="panel-body">
                        @if(count($errors->years) > 0)
                            <div class="alert alert-danger">
                                @foreach($errors->years->all() as $error)
                                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {{ $error }}<br>
                                @endforeach
                            </div>
                        @endif
                        @if(session('years_success_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('module_success_message') }}</div>
                        @endif
                        <p>Add previous year marks to work out your degree classification. When you have added a previous year it will show up and be included above.</p>
                        <form role="form" method="POST" action="{{ route('addNewModule') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <input type="text" name="year_name" class="form-control" placeholder="Name of year e.g. Second Year" value="{{ Request::old('year_name') }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="year_percentage" class="form-control" placeholder="Year percentage e.g. 40" value="{{ Request::old('year_percentage') }}">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <div class="input-group">
                                            <input type="text" name="year_mark" class="form-control" placeholder="Year mark e.g. 72" value="{{ Request::old('year_mark') }}">
                                            <div class="input-group-addon">%</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-success float-right" value="Add year mark">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
