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
                    @if($AGENT['role'] != 5)
                    <th>Approval</th>
                    @endif
                    <th width="120">Option</th>
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
                    @if($AGENT['role'] != 5)
                    <td>
                        @if($AGENT['role'] == 4)                    
                        <button class="btn btn-success" id="BtnApproval" data-id="{{ $item->id }}"><i class="fa fa-check"></i> Approve</button>
                        @endif
                    </td>
                    @endif
                    <td class="text-center">
                        <a href="{{ url("po/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                        @if($AGENT['role'] == 4)
                        <a href="{{ url("po/update/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="#" data-id="{{ $item->id }}" class="btn btn-default btn-sm btnDelete"><i class="fa fa-trash"></i></a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Issued By</th>
                    <th>Status</th>
                    @if($AGENT['role'] != 5)
                    <th>Approval</th>
                    @endif
                    <th width="120">Option</th>
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
            "bSort" : false
        });
        $('.editor').wysihtml5();
        $('[data-toggle="tooltip"]').tooltip();

        $("#formCreatePO").submit(function(e){
            e.preventDefault();
        });
    });
</script>
@endsection