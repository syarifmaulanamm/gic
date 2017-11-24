@extends('admin_template')

@section('content')
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><em>#GAT/INV/OUT/{{ $stockOut->id }}</em></h3>
                    <div class="box-tools pull-right">
                        <button class="btn btn-box-tool" title="Print" onclick="window.print()"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
                <div class="box-body">
                    <table class="table table-bordered">
                        <tr>
                            <td rowspan="3" width="10%"><img src="{{ asset('images/Logo Gardi Tour.png') }}" width="100px" alt="Gardi Tour"></td>
                            <th width="20%">Date</th>
                            <th width="5%">:</th>
                            <td>{{ $stockOut->updated_at }}</td>
                        </tr>
                        <tr>
                            <th>No.</th>
                            <th>:</th>
                            <td>GAT/INV/OUT/{{ $stockOut->id }}</td>
                        </tr>
                        <tr>
                            <th>Person In Charge</th>
                            <th>:</th>
                            <td>{{ $stockOut->pic }}</td>
                        </tr>
                    </table>
                    <table class="table table-bordered">
                        <tr class="bg-green">
                            <th colspan="5" class="text-center">Borrowed Inventory</th>
                        </tr>
                        <tr>
                            <th class="text-center">ID</th>
                            <th class="text-center">Inventory</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Notes</th>
                            <th class="text-center" width="100px">Status</th>
                        </tr>
                        <tr>
                            <td>GAT/INV/{{ $stockOut->goods_id }}</td>
                            <td>{{ $stockOut->goods_name }}</td>
                            <td>{{ $stockOut->qty }}</td>
                            <td>{!! $stockOut->notes !!}</td>
                            <td class="text-center">
                                @if($stockOut->status == 1)
                                <span class="label label-success">Returned</span>
                                @else
                                <span class="label label-warning">Borrowed</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-1"></div>
                        <div class="col-md-3 col-sm-5 col-xs-6 text-center">
                            Submitted By
                            <br><br><br>
                            ................................
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-6 text-center">
                            Received By
                            <br><br><br>
                            {{ $stockOut->pic }}
                        </div>
                    </div>
                </div><!-- /.box-footer-->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection