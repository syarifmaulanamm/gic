@extends('admin_template')

@section('content')

<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active">
            <a href="#tab1" data-toggle="tab">Domestic <span class="label label-info">{{ count($domestic) }}</span></a>
        </li>
        <li>
            <a href="#tab2" data-toggle="tab">International <span class="label label-info">{{ count($international) }}</span></a>
        </li>
        <li class="pull-right">
            <a href="{{ url('airlines/create') }}" class="btn btn-box-tool"><i class="fa fa-plus"></i> Add Airlines</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="tab1">
        <table class="table table-bordered table-striped datatables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Airlines</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($domestic as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ url("airlines/update/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="#" data-id="{{ $item->id }}" class="btn btn-default btn-sm btnDelete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Airlines</th>
                    <th>Option</th>
                </tr>
            </tfoot>
        </table>
        </div>
        <div class="tab-pane" id="tab2">
        <table class="table table-bordered table-striped datatables">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Airlines</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                @foreach($international as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <a href="{{ url("airlines/update/$item->id") }}" class="btn btn-default btn-sm"><i class="fa fa-edit"></i></a>
                        <a href="#" data-id="{{ $item->id }}" class="btn btn-default btn-sm btnDelete"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Airlines</th>
                    <th>Option</th>
                </tr>
            </tfoot>
        </table>
        </div>
    </div>
</div>
@endsection