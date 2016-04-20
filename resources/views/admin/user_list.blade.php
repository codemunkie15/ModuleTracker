@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">User List</div>

                    <div class="panel-body">
                        @if(session('success_message'))
                            <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('success_message') }}</div>
                        @endif
                            @if(session('error_message'))
                                <div class="alert alert-danger"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {{ session('error_message') }}</div>
                            @endif
                        <table class="table table-hover year-list sortable" width="100%">
                            <thead>
                            <tr>
                                <th width="8%">ID</th>
                                <th width="8%">Admin</th>
                                <th width="24%">Name</th>
                                <th width="36%">Email address</th>
                                <th width="24%">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>{!! ($user->isAdmin()) ? '<div class="fa fa-check fa-lg fa-fw"></div>' : '<i class="fa fa-times fa-lg fa-fw"></i>' !!}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>[<a href="{{ url('/admin/ban/' . $user->id) }}">{{ ($user->isBanned()) ? 'un-ban' : 'ban' }} user</a>] [<a href="{{ url('/admin/make/' . $user->id) }}">{{ ($user->isAdmin()) ? 'revoke' : 'make' }} admin</a>]</td>
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
