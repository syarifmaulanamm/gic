@extends('admin_template')

@section('content')
<style>
    .btn-step span {
        background-color: white;
        color: darkred;
        border-radius: 100%;
        padding: 2px 10px;
        position: absolute;
        top:9px;
        left:25px;
    }    
</style>
<div class="row">
    <div class="col-md-3">
        <button data-toggle="tab" data-target="#step1" class="btn btn-lg btn-block btn-step bg-red">
            <span>1</span>
            Detail
        </button>
    </div>
    <div class="col-md-3">
        <button data-toggle="tab" data-target="#step2" class="btn btn-lg btn-block btn-step btn-default" disabled>
            <span>2</span>
            Vendor
        </button>
    </div>
    <div class="col-md-3">
        <button data-toggle="tab" data-target="#step3"  class="btn btn-lg btn-block btn-step btn-default" disabled>
            <span>3</span>
            Items
        </button>
    </div>
    <div class="col-md-3">
        <button data-toggle="tab" data-target="#step4"  class="btn btn-lg btn-block btn-step btn-default" disabled>
            <span>4</span>
            Complete
        </button>
    </div>
</div>
<br>
<div class="progress progress-xs active">
    <div class="progress-bar progress-bar-warning progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemax="100" id="progressStep" style="width:25%"></div>
</div>
<div class="tab-content">
    <div id="step1" class="tab-pane fade in active">
        <div class="box box-danger">
            <div class="box-body">
                <form action="#" method="post" id="formStep1">
                <input type="hidden" name="id" value="">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no">No.</label>
                            <input type="text" name="no" class="form-control" value="GAT/PO/" readonly>
                        </div>
                        <div class="form-group">
                            <label for="delivery">Delivery</label>
                            <input type="text" name="delivery" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="shipment_to">Shipment To</label>
                            <input type="text" name="shipment_to" value="" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="freight">Freight</label>
                            <input type="text" name="freight" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="insurance">Insurance</label>
                            <input type="text" name="insurance" value="" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="payment">Payment</label>
                            <input type="text" name="payment" value="" class="form-control">
                        </div>
                    </div>
                </div>
                </form>
            </div>
            <div class="box-footer">
                <div class="btn-group pull-right">
                    <button class="btn btn-success" id="saveStep1" onclick="saveStep1()"><i class="fa fa-check" aria-hidden="true"></i> Save</button>                
                    <button class="btn btn-success" id="nextStep1" @if(!$po->vendor_id) disabled @endif>Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>                    
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div id="step2" class="tab-pane fade">
        <div class="box box-danger">
            <div class="box-heading text-center bg-red">
                <br>
                <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#selectVendor"><i class="fa fa-list"></i> Select From List</button>                
                <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#addVendor"><i class="fa fa-plus"></i> Add Vendor</button>                
                <br><br>
            </div>
            <div class="box-body">
                <div id="vendor-detail">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>Name</th>
                            <td><span id="vendorName"></span></td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td><span id="vendorEmail"></span></td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td><span id="vendorPhone"></span></td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td><span id="vendorAddress"></span></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="box-footer">
                <div class="btn-group pull-right">
                    <button class="btn btn-success" id="nextStep2">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>                    
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div id="step3" class="tab-pane fade">
        <div class="box box-danger">
            <div class="box-heading text-center bg-red">
                <br>
                <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#addItem"><i class="fa fa-plus"></i> Add Item</button>                
                <button class="btn btn-lg btn-danger" data-toggle="modal" data-target="#addAttachment"><i class="fa fa-paperclip" aria-hidden="true"></i> Add Attachment</button>                
                <br><br>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-striped datatables" id="tableItem">
                    <thead>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                        <th width="10">Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Amount</th>
                        <th>Action</th>
                    </tfoot>
                </table>
            </div>
            <div class="box-footer">
                <div class="pull-left">
                    <h3>Total : <span id="itemTotal">{{ $itemTotal }}</span></h3>                
                </div>
                <div class="btn-group pull-right">
                    <button class="btn btn-success" id="nextStep3">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>                    
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div id="step4" class="tab-pane fade">
        <div class="box box-success">
            <div class="box-body bg-green text-center">
                <h1><i class="fa fa-check-circle"></i></h1>
                <h4>Success</h4>
                <br>
                <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#selectVendor"><i class="fa fa-print"></i> Print</button>                
                <button class="btn btn-lg btn-success" data-toggle="modal" data-target="#addVendor"><i class="fa fa-plus"></i> Create New Purchase Order</button>                
                <br><br>
            </div>
        </div>
    </div>
