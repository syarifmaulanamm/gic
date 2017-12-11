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
<input type="hidden" name="id" value="{{ $client->id }}">
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
                    <select name="classification" class="form-control" required>
                        <option value="1" @if($client->classification == 1) selected @endif>General Trading</option>
                        <option value="2" @if($client->classification == 2) selected @endif>Mining</option>
                        <option value="3" @if($client->classification == 3) selected @endif>Others</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Name Of Company*</label>
                <div class="col-sm-9">
                    <input type="text" name="name_of_company" class="form-control" value="{{ $client->name_of_company }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Phone</label>
                <div class="col-sm-9">
                    <input type="text" name="phone" class="form-control" value="{{ $client->phone }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Fax</label>
                <div class="col-sm-9">
                    <input type="text" name="fax" class="form-control" value="{{ $client->fax }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <input type="email" name="email" class="form-control" value="{{ $client->email }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Website</label>
                <div class="col-sm-9">
                    <input type="text" name="website" class="form-control" value="{{ $client->website }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Kind Of Business</label>
                <div class="col-sm-9">
                    <input type="text" name="kind_of_business" class="form-control" value="{{ $client->kind_of_business }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Number Of Employee</label>
                <div class="col-sm-9">
                    <input type="number" name="number_of_employee" class="form-control" value="{{ $client->number_of_employee }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Bank Account</label>
                <div class="col-sm-9">
                    <input type="text" name="bank_account" class="form-control" value="{{ $client->bank_account }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Address</label>
                <div class="col-sm-9">
                    <textarea name="address" class="form-control">{{ $client->address }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Other Office Location</label>
                <div class="col-sm-9">
                    <textarea name="other_office_location" class="form-control">{{ $client->other_office_location }}</textarea>
                </div>
            </div>  
            <div class="form-group">
                <label class="col-sm-3 control-label">Date Of Assign</label>
                <div class="col-sm-9">
                    <input type="date" name="date_of_assign" class="form-control" value="{{ $client->date_of_assign }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Sales Rep.</label>
                <div class="col-sm-9">
                    <input type="text" name="sales_rep" class="form-control" value="{{ $client->sales_rep }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Manager</label>
                <div class="col-sm-9">
                    <input type="text" name="manager" class="form-control" value="{{ $client->manager }}">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Remarks</label>
                <div class="col-sm-9">
                    <textarea name="remarks" class="form-control">{{ $client->remarks }}</textarea>
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
                        <input type="date" name="dob[]" class="form-control">
                    </td>
                    <td data-name="doj">
                        <input type="date" name="doj[]" class="form-control">
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
                <?php $no = 1; ?>
                @foreach($details as $item)
                <tr id="pic{{ $no }}" data-id="{{ $no }}">
                    <td data-name="name">
                        <input type="text" name="pic[]" class="form-control" value="{{ $item->pic }}">
                    </td>
                    <td data-name="title">
                        <input type="text" name="title[]" class="form-control" value="{{ $item->title }}">
                    </td>
                    <td data-name="dob">
                        <input type="date" name="dob[]" class="form-control" value="{{ $item->date_of_birth }}">
                    </td>
                    <td data-name="doj">
                        <input type="date" name="doj[]" class="form-control" value="{{ $item->date_of_join }}">
                    </td>
                    <td data-name="phone">
                        <input type="text" name="phonePIC[]" class="form-control" value="{{ $item->phone }}">
                    </td>
                    <td data-name="ext">
                        <input type="text" name="ext[]" class="form-control" value="{{ $item->ext }}">
                    </td>
                    <td data-name="comments">
                        <input type="text" name="comments[]" class="form-control" value="{{ $item->other_information }}">
                    </td>
                    <td data-name="del">
                        <button type="button" class="btn btn-danger btn-sm btnDelete"><i class="fa fa-close"></i></button>
                    </td>
                </tr>
                <?php $no++; ?>
                @endforeach
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

    });
</script>
@endsection