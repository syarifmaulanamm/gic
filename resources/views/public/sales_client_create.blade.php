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
{{ csrf_field() }}
<div class="box box-default">
    <div class="box-header with-border">
    <button type="button" class="btn btn-default" onclick="document.location='{{ URL::previous() }}'"><i class="fa fa-chevron-left"></i> Back</button>
    <button type="submit" class="btn btn-primary pull-right"><i class="fa fa-check"></i> Save</button>
    </div>
    <div class="box-body">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-sm-3 control-label">Classification*</label>
                <div class="col-sm-9">
                    <select name="classification" class="form-control selectpicker" data-live-search="true" required>
                        <option value="1">General Trading</option>
                        <option value="2">Mining</option>
                        <option value="3">Others</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Name Of Company*</label>
                <div class="col-sm-9">
                    <input type="text" name="name_of_company" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-9">
                    <input type="text" name="phone" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Fax</label>
                <div class="col-sm-9">
                    <input type="text" name="fax" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Website</label>
                <div class="col-sm-9">
                    <input type="text" name="website" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Kind Of Business</label>
                <div class="col-sm-9">
                    <input type="text" name="kind_of_business" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Number Of Employee</label>
                <div class="col-sm-9">
                    <input type="number" name="number_of_employee" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Bank Account</label>
                <div class="col-sm-9">
                    <input type="text" name="bank_account" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Address</label>
                <div class="col-sm-9">
                    <textarea name="address" class="form-control"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Other Office Location</label>
                <div class="col-sm-9">
                    <textarea name="other_office_location" class="form-control"></textarea>
                </div>
            </div>  
            <div class="form-group">
                <label class="col-sm-3 control-label">Date Of Assign</label>
                <div class="col-sm-9">
                    <input type="text" name="date_of_assign" class="form-control datepicker">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Sales Rep.</label>
                <div class="col-sm-9">
                    <input type="text" name="sales_rep" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Manager</label>
                <div class="col-sm-9">
                    <input type="text" name="manager" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="remarks" class="form-control"></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-default">
    <div class="box-header with-border text-center">
        <strong>Company Details</strong>
    </div>
    <div class="box-body">
        <table class="table table-bordered table-striped" id="tableItems">
            <thead>
                <tr>
                    <th>Name Of Person Incharge</th>
                    <th>Title</th>
                    <th>Date Of Birth</th>
                    <th>Date Of Join</th>
                    <th>Phone</th>
                    <th>Ext.</th>
                    <th>Comments / Other Information</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr id="pic0" data-id="0" class="hide">
                    <td data-name="name">
                        <input type="text" name="pic[]" class="form-control">
                    </td>
                    <td data-name="title">
                        <input type="text" name="title[]" class="form-control">
                    </td>
                    <td data-name="dob">
                        <input type="text" name="dob[]" class="form-control datepicker">
                    </td>
                    <td data-name="doj">
                        <input type="text" name="doj[]" class="form-control datepicker">
                    </td>
                    <td data-name="phone">
                        <input type="text" name="phonePIC[]" class="form-control">
                    </td>
                    <td data-name="ext">
                        <input type="text" name="ext[]" class="form-control">
                    </td>
                    <td data-name="comments">
                        <input type="text" name="comments[]" class="form-control">
                    </td>
                    <td data-name="del">
                        <button type="button" class="btn btn-danger btn-sm btnDelete"><i class="fa fa-close"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
        <br>
        <div class="text-center">
            <button type="button" class="btn btn-default" id="addItem"><i class="fa fa-plus"></i> Add Item</button>
        </div>
    </div>
</div>
</form>        
@endsection

@section('js')
<script>
    $(function(){
        $('.datatables').DataTable({
            "bSort" : false
        });
        
        $('.selectpicker').selectpicker({
            style: 'btn-info',
            size: 4
        });

        $(".datepicker").datepicker( {
            format: "dd-mm-yyyy"
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

                $(".datepicker").datepicker( {
                    format: "dd-mm-yyyy"
                });
            });
        });

    });
</script>
@endsection