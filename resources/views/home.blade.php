@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Module and assignment summary
                        <div class="pull-right">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                    Order by module {{ ($order_by == 'module_code') ? 'code' : 'name' }}<span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-right" role="menu">
                                    <li><a href="{{ url('/home/module_code') }}">Order by module code</a></li>
                                    <li><a href="{{ url('/home/module_name') }}">Order by module name</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="panel-body">
                        @if(session('success_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('success_message') }}</div>
                        @endif
                        @if(count($modules) > 0)
                            @foreach($modules as $module)
                                <div class="module_header">
                                    {{ '[' . $module->module_code . '] ' . $module->module_name }} [<a href="{{ url('/edit/module/'.$module->id) }}">edit</a>]</span>
                                </div>
                                @if(count($module->assignments) > 0)
                                    <table class="table table-hover sortable" width="100%">
                                        <thead>
                                        <tr>
                                            <th width="56%">Assignment Name</th>
                                            <th width="11%">Percentage</th>
                                            <th width="9%">Mark</th>
                                            <th width="16%">Deadline</th>
                                            <th width="8%">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($module->assignments()->orderBy('assignment_name', 'asc')->get() as $assignment)
                                            <tr>
                                                <td>{{ $assignment->assignment_name }}</td>
                                                <td>{{ $assignment->mark_percentage }}%</td>
                                                <td>{{ $assignment->current_mark }}%</td>
                                                <td>{{ $assignment->deadline }}</td>
                                                <td>[<a href="{{ url('/edit/assignment/'.$assignment->id) }}">edit</a>]</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td></td>
                                                <td><b>Overall:</b></td>
                                                <td>{{ $module->overallMark() }}%</td>
                                                <td>{{ $module->markClass() }}
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <div class="no-assignments">
                                        There are no assignments yet for this module.<br>You can add some by <a href="{{ url('/add') }}">clicking here</a>.
                                    </div>
                                @endif
                            @endforeach
                        @else
                            You don't have any modules or assignments yet.<br>You can add some by <a href="{{ url('/add') }}">clicking here</a>.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
