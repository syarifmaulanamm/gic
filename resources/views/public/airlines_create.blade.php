@extends('admin_template')

@section('content')
<div class="box box-default">
    <div class="box-body">
        <div class="col-md-8 col-md-offset-2">

        @if ($errors->any())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="" method="post" class="form-horizontal">
        {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">Code</label>
                <div class="col-sm-9">
                    <input type="text" name="code" class="form-control" placeholder="Example: GA" autofocus required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Area</label>
                <div class="col-sm-9">
                    <select name="area" class="form-control" required>
                        <option value="domestic">Domestic</option>
                        <option value="international">International</option>
                    </select>
                </div>
            </div>
            <div class="col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </form>
        </div>
    </div>
</div>
@endsection