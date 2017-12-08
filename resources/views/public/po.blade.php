@extends('admin_template')

@section('content')
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        @if(in_array($AGENT['role'], array(3,4,6)))
        <li>
            <a href="#tab1" data-toggle="tab">Need Approval <span class="label label-info">{{ count($po_approval) }}</span></a>
        </li>
        @endif
        <li class="active">
            <a href="#tab2" data-toggle="tab">Pending Approval <span class="label label-info">{{ count($po_pending) }}</span></a>
        </li>
        <li>
            <a href="#tab3" data-toggle="tab">Approved <span class="label label-info">{{ count($po_approved) }}</span></a>
        </li>
        <li>
            <a href="#tab4" data-toggle="tab">Rejected <span class="label label-info">{{ count($po_rejected) }}</span></a>
        </li>
        <li>
            <a href="#tab5" data-toggle="tab">Completed <span class="label label-info">{{ count($po_completed) }}</span></a>
        </li>
        <li class="pull-right">
            <a href="{{ url('po/create') }}" class="btn btn-box-tool"><i class="fa fa-plus"></i> Create Purchase Order</a>
        </li>
    </ul>
    <div class="tab-content">
        @if(in_array($AGENT['role'], array(3,4,6)))
        <div class="tab-pane" id="tab1">
            <table class="table table-bordered table-striped datatables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Issued By</th>
                        <th>Status</th>
                        <th>Approval</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($po_approval as $item)
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
                            <span class="label label-info">Completed</span>
                            @elseif($item->status == 5)
                            <span class="label label-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if(in_array($item->status, array(0,1,2)))
                            <button class="btn btn-success btnApproval" data-id="{{ $item->id }}"><i class="fa fa-check"></i> Approve</button>
                            <button class="btn btn-danger btnReject" data-id="{{ $item->id }}"><i class="fa fa-close"></i> Reject</button>
                            @else
                            <button class="btn btn-success btn-block btnApproval" data-id="{{ $item->id }}"><i class="fa fa-check"></i> Complete</button>
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
                        <th>Approval</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        @endif
        <div class="tab-pane active" id="tab2">
            <table class="table table-bordered table-striped datatables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Issued By</th>
                        <th>Status</th>
                        <th width="120">Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($po_pending as $item)
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
                            <span class="label label-info">Completed</span>
                            @elseif($item->status == 5)
                            <span class="label label-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ url("po/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                            @if(in_array($AGENT['role'], array(1,4)))
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
                        <th width="120">Option</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="tab-pane" id="tab3">
            <table class="table table-bordered table-striped datatables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Issued By</th>
                        <th>Status</th>
                        <th width="120">Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($po_approved as $item)
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
                            <span class="label label-info">Completed</span>
                            @elseif($item->status == 5)
                            <span class="label label-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ url("po/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                            @if(in_array($AGENT['role'], array(1,4)))
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
                        <th width="120">Option</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="tab-pane" id="tab4">
            <table class="table table-bordered table-striped datatables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Issued By</th>
                        <th>Status</th>
                        <th width="120">Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($po_rejected as $item)
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
                            <span class="label label-info">Completed</span>
                            @elseif($item->status == 5)
                            <span class="label label-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ url("po/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
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
                        <th width="120">Option</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="tab-pane" id="tab5">
            <table class="table table-bordered table-striped datatables">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Issued By</th>
                        <th>Status</th>
                        <th width="120">Option</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($po_completed as $item)
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
                            <span class="label label-info">Completed</span>
                            @elseif($item->status == 5)
                            <span class="label label-danger">Rejected</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ url("po/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
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
                        <th width="120">Option</th>
                    </tr>
                </tfoot>
            </table>
        </div>

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

        $(".btnApproval").click(function(){
            var poId = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Your will approve this Purchase Order!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-success",
                confirmButtonText: "Yes, Approve it!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    type: "POST",
                    url: "{{url('po/approve')}}/"+poId,
                    dataType: "json",
                    data: { type : 'approve',_token : '{{ csrf_token() }}' },
                    success: function(data){
                        swal("Purchase Order Approved", "success");
                        setTimeout(location.reload.bind(location), 2000);
                    }
                });
            });
        });

        $(".btnReject").click(function(){
            var poId = $(this).data('id');

            swal({
                title: "Are you sure?",
                text: "Your will reject this Purchase Order!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes, Reject it!",
                closeOnConfirm: false
            },
            function(){
                $.ajax({
                    type: "POST",
                    url: "{{url('po/approve')}}/"+poId,
                    dataType: "json",
                    data: {  type : 'reject',_token : '{{ csrf_token() }}' },
                    success: function(data){
                        swal("Purchase Order Approved", "success");
                        setTimeout(location.reload.bind(location), 2000);
                    }
                });
            });
        });

    });
</script>
@endsection