@extends('admin_template')

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h4 class="pull-left"><strong>[GAT/PO/{{ $po->id }}] {{ $po->title }}</strong></h4>
        <button class="btn btn-box-tool pull-right" onclick="window.print()"><i class="fa fa-print"></i></button>
        <div class="clearfix"></div>
    </div>
    <div class="box-body">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <strong><i class="fa fa-building"></i> Vendor</strong>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Name</strong></td>
                        <td>:</td>
                        <td>{{ $po->vendor->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email</strong></td>
                        <td>:</td>
                        <td>{{ $po->vendor->email }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone</strong></td>
                        <td>:</td>
                        <td>{{ $po->vendor->phone }}</td>
                    </tr>
                    <tr>
                        <td><strong>Address</strong></td>
                        <td>:</td>
                        <td>{{ $po->vendor->address }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-4 col-md-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <strong><i class="fa fa-truck"></i> Shiping</strong>
                </div>
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Delivery</strong></td>
                        <td>:</td>
                        <td>{{ $po->delivery }}</td>
                    </tr>
                    <tr>
                        <td><strong>Shipment To</strong></td>
                        <td>:</td>
                        <td>{{ $po->shipment_to }}</td>
                    </tr>
                    <tr>
                        <td><strong>Freight</strong></td>
                        <td>:</td>
                        <td>{{ $po->freight }}</td>
                    </tr>
                    <tr>
                        <td><strong>Insurance</strong></td>
                        <td>:</td>
                        <td>{{ $po->insurance }}</td>
                    </tr>
                    <tr>
                        <td><strong>Payment</strong></td>
                        <td>:</td>
                        <td>{{ $po->payment }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">{{ number_format($item->price,0,'',',') }}</td>
                        <td class="text-right">{{ number_format($item->amount,0,'',',') }}</td>
                    </tr>
                @endforeach
            </tbody>   
        </table>
        <div class="col-md-4 col-md-offset-8 text-right">
            <h3><em>Total :</em> IDR {{ $po->total }}</h3>
        </div>
        <div class="clearfix"></div>
        @if($po->status == 0)
        <div class="bg-yellow text-center">
            Pending Approval By GA
        </div>
        @elseif($po->status == 1)
        <div class="bg-yellow text-center">
            Pending Approval By GM
        </div>
        @elseif($po->status == 2)
        <div class="bg-yellow text-center">
            Pending Review By Accounting
        </div>
        @elseif($po->status == 3)
        <div class="bg-green text-center">
            Approved
        </div>
        @elseif($po->status == 4)
        <div class="bg-aqua text-center">
            Completed
        </div>
        @elseif($po->status == 5)
        <div class="bg-red text-center">
            Rejected
        </div>
        @endif
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
    });
</script>
@endsection