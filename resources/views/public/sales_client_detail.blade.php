@extends('admin_template')

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <button type="button" class="btn btn-default" onclick="document.location='{{ URL::previous() }}'"><i class="fa fa-chevron-left"></i> Back</button>
        <button class="btn btn-box-tool pull-right" onclick="window.print()"><i class="fa fa-print"></i></button>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tr>
                <td colspan="4" class="text-center bg-green">
                    <i class="fa fa-building fa-5x"></i>
                </td>
            </tr>
            <tr>
                <td><strong>Classification</strong></td>
                <td colspan="3">
                @if($client->classification == 1)
                General Trading
                @elseif($client->classification == 2)
                Mining
                @elseif($client->classification == 3)
                Others
                @endif
                </td>
            </tr>
            <tr>
                <td><strong>Name Of Company</strong></td>
                <td colspan="3">{{ $client->name_of_company }}</td>
            </tr>
            <tr>
                <td><strong>Phone</strong></td>
                <td colspan="3">{{ $client->phone }}</td>
            </tr>
            <tr>
                <td><strong>Fax</strong></td>
                <td colspan="3">{{ $client->fax }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td colspan="3">{{ $client->email }}</td>
            </tr> 
            <tr>
                <td><strong>Website</strong></td>
                <td colspan="3">{{ $client->website }}</td>
            </tr>
            <tr>
                <td><strong>Kind Of Business</strong></td>
                <td colspan="3">{{ $client->kind_of_business }}</td>
            </tr>
            <tr>
                <td><strong>Number Of Employee</strong></td>
                <td colspan="3">{{ $client->number_of_employee }}</td>
            </tr>
            <tr>
                <td><strong>Bank Account</strong></td>
                <td colspan="3">{{ $client->bank_account }}</td>
            </tr>
            <tr>
                <td><strong>Address</strong></td>
                <td colspan="3">{{ $client->address }}</td>
            </tr>
            <tr>
                <td><strong>Other Office Location</strong></td>
                <td colspan="3">{{ $client->other_office_location }}</td>
            </tr>
            <tr>
                <td><strong>Date Of Assign</strong></td>
                <td><strong>Sales Rep.</strong></td>
                <td><strong>Manager</strong></td>
                <td><strong>Remarks</strong></td>
            </tr>
            <tr>
                <td>{{ date('d-m-Y', strtotime($client->date_of_assign)) }}</td>
                <td>{{ $client->sales_rep }}</td>
                <td>{{ $client->manager }}</td>
                <td>{{ $client->remarks }}</td>
            </tr>
        </table>
    </div>
</div>
<div class="box box-default">
    <div class="box-header with-border">
        Company Details
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <thead>
                <th>Name Of Person Incharge</th>
                <th>Title</th>
                <th>Date Of Birth</th>
                <th>Date Of Join</th>
                <th>Phone</th>
                <th>Ext.</th>
                <th>Comments/Other Information</th>
            </thead>
            <tbody>
                @foreach($details as $item)
                <tr>
                    <td>{{ $item->pic }}</td>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->date_of_birth }}</td>
                    <td>{{ $item->date_of_join }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->ext }}</td>
                    <td>{{ $item->other_information }}</td>
                </tr>
                @endforeach
            </tbody>
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