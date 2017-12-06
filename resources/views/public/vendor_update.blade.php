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
            <input type="hidden" name="id" value="{{ $vendor->id }}">
            <div class="form-group">
                <label class="col-sm-3 control-label">Name</label>
                <div class="col-sm-9">
                    <input type="text" name="name" class="form-control" value="{{ $vendor->name }}" autofocus>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email" class="form-control" value="{{ $vendor->email }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-9">
                    <input type="text" name="phone" class="form-control" value="{{ $vendor->phone }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Address</label>
                <div class="col-sm-9">
                    <textarea name="address" class="form-control">{{ $vendor->address }}</textarea>
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

@section('js')
<script>
    $(function(){
        $('.datatables').DataTable();
        $('.editor').wysihtml5();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endsection