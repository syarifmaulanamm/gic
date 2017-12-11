@extends('admin_template')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="small-box bg-blue">
            <div class="inner">
                <h3>{{ $goods->count() }}</h3>
                <p>Inventory</p>
            </div>
            <div class="icon"><i class="fa fa-archive" aria-hidden="true"></i></div>
            <a href="#" class="small-box-footer">
                More Info
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-red">
            <div class="inner">
                <h3>{{ $oos->count() }}</h3>
                <p>Out Of Stock</p>
            </div>
            <div class="icon"><i class="fa fa-shopping-cart"></i></div>
            <a href="#" class="small-box-footer">
                More Info
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3">
        <div class="small-box bg-yellow">
            <div class="inner">
                <h3>{{ $lessStock->count() }}</h3>
                <p>Stock < 50 Pcs</p>
            </div>
            <div class="icon"><i class="fa fa-hourglass-2"></i></div>
            <a href="#" class="small-box-footer"> 
                More Info
                <i class="fa fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
</div>
@endsection