</div>


<!-- Add Vendor -->
<div class="modal fade" id="addVendor" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header bg-red">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Vendor</h4>
    </div>
    <div class="modal-body">
    <div id="vendorAlert" class="alert alert-danger alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        <span></span>
    </div>
    <form action="{{ url('po/vendor/create') }}" id="formAddVendor" method="post">
        <input type="hidden" name="poID" value="{{ $po->id }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>
        <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" rows="5" class="form-control"></textarea>
        </div>
    </form>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="addVendor()">Save</button>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Seect Vendor -->
<div class="modal fade" id="selectVendor" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header bg-red">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="fa fa-list"></i> Select Vendor</h4>
    </div>
    <div class="modal-body">
        <table class="table table-bordered table-striped datatables">
            <thead>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </thead>
            <tbody>
                <?php $no = 1;?>
                @foreach($vendors as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->address }}</td>
                    <td>
                      <button onclick="selectVendor({{ $item->id }})" class="btn btn-sm btn-default" title="Select"><i class="fa fa-check"></i></button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <th>No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tfoot>
        </table>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" onclick="addVendor()">Save</button>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- Add Item -->
<div class="modal fade" id="addItem" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header bg-red">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Item</h4>
    </div>
    <div class="modal-body">
    <div id="itemAlert" class="alert alert-danger alert-dismissible" style="display:none;">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
        <span></span>
    </div>
    <form action="{{ url('po/item/create') }}" id="formAddItem" method="post">
        <input type="hidden" name="poID" value="{{ $po->id }}">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Item Name</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" min="0" name="quantity" id="itemQuantity" class="form-control">
        </div>
        <div class="form-group">
            <label for="price">Unit Price</label>
            <div class="input-group">
                <span class="input-group-addon">Rp</span>
                <input type="text" name="price" id="itemPrice" class="form-control currency">                
            </div>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <div class="input-group">
                <span class="input-group-addon">Rp</span>
                <input type="text" name="amount" id="itemAmount" readonly class="form-control currency">                
            </div>
        </div>
    </form>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="btnAddItem">Save</button>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Edit Item -->
<div class="modal fade" id="editItem" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header bg-red">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Item</h4>
    </div>
    <div class="modal-body">
    <form action="{{ url('po/item/update') }}" id="formEditItem" method="post">
        <input type="hidden" name="id">
        {{ csrf_field() }}
        <div class="form-group">
            <label for="name">Item Name</label>
            <input type="text" name="name" class="form-control">
        </div>
        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" min="0" name="quantity" id="itemQuantity" class="form-control">
        </div>
        <div class="form-group">
            <label for="price">Unit Price</label>
            <div class="input-group">
                <span class="input-group-addon">Rp</span>
                <input type="text" name="price" id="itemPrice" class="form-control currency">                
            </div>
        </div>
        <div class="form-group">
            <label for="amount">Amount</label>
            <div class="input-group">
                <span class="input-group-addon">Rp</span>
                <input type="text" name="amount" id="itemAmount" readonly class="form-control currency">                
            </div>
        </div>
    </form>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="btnUpdItem">Save</button>
    </div>
