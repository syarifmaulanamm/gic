@extends('admin_template')

@section('content')
    <style>
    .modal-body {
      background-color: white !important;
    }
    </style>
    <div class="row">
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $goods->count() }}</h3>
                    <p>Goods</p>
                </div>
                <div class="icon"><i class="fa fa-archive"></i></div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#addGoods">
                    Add Goods
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-red">
                <div class="inner">
                    <h3></h3>
                    <p>Out Of Stock</p>
                </div>
                <div class="icon"><i class="fa fa-shopping-cart"></i></div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailOOS">
                    More Info
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3></h3>
                    <p>Stock < 50 Pcs</p>
                </div>
                <div class="icon"><i class="fa fa-hourglass-2"></i></div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailLessStock"> 
                    More Info
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-xs-6">
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>5</h3>
                    <p>Borrowed</p>
                </div>
                <div class="icon"><i class="fa fa-pie-chart"></i></div>
                <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailBorrowed">
                    More Info
                    <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
    <div class='row'>
        <div class='col-md-12'>
            <!-- Box -->
            
          <div class="box">
          <!-- <div class="box-header">
            <h3 class="box-title">Data Table With Full Features</h3>
          </div> -->
          <!-- /.box-header -->
          <div class="box-body">
            <table id="data" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Updated</th>
                <th width="105px">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach($goods as $item)
                <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->stock}}</td>
                  <td>{{$item->updated_at}}</td>
                  <td>
                    <button onclick="detailGoods({{$item->id}})" class="btn btn-default" title="Detail"><i class="fa fa-eye"></i></button>
                    <button onclick="updGoods({{$item->id}})" class="btn btn-default" title="Edit"><i class="fa fa-edit"></i></button>
                    <button onclick="delGoods({{$item->id}})" class="btn btn-default" title="Delete"><i class="fa fa-trash"></i></button>
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Updated</th>
                <th>Action</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('js')

@endsection