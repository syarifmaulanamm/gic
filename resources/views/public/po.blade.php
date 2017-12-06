@extends('admin_template')

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <a href="{{ url('po/create') }}" class="btn btn-box-tool pull-right"><i class="fa fa-plus"></i> Create Purchase Order</a>
        <div class="clearfix"></div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped datatables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Issued By</th>
                    <th>Status</th>
                    <th width="50">Option</th>
                </tr>
            </thead>
            <tbody>
                @foreach($po as $item)
                <tr>
                    <td>GAT/PO/{{ $item->id }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->issued_by }}</td>
                    <td>
                        @if($item->status == 0)
                        <span class="label label-warning">Pending Approval By GA</span>
                        @elseif($item->status == 1)
                        <span class="label label-warning">Pending Approval By GM</span>
                        @elseif($item->status == 2)
                        <span class="label label-warning">Pending Review By Accounting</span>
                        @elseif($item->status == 3)
                        <span class="label label-success">Approved</span>
                        @elseif($item->status == 4)
                        <span class="label label-danger">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url("po/update/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
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
        $('.datatables').DataTable();
        $('.editor').wysihtml5();
        $('[data-toggle="tooltip"]').tooltip();

        $("#formCreatePO").submit(function(e){
            e.preventDefault();
        });
    });
</script>
@endsection