</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- Add Attachment -->
<div class="modal fade" id="addAttachment" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
<div class="modal-content">
    <div class="modal-header bg-red">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title"><i class="fa fa-plus"></i> Add Attachment</h4>
    </div>
    <div class="modal-body">
        <form action="{{ url('po/attachment/create')}}" class="dropzone" id="my-awesome-dropzone"></form>
    </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="btnAddItem">Save</button>
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
        $('[data-toggle="tooltip"]').tooltip(); 
        $('.currency').maskMoney();
        $("#formStep1").submit(function(e){e.preventDefault();})
        $("#formAddVendor").submit(function(e){e.preventDefault();})
        $("#formAddItem").submit(function(e){e.preventDefault();})

        var tItem = $("#tableItem").DataTable();

        $("#nextStep1").click(function(){
            $(".btn[data-target='#step2']").prop('disabled', false);
            $(".btn[data-target='#step1']").removeClass('active bg-red');
            $(".btn[data-target='#step1']").addClass('btn-default');
            $(".btn[data-target='#step2']").addClass('active bg-red');
            $("#step2").addClass('active in');
            $("#step1").removeClass('active in');
            $("#progressStep").css('width', '50%');
            $("#progressStep").addClass('progress-bar-warning');
            $("#progressStep").removeClass('progress-bar-success');
        });
        $("#nextStep2").click(function(){
            $(".btn[data-target='#step3']").prop('disabled', false);
            $(".btn[data-target='#step2']").removeClass('active bg-red');
            $(".btn[data-target='#step2']").addClass('btn-default');
            $(".btn[data-target='#step3']").addClass('active bg-red');
            $("#step3").addClass('active in');
            $("#step2").removeClass('active in');
            $("#progressStep").css('width', '75%');
            $("#progressStep").addClass('progress-bar-warning');
            $("#progressStep").removeClass('progress-bar-success');
        });
        $("#nextStep3").click(function(){
            $(".btn[data-target='#step4']").prop('disabled', false);
            $(".btn[data-target='#step3']").removeClass('active bg-red');
            $(".btn[data-target='#step3']").addClass('btn-default');
            $(".btn[data-target='#step4']").addClass('active bg-red');
            $("#step4").addClass('active in');
            $("#step3").removeClass('active in');
            $("#progressStep").css('width', '100%');
            $("#progressStep").addClass('progress-bar-success');
            $("#progressStep").removeClass('progress-bar-warning');
        });
        $(".btn[data-target^='#step']").click(function(){
            $(this).addClass('active bg-red');
            $(this).parent().siblings().find('.btn').removeClass('active bg-red');
        });
        $("#formAddItem #itemQuantity").on('keyup', function(){
            $("#formAddItem #itemAmount").maskMoney('mask', $(this).val()*$("#formAddItem #itemPrice").maskMoney('unmasked')[0]);
        });
        $("#formAddItem #itemPrice").on('keyup', function(){
            $("#formAddItem #itemAmount").maskMoney('mask', $(this).maskMoney('unmasked')[0]*$("#formAddItem #itemQuantity").val());
        });
        $("#formEditItem #itemQuantity").on('keyup', function(){
            $("#formEditItem #itemAmount").maskMoney('mask', $(this).val()*$("#formEditItem #itemPrice").maskMoney('unmasked')[0]);
        });
        $("#formEditItem #itemPrice").on('keyup', function(){
            $("#formEditItem #itemAmount").maskMoney('mask', $(this).maskMoney('unmasked')[0]*$("#formEditItem #itemQuantity").val());
        });

        // Add Item
        var addItem = function(){
            $.ajax({
            type: "POST",
            url: $("#formAddItem").attr('action'),
            dataType: "json",
            data: $("#formAddItem").serialize(),
            success: function(data)
            {
                if(data.error){
                var errors = $.makeArray(data.error);
                var html = "<ul>";
                $.map(errors, function(a){
                    html += "<li>"+ a +"</li>";
                });
                html += "</ul>";
                $("#vendorAlert span").html(html);

                $("#vendorAlert").fadeIn('slow');
                }

                if(data.success == 'true'){
                    $("#addItem").modal('hide');
                    $("#formAddItem").find("input[type=text], input[type=number], textarea").val("");
                    console.log(data);
                    tItem.row.add([
                        data.data.name,
                        data.data.quantity,
                        data.data.price,
                        data.data.amount,
                        "<button class=\"btn btn-default\" id=\"deleteItem\" data-id=\"" + data.data.id +"\"><i class=\"fa fa-trash\"></i></button>"
                    ]).draw(false);

                    $("#itemTotal").html(data.total);

                }else if(data.success == 'false'){
                swal("Error!", data.msg, "warning");          
                }
                
            }
            })
        }

        // Delete Item
        var deleteItem = function(el){
            var $this = $(el);
            var id = $this.data('id');
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
                    url: "{{url('po/item')}}/"+id,
                    dataType: "json",
                    data: {_method: 'delete', _token : '{{ csrf_token() }}' },
                    success: function(data){
                        if(data.success == 'true'){
                            swal("Deleted!", "Your data has been deleted.", "success");

                            $("#itemTotal").html(data.total);
                            tItem.row($this.parents('tr')).remove().draw();
                        }else{
                            swal("Oops!", data.msg, "warning");                            
                        }
                    }
                });
            });
        }

        // Edit Item
        // var editItem = function(el){
        //     var $this = $(el);
        //     var id = $this.data('id');

        //     $("#editItem").modal('show');

        //     $.ajax({
        //         url: "{{ url('po/item') }}/" + id,
        //         type: "GET",
        //         dataType: "json",
        //         success: function(data){
        //             $("#formEditItem").find("input[name='id']").val(data.data.id);
        //             $("#formEditItem").find("input[name='name']").val(data.data.name);
        //             $("#formEditItem").find("input[name='quantity']").val(data.data.quantity);
        //             $("#formEditItem #itemPrice").val(data.data.price + "00");
        //             $("#formEditItem #itemAmount").val(data.data.amount + "00");
        //             $("#formEditItem #itemPrice").maskMoney('mask');
        //             $("#formEditItem #itemAmount").maskMoney('mask');
        //         }
        //     });
        // }

        // Do Edit Item
        // var doEditItem = function(){
        //     var id = $("#formEditItem").find("input[name='id']").val();

        //     $.ajax({
        //         url: "{{ url('po/item/update') }}/" + id,
        //         type: "POST",
        //         data: $("#formEditItem").serialize(),
        //         dataType: "json",
        //         success: function(data){
        //             $("#editItem").modal('hide');
        //         }
        // }

        // Button
        $("#btnAddItem").click(function(){addItem()});
        // $("#btnUpdItem").click(function(){doEditItem()});
        $("#tableItem").on('click', "#deleteItem", function(){deleteItem(this)});
        $("#tableItem").on('click', "#btnEditItem", function(){editItem(this)});
    });

    function saveStep1(){
        var id = $("#formStep1 input[name='id']").val();
        $("#saveStep1").prop('disabled', true);
        $("#saveStep1").html('<i class="fa fa-spinner fa-spin"></i> Please Wait');
        $.ajax({
            url: "{{ url('po/update') }}/" + id,
            type: "POST", 
            data: $("#formStep1").serialize(),
            dataType: "json",
            success: function(data){
                console.log(data);
                if(data.success == "true"){
                    $("#saveStep1").prop('disabled', true);
                    $("#saveStep1").html('<i class="fa fa-check"></i> Save');
                    $("#nextStep1").prop('disabled', false);
                    $("#progressStep").css('width', '50%');
                    $(".btn[data-target='#step2']").prop('disabled', false);
                    $("#step2").addClass('active in');
                    $("#step1").removeClass('active in');
                }
            }
        });
    }


  // Add Vendor
  function addVendor(){
    $.ajax({
      type: "POST",
      url: $("#formAddVendor").attr('action'),
      dataType: "json",
      data: $("#formAddVendor").serialize(),
      success: function(data)
      {
        if(data.error){
          var errors = $.makeArray(data.error);
          var html = "<ul>";
          $.map(errors, function(a){
            html += "<li>"+ a +"</li>";
          });
          html += "</ul>";
          $("#itemAlert span").html(html);

          $("#itemAlert").fadeIn('slow');
        }

        if(data.success == 'true'){
            $("#addItem").modal('hide');
            $("#formaddItem").find("input[type=text], input[type=number], textarea").val("");
            
        }else if(data.success == 'false'){
          swal("Error!", data.msg, "warning");          
        }
        
      }
    })
  }

    //Select Vendor
    function selectVendor(id){
        $.ajax({
            url: "{{ url('po/vendor') }}/"+id,
            data: { poID: "{{ $po->id }}"},
            dataType: "json",
            type: "GET",
            success: function(data){
                $("#vendorName").html(data.data.name);
                $("#vendorEmail").html(data.data.email);
                $("#vendorPhone").html(data.data.phone);
                $("#vendorAddress").html(data.data.address);
                $("#selectVendor").modal('hide');
            }
        });
    }   
</script>
@endsection