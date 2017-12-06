@extends('admin_template')

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <a href="{{ url('po/vendor/create') }}" class="btn btn-box-tool pull-right"><i class="fa fa-plus"></i> Add Vendor</a>
        <div class="clearfix"></div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped datatables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th width="50">Option</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($vendors as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->address }}</td>
                    <td>
                        <a href="{{ url("po/vendor/update/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="#" data-id="{{ $item->id }}" class="btn btn-default btn-sm btnDelete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Option</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection

@section('js')
<script>
    $(function(){
        $('.datatables').DataTable({
            responsive: true
        });
        $('.editor').wysihtml5();
        $('[data-toggle="tooltip"]').tooltip();

        $(".btnDelete").on('click', function(){
            var id = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Your will not be able to recover after deletion!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    type: "POST",
                    url: "{{url('po/vendor')}}/"+id,
                    dataType: "json",
                    data: {_method: 'delete', _token : '{{ csrf_token() }}' },
                    success: function(data){
                        swal("Deleted!", "Your data has been deleted.", "success");
                        setTimeout(location.reload.bind(location), 2000);
                    }
                });
            });
        });
    });
</script>
@endsection