@extends('admin_template')

@section('content')
<div class="box box-default">
    <div class="box-header with-border">
        <a href="{{ url('sales/client-status/create') }}" class="btn btn-box-tool pull-right"><i class="fa fa-plus"></i> Add Client</a>
        <div class="clearfix"></div>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped datatables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name Of Company</th>
                    <th>Sales Rep.</th>
                    <th>Phone</th>
                    <th width="150">Option</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($clients as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->name_of_company }}</td>
                    <td>{{ $item->sales_rep }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        <a href="{{ url("sales/client-status/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-eye"></i></a>
                        <a href="{{ url("sales/client-status/update/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="#" data-id="{{ $item->id }}" class="btn btn-default btn-sm btnDelete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Name Of Company</th>
                    <th>Sales Rep.</th>
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
        $('.datatables').DataTable({
            "bSort" : false
        });
        $('[data-toggle="tooltip"]').tooltip();
</script>
@endsection