@extends('admin_template')

@section('content')

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
<input type="hidden" name="id" value="{{ $po->id }}">
{{ csrf_field() }}
<div class="panel-group" id="accordion">
    <div class="panel panel-default">
        <div class="panel-heading bg-blue">
            <h4 class="panel-title">
                <a href="#step1" data-toggle="collapse" data-parent="#accordion">
                    <i class="fa fa-th-list"></i> Purchase Order
                </a>
                <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Save</button>
            </h4>
            <div class="clearfix"></div>
        </div>
        <div class="panel-collapse collapse in" id="step1">
            <div class="panel-body">
                <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Title*</label>
                        <div class="col-sm-9">
                            <input type="text" name="title" class="form-control" value="{{ $po->title }}" required>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="#step2" data-toggle="collapse" data-parent="#accordion">
                    <i class="fa fa-truck"></i> Shiping
                </a>
            </h4>
        </div>
        <div class="panel-collapse collapse" id="step2">
            <div class="panel-body">
                <div class="col-md-8 col-md-offset-2">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Delivery</label>
                        <div class="col-sm-9">
                            <input type="text" name="delivery" class="form-control" value="{{ $po->delivery }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Shipment To</label>
                        <div class="col-sm-9">
                            <input type="text" name="shipment_to" class="form-control" value="{{ $po->shipment_to }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Freight</label>
                        <div class="col-sm-9">
                            <input type="text" name="freight" class="form-control" value="{{ $po->freight }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Insurance</label>
                        <div class="col-sm-9">
                            <input type="text" name="insurance" class="form-control" value="{{ $po->insurance }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Payment</label>
                        <div class="col-sm-9">
                            <input type="text" name="payment" class="form-control" value="{{ $po->payment }}">
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="#step3" data-toggle="collapse" data-parent="#accordion">
                    <i class="fa fa-building"></i> Vendor
                </a>
                <span class="pull-right">
                    <strong><span id="vendorName">{{ $po->vendor->name }}</span></strong>
                </span>
            </h4>
        </div>
        <div class="panel-collapse collapse" id="step3">
            <div class="panel-body">
                <input type="hidden" name="vendor_id" value="{{ $po->vendor_id }}">
                <table class="table table-bordered table-striped datatables" id="tableVendors">
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
                                <a href="#" data-id="{{ $item->id }}" data-name="{{ $item->name }}" class="btn btn-default btn-sm btnVendor">Choose</a>
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
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a href="#step4" data-toggle="collapse" data-parent="#accordion">
                    <i class="fa fa-shopping-cart"></i> Items
                </a>
                <span class="pull-right">
                    <strong>Total : IDR <span id="totalItem">{{ $po->total }}</span></strong>
                </span>
            </h4>
        </div>
        <div class="panel-collapse collapse" id="step4">
            <div class="panel-body">
                <input type="hidden" name="total" value="{{ $po->total }}">
                <table class="table table-bordered table-striped" id="tableItems">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Amount</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr id="item0" data-id="0" class="hide">
                            <td data-name="name">
                                <input type="text" name="nameItem[]" class="form-control">
                            </td>
                            <td data-name="quantity">
                                <input type="number" name="quantity[]" class="form-control">
                            </td>
                            <td data-name="price">
                                <input type="text" name="price[]" class="form-control">
                            </td>
                            <td data-name="amount">
                                <input type="text" name="amount[]" readonly class="form-control">
                            </td>
                            <td data-name="del">
                                <button type="button" class="btn btn-danger btn-sm btnDelete"><i class="fa fa-close"></i></button>
                            </td>
                        </tr>
                        <?php $no = 0; ?>
                        @foreach($items as $item)
                        <tr id="item{{ $no++ }}" data-id="{{ $no++ }}">
                            <td data-name="name">
                                <input type="text" name="nameItem[]" class="form-control" value="{{ $item->name }}">
                            </td>
                            <td data-name="quantity">
                                <input type="number" name="quantity[]" class="form-control" value="{{ $item->quantity }}">
                            </td>
                            <td data-name="price">
                                <input type="text" name="price[]" class="form-control" value="{{ $item->price }}">
                            </td>
                            <td data-name="amount">
                                <input type="text" name="amount[]" readonly class="form-control" value="{{ $item->amount }}">
                            </td>
                            <td data-name="del">
                                <button type="button" class="btn btn-danger btn-sm btnDelete"><i class="fa fa-close"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="text-center">
                    <button type="button" class="btn btn-default" id="addItem"><i class="fa fa-plus"></i> Add Item</button>
                </div>
            </div> 
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
        $('[data-toggle="tooltip"]').tooltip();

        $("#addItem").on("click", function(){
            var newid = 0;

            $.each($("#tableItems tr"), function(){
                if(parseInt($(this).data("id")) > newid) {
                    newid = parseInt($(this).data("id"));
                }
            });
            newid++;

            var tr = $("<tr></tr>", {
                id : "item"+newid,
                "data-id" : newid
            });

            $.each($("#tableItems tbody tr:nth(0) td"), function(){
                var cur_td = $(this);

                var children = cur_td.children();

                if($(this).data('name') != undefined) {
                    var td = $("<td></td>", {
                        "data-name" : $(cur_td).data('name')
                    });

                    var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                    c.appendTo($(td));
                    td.appendTo($(tr));
                }

                $(tr).appendTo("#tableItems");

                $(tr).find("td .btnDelete").on('click', function(){
                    $(this).closest('tr').remove();
                    getTotal();
                });
            });
        });

        $("#tableItems").on('keyup', '[name="price[]"]', function(){
            var parent = $(this).parent().parent();
            var qty = parent.find('[name="quantity[]"]').val();
            var price = $(this).val();
            var amount = parent.find('td [name="amount[]"]');

            amount.val(qty*price);
            getTotal();
        });

        $("#tableItems").on('keyup', '[name="quantity[]"]', function(){
            var parent = $(this).parent().parent();
            var price = parent.find('[name="price[]"]').val();
            var qty = $(this).val();
            var amount = parent.find('td [name="amount[]"]');

            amount.val(qty*price);
            getTotal();
        });

        $('.btnVendor').on('click', function(){
            $("input[name='vendor_id']").val($(this).data('id'));
            $("#vendorName").text($(this).data('name'));
        });

        function getTotal()
        {
            var sum = 0;

            $("#tableItems [name='amount[]']").each(function(){
                sum += +$(this).val();
            });

            $("#totalItem").text(addCommas(Math.floor(sum)));
            $("[name='total']").val(addCommas(Math.floor(sum)));
        }

        function addCommas(nStr)
        {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
    });
</script>
@endsection 