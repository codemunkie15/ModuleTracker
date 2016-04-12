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
                        @if(count($years) > 0)
                            <div class="errors-box"></div>
                            <div class="class-box"></div>
                            <form id="year_marks_form" method="POST" action="{{ route('calcClass') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <table class="table table-hover year-list sortable" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="50%">Year</th>
                                            <th width="25%">Year Percentage</th>
                                            <th width="25%">Year Mark</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($years as $year)
                                            <tr>
                                                <td>{{ $year->yearText() }}</td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="year[{{ $year->year }}][percentage]" value="{{ $year->year_percentage }}">
                                                        <div class="input-group-addon">%</div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" name="year[{{ $year->year }}][mark]" value="{{ $year->mark }}">
                                                        <div class="input-group-addon">%</div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>Current Year</td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="year[0][percentage]" value="{{ Request::old('year[0][percentage]') }}">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="year[0][mark]" value="{{ $year_mark }}">
                                                    <div class="input-group-addon">%</div>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <input type="button" class="btn btn-success float-right" value="Calculate classification" onclick="calculateClass()">
                            </form>
                        @else
                            You need to add a previous year before you can calculate your whole degree class.
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
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('years_success_message') }}</div>
                        @endif
                        <p>Add previous year marks to work out your degree classification. When you have added a previous year it will show up and be included above.</p>
                        <form role="form" method="POST" action="{{ route('addPreviousYear') }}">
                            {!! csrf_field() !!}
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <select class="form-control" name="year">
                                            <option value="null" selected disabled hidden>Choose a year...</option>
                                            <option value="1">First Year</option>
                                            <option value="2">Second Year</option>
                                            <option value="3">Third Year</option>
                                            <option value="4">Fourth Year</option>
                                        </select>
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

@section('custom_javascript')
    <script src="{{ asset('bootstrap/js/ajax_requests.js') }}"></script>
@endsection