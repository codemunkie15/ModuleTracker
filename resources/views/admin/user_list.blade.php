@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">User List</div>

                    <div class="panel-body">
                        <table class="table table-hover year-list sortable" width="100%">
                            <thead>
                            <tr>
                                <th width="10%">ID</th>
                                <th width="10%">Admin</th>
                                <th width="25%">Name</th>
                                <th width="37%">Email address</th>
                                <th width="18%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{!! ($user->isAdmin()) ? '<div class="fa fa-check fa-lg fa-fw"></div>' : '<i class="fa fa-times fa-lg fa-fw"></i>' !!}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>[<a href="{{ url('/admin/ban/' . $user->id) }}">ban</a>] [<a href="{{ url('/admin/make/' . $user->id) }}">{{ ($user->isAdmin()) ? 'revoke' : 'make' }} admin</a>]</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
