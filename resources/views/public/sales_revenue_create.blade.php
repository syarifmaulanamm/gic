@extends('admin_template')

@section('content')

<div class="callout callout-info">
    <h4>Tip!</h4>
    <p>Input sales revenue performance every month to get complete report</p>
</div>

<div class="box box-default">
    <div class="box-body">
        <div class="col-md-8 col-md-offset-2">

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
            <div class="form-group">
                <label class="col-sm-3 control-label">Name Of Company</label>
                <div class="col-sm-9">
                <select name="sales_client_id" class="form-control selectpicker" data-live-search="true">
                    <option value=""></option>
                    @foreach($client_status as $item)
                    <option value="{{ $item->id }}">{{ $item->name_of_company }}</option>
                    @endforeach
                </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Group Of Report</label>
                <div class="col-sm-9">
                    <select name="report_type" class="form-control selectpicker" data-live-search="true">
                        <option value="0"></option>
                        <option value="1">Domestic Airlines</option>
                        <option value="2">International Airlines</option>
                        <option value="3">Tour</option>
                        <option value="4">Others</option>
                    </select>
                </div>
            </div>
            <div class="form-group hide" id="airlines_dom">
                <label class="col-sm-3 control-label">Airlines</label>
                <div class="col-sm-9">
                    <select name="subject" class="form-control selectpicker" data-live-search="true">
                        @foreach($airlines_dom as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group hide" id="airlines_int">
                <label class="col-sm-3 control-label">Airlines</label>
                <div class="col-sm-9">
                    <select name="subject" class="form-control selectpicker" data-live-search="true">
                        @foreach($airlines_int as $item)
                        <option value="{{ $item->name }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group hide" id="tour">
                <label class="col-sm-3 control-label">Subject</label>
                <div class="col-sm-9">
                    <select name="subject" class="form-control selectpicker" data-live-search="true">
                        @foreach($tour as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group hide" id="others">
                <label class="col-sm-3 control-label">Subject</label>
                <div class="col-sm-9">
                    <select name="subject" class="form-control selectpicker" data-live-search="true">
                        @foreach($others as $item)
                        <option value="{{ $item }}">{{ $item }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Gross</label>
                <div class="col-sm-9">
                    <input type="text" name="gross" class="form-control currency">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Netto</label>
                <div class="col-sm-9">
                    <input type="text" name="netto" class="form-control currency">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Profit</label>
                <div class="col-sm-9">
                    <input type="text" name="profit" class="form-control currency" readonly>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Month</label>
                <div class="col-sm-9">
                    <input type="text" name="month" class="form-control monthpicker">
                </div>
            </div>
            <div class="col-md-9 col-md-offset-3">
                <button type="submit" class="btn btn-primary">Submit <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            </div>
        </form>
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

        $('.currency').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 2,
            autoGroup: true,
            rightAlign: false,
            oncleared: function () {
                self.Value('');
            }
        });

        $(".monthpicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months", 
            minViewMode: "months"
        });

        $('select[name="report_type"]').on('change', function(){
            if($(this).val() == '1'){
                $("#airlines_dom").removeClass('hide');
                $("#airlines_int").addClass('hide');
                $("#tour").addClass('hide');
                $("#others").addClass('hide');
                
                $("#airlines_dom").find('select').attr('name', 'subject');
                $("#airlines_int").find('select').attr('name', '');
                $("#tour").find('select').attr('name', '');
                $("#others").find('select').attr('name', '');
            }else if($(this).val() == '2'){
                $("#airlines_dom").addClass('hide');
                $("#airlines_int").removeClass('hide');
                $("#tour").addClass('hide');
                $("#others").addClass('hide');
                
                $("#airlines_dom").find('select').attr('name', '');
                $("#airlines_int").find('select').attr('name', 'subject');
                $("#tour").find('select').attr('name', '');
                $("#others").find('select').attr('name', '');
            }else if($(this).val() == '3'){
                $("#airlines_dom").addClass('hide');
                $("#airlines_int").addClass('hide');
                $("#tour").removeClass('hide');
                $("#others").addClass('hide');
                
                $("#airlines_dom").find('select').attr('name', '');
                $("#airlines_int").find('select').attr('name', '');
                $("#tour").find('select').attr('name', 'subject');
                $("#others").find('select').attr('name', '');
            }else if($(this).val() == '4'){
                $("#airlines_dom").addClass('hide');
                $("#airlines_int").addClass('hide');
                $("#tour").addClass('hide');
                $("#others").removeClass('hide');
                
                $("#airlines_dom").find('select').attr('name', '');
                $("#airlines_int").find('select').attr('name', '');
                $("#tour").find('select').attr('name', '');
                $("#others").find('select').attr('name', 'subject');
            }
        });

        $('input[name="gross"]').on('keyup', function(){
            var gross = parseFloat($(this).val().replace(/,/g, ''));
            var netto = parseFloat($('input[name="netto"]').val().replace(/,/g, ''));

            $('input[name="profit"]').val(gross - netto);
        });
        
        $('input[name="netto"]').on('keyup', function(){
            var gross = parseFloat($('input[name="gross"]').val().replace(/,/g, ''));
            var netto = parseFloat($(this).val().replace(/,/g, ''));

            $('input[name="profit"]').val(gross - netto);
        });
    });
</script>
@endsection