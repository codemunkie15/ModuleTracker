@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit Module</div>

                    <div class="panel-body">
                        @if(count($modules) > 0)
                            <form role="form" method="POST" action="{{ url('/edit/') }}">
                                {!! csrf_field() !!}
                                <div class="form-group">
                                    <select name="module_id" class="form-control">
                                        <option value="null" disabled hidden selected>Choose a module to edit...</option>
                                        @foreach($modules as $module)
                                            <option value="{{ $module->id }}">{{ '[' . $module->module_code . '] ' . $module->module_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="submit" class="btn btn-success float-right" value="Edit Module">
                            </form>
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
                        <form role="form" method="POST" action="{{ route('addNewAssignment') }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <select name="module_id" class="form-control">
                                    <option value="null" disabled hidden selected>Choose an assignment to edit...</option>
                                    <?php $counter = 0 ?>
                                    @foreach($modules as $module)
                                        @if(count($assignments[$counter]) > 0)
                                            <optgroup label="{{ '[' . $module->module_code . '] ' . $module->module_name }}">
                                        @endif
                                        @foreach($assignments[$counter] as $assignment)
                                            <option value="{{ $assignment->id }}">{{ $assignment->assignment_name }}</option>
                                        @endforeach
                                        <?php $counter++ ?>
                                    @endforeach
                                </select>
                            </div>
                            <input type="submit" class="btn btn-success float-right" value="Edit Assignment">
                        </form>
                        @else
                            You don't have any assignments to edit.
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
