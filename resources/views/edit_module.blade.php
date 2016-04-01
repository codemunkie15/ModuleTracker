@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Module</div>

                    <div class="panel-body">
                        @if(count($module) > 0)
                            @if(count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> {{ $error }}<br>
                                    @endforeach
                                </div>
                            @endif
                            @if(session('module_success_message'))
                                <div class="alert alert-success"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> {{ session('module_success_message') }}</div>
                            @endif
                            <form role="form" method="POST" action="{{ route('editModule') }}">
                                {!! csrf_field() !!}
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <input type="text" name="module_code" class="form-control" placeholder="Module Code" value="{{ (Request::old('module_code') == "") ? $module->module_code : Request::old('module_code') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <input type="text" name="module_name" class="form-control" placeholder="Module Name" value="{{ (Request::old('module_name') == "") ? $module->module_name : Request::old('module_name') }}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="module_id" value="{{ $module->id }}">
                                <div class="form-group form-inline float-right">
                                    <div class="form-group">
                                        <a class="btn btn-danger" href="{{ url('delete/module/'.$module->id) }}" role="button">Delete Module</a>
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class="btn btn-success" value="Edit Module">
                                    </div>
                                </div>
                                <div style="clear: right;"></div>
                                <div class="float-right">
                                    If you delete this module it will also delete any connected assignments
                                </div>
                            </form>
                        @else
                            This module doesn't exist.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
