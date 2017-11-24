@extends('admin_template')

@section('content')
<!-- Box -->
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">My Purchase Order</h3>
        <div class="box-tools pull-right">
            <button class="btn btn-box-tool" title="Create Purchase Order" data-toggle="modal" data-target="#createPO"><i class="fa fa-plus"></i> Create Purchase Order</button>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped datatables">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Vendor</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($po as $item)
                    <tr>
                        <td>GAT/PO/{{ $item->id }}</td>
                        <td>{{ $item->vendor->name }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Vendor</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </tfoot>
        </table>
    </div><!-- /.box-body -->
    <div class="box-footer">
    </div><!-- /.box-footer-->
</div><!-- /.box -->


<!-- Modal Create PO -->
<div class="modal fade" id="createPO" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header bg-aqua">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> Add Inventory</h4>
        </div>
        <div class="modal-body">
        <form action="" id="formCreatePO" method="post">
            {{ csrf_field() }}
            <input type="hidden" name="issued_by" value="{{ $AGENT['email'] }}">
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" autofocus>
            </div>
        </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="createPO()">Save changes</button>
        </div>
    </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

@endsection

@section('js')
<script>
    $(function(){
        $('.datatables').DataTable();
        $('.editor').wysihtml5();

        $("#formCreatePO").submit(function(e){
            e.preventDefault();
        });
    });

    function createPO(){
        $.ajax({
            url : "{{ url('po/create') }}",
            data : $("#formCreatePO").serialize(),
            dataType : 'json',
            type : 'POST',
            success : function(data){
                if(data.success == 'true'){
                    window.location = "{{ url('po') }}/"+data.id         
                }else if(data.success == 'false'){
                    swal("Error!", data.msg, "warning");          
                }
            }
        });
    }
</script>
@endsection