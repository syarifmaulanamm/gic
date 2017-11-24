@extends('admin_template')

@section('content')
    <style>
    .modal {
      overflow-y:auto;
    }
    .modal-body {
      background-color: white !important;
    }
    </style>
    <div class='row'>
        <div class='col-md-9'>
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
                <th width="10">Action</th>
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
        <div class="col-md-3">
          <div class="small-box bg-red">
              <div class="inner">
                  <h3>{{ $oos->count() }}</h3>
                  <p>Out Of Stock</p>
              </div>
              <div class="icon"><i class="fa fa-shopping-cart"></i></div>
              <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailOOS">
                  More Info
                  <i class="fa fa-arrow-circle-right"></i>
              </a>
          </div>
          <div class="small-box bg-yellow">
              <div class="inner">
                  <h3>{{ $lessStock->count() }}</h3>
                  <p>Stock < 50 Pcs</p>
              </div>
              <div class="icon"><i class="fa fa-hourglass-2"></i></div>
              <a href="#" class="small-box-footer" data-toggle="modal" data-target="#detailLessStock"> 
                  More Info
                  <i class="fa fa-arrow-circle-right"></i>
              </a>
          </div>
        </div>
    </div><!-- /.row -->
    
    <!-- Modal Add Goods -->
    <div class="modal fade" id="addGoods" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-aqua">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-plus"></i> Add Inventory</h4>
          </div>
          <div class="modal-body">
            <div id="addGoodsAlert" class="alert alert-danger alert-dismissible" style="display:none;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <span></span>
            </div>
            <form action="{{ url('inventory/create') }}" id="formAddGoods" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="id">ID</label>
                <div class="input-group">
                  <span class="input-group-addon">GAT/INV/</span>
                  <input type="text" name="id" class="form-control" value="{{ $newID }}" readonly>
               </div>
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" autofocus>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <div class="input-group">
                  <span class="input-group-addon">IDR</span>
                  <input type="text" name="price" class="form-control">
               </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" min="0" name="stock" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <br>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="in_stock">
                      In Stock
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="condition">Condition</label>
                <input type="text" name="condition" class="form-control">
              </div>
              <div class="form-group">
                <label for="specification">Specification</label>
                <textarea name="specification" rows="10" class="form-control editor"></textarea>
              </div>
              <div class="form-group">
                <label for="notes">Notes</label>
                <textarea name="notes" rows="10" class="form-control editor"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="addGoods()">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Modal Edit Goods -->
      <div class="modal fade" id="updGoods" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-aqua">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-edit"></i> Edit Inventory</h4>
          </div>
          <div class="modal-body">
            <form id="formUpdGoods" action="{{ url('inventory/update') }}" method="post">
              {{ csrf_field() }}
              <div class="form-group">
                <label for="id">ID</label>
                <div class="input-group">
                  <span class="input-group-addon">GAT/INV/</span>
                  <input type="text" name="id" class="form-control" readonly>
               </div>
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" autofocus>
              </div>
              <div class="form-group">
                <label for="price">Price</label>
                <div class="input-group">
                  <span class="input-group-addon">IDR</span>
                  <input type="text" name="price" class="form-control">
               </div>
              </div>
              <div class="row">
                <div class="col-md-10">
                  <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" min="0" name="stock" class="form-control">
                  </div>
                </div>
                <div class="col-md-2">
                  <br>
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="in_stock">
                      In Stock
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="condition">Condition</label>
                <input type="text" name="condition" class="form-control">
              </div>
              <div class="form-group" id="formUpdGoodsSpec">
                <label for="specification">Specification</label>
                <textarea name="specification" rows="10" class="form-control editor"></textarea>
              </div>
              <div class="form-group" id="formUpdGoodsNotes">
                <label for="notes">Notes</label>
                <textarea name="notes" rows="10" class="form-control editor"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="doUpdGoods()">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Modal Out Of Stock -->
      <div class="modal fade" id="detailOOS" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-red">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-shopping-cart"></i> Out Of Stock Goods</h4>
          </div>
          <div class="modal-body">
            <table class="table table-bordered datatables">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Updated</th>
                  <th width="20px">Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($oos as $item)
              <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->updated_at}}</td>
                <td>
                  <button onclick="detailGoods({{$item->id}})" class="btn btn-default btn-block" title="Detail"><i class="fa fa-eye"></i></button>
                </td>
              </tr>
              @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Updated</th>
                  <th width="20px">Action</th>
                </tr>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Modal less stock-->
      <div class="modal fade" id="detailLessStock" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-yellow">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-hourglass-half"></i> Stock < 50 Pcs</h4>
          </div>
          <div class="modal-body">
            <table class="table table-bordered datatables">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Name</th>
                  <th>Stock</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($lessStock as $item)
              <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->updated_at}}</td>
                <td>
                  <button onclick="detailGoods({{ $item->id }})" class="btn btn-default btn-block" title="Detail"><i class="fa fa-eye"></i></button>
                </td>
              </tr>
              @endforeach
              <tfoot>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Action</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Modal Detail Goods -->
      <div class="modal fade" id="detailGoods" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-archive"></i> GAT/INV/<span id="dtId"></span></h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-4">
              <table class="table table-bordered">
                <tr>
                  <th>Name</th>
                  <td><span id="dtName"></span></td>
                </tr>
                <tr>
                  <th>Price</th>
                  <td>IDR <span id="dtPrice"></span></td>
                </tr>
                <tr>
                  <th>Condition</th>
                  <td><span id="dtCondition"></span></td>
                </tr>
                <tr>
                  <th>Stock</th>
                  <td><span id="dtStock"></span></td>
                </tr>
                <tr>
                  <th>Barcode</th>
                  <td><img src="" id="dtBarcode" height="100px"></td>
                </tr>
              </table>
              </div>
              <div class="col-md-8">
                <div class="box-group" id="accordion">
                  <div class="panel box box-success">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#specification" aria-expanded="true"><i class="fa fa-list"></i> Specification</a>
                      </h4>
                    </div>
                    <div id="specification" class="panel-collapse collapse in" aria-expanded="true">
                      <div class="box-body"><span id="dtSpecification"></span></div>
                    </div>
                  </div>
                  <div class="panel box box-success">
                    <div class="box-header with-border">
                      <h4 class="box-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#notes" aria-expanded="false"><i class="fa fa-list"></i> Notes</a>
                      </h4>
                    </div>
                    <div id="notes" class="panel-collapse collapse" aria-expanded="false">
                      <div class="box-body"><span id="dtNotes"></span></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Stock In -->
      <div class="modal fade" id="stockIn" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-aqua">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-download"></i> Stock In</h4>
          </div>
          <div class="modal-body">
            <div id="InAlert" class="alert alert-danger alert-dismissible" style="display:none;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <span></span>
            </div>
            <form action="{{ url('inventory/in') }}" id="formIn" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-10 col-sm-10">
                  <div class="form-group">
                    <label for="id">ID</label>
                    <div class="input-group">
                      <span class="input-group-addon">GAT/INV/</span>
                      <input type="text" name="id" class="form-control" autofocus> 
                  </div>
                  </div>
                </div>
                <div class="col-md-2 col-sm-2">
                  <button type="button" data-toggle="modal" data-target="#selectItem" title="Select Item" style="margin-top:25px" class="btn btn-primary btn-block">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="stock">Quantity</label>
                <input type="number" min="0" name="qty" class="form-control">
              </div>
              <div class="form-group">
                <label for="notes">Notes</label>
                <textarea name="notes" rows="10" class="form-control editor"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="stockIn()">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Stock Out -->
      <div class="modal fade" id="stockOut" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-aqua">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-upload"></i> Stock Out</h4>
          </div>
          <div class="modal-body">
            <div id="OutAlert" class="alert alert-danger alert-dismissible" style="display:none;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <span></span>
            </div>
            <form action="{{ url('inventory/out') }}" id="formOut" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-10 col-sm-10">
                  <div class="form-group">
                    <label for="id">ID</label>
                    <div class="input-group">
                      <span class="input-group-addon">GAT/INV/</span>
                      <input type="text" name="id" class="form-control" autofocus> 
                  </div>
                  </div>
                </div>
                <div class="col-md-2 col-sm-2">
                  <button type="button" data-toggle="modal" data-target="#selectItem" title="Select Item" style="margin-top:25px" class="btn btn-primary btn-block">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="name">Person In Charge</label>
                <input type="text" name="pic" class="form-control">
              </div>
              <div class="row">
              <div class="col-md-10">
                <div class="form-group">
                  <label for="qty">Quantity</label>
                  <input type="number" min="0" name="qty" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <br>
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="borrow">
                    Borrow
                  </label>
                </div>
              </div>
            </div>
              <div class="form-group">
                <label for="notes">Notes</label>
                <textarea name="notes" rows="10" class="form-control editor"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="stockOut()">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Returning Inventory -->
      <div class="modal fade" id="stockReturn" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-teal">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-reply"></i> Return</h4>
          </div>
          <div class="modal-body">
            <div id="RtAlert" class="alert alert-danger alert-dismissible" style="display:none;">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h4><i class="icon fa fa-ban"></i> Alert!</h4>
              <span></span>
            </div>
            <form action="{{ url('inventory/return') }}" id="formReturn" method="post">
              {{ csrf_field() }}
              <div class="row">
                <div class="col-md-10 col-sm-10">
                  <div class="form-group">
                    <label for="id">ID</label>
                    <div class="input-group">
                      <span class="input-group-addon">GAT/INV/OUT/</span>
                      <input type="text" name="id" class="form-control" autofocus> 
                  </div>
                  </div>
                </div>
                <div class="col-md-2 col-sm-2">
                  <button type="button" data-toggle="modal" data-target="#selectStockOut" title="Select Item" style="margin-top:25px" class="btn btn-primary btn-block">
                    <i class="fa fa-search"></i>
                  </button>
                </div>
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="name">Person In Charge</label>
                <input type="text" name="pic" class="form-control" readonly>
              </div>
              <div class="form-group">
                <label for="stock">Quantity</label>
                <input type="number" min="0" name="qty" class="form-control">
              </div>
              <div class="form-group" id="formReturnNotes">
                <label for="notes">Notes</label>
                <textarea name="notes" rows="10" class="form-control editor"></textarea>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" onclick="stockReturn()">Save changes</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Select Item -->
      <div class="modal fade" id="selectItem" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-archive"></i> Select Item</h4>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped datatables">
              <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Stock</th>
                <th>Updated</th>
                <th width="20px">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach($goods as $item)
                <tr>
                  <td>{{$item->id}}</td>
                  <td>{{$item->name}}</td>
                  <td>{{$item->stock}}</td>
                  <td>{{$item->updated_at}}</td>
                  <td class="text-center">
                    <button onclick="selectItem({{ $item->id }})" class="btn btn-sm btn-default" title="Select"><i class="fa fa-check"></i></button>
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
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

      <!-- Select Stock Out -->
      <div class="modal fade" id="selectStockOut" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header bg-green">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><i class="fa fa-archive"></i> Select Item</h4>
          </div>
          <div class="modal-body">
            <table class="table table-bordered table-striped datatables">
              <thead>
              <tr>
                <th>ID</th>
                <th>Name</th>
                <th>PIC</th>
                <th>Quantity</th>
                <th>Notes</th>
                <th>Date</th>
                <th width="20px">Action</th>
              </tr>
              </thead>
              <tbody>
                @foreach($stockOut as $item)
                <tr>
                  <td>GAT/INV/OUT/{{$item->id}}</td>
                  <td>{{$item->goods_name}}</td>
                  <td>{{$item->pic}}</td>
                  <td>{{$item->qty}}</td>
                  <td>{!! $item->notes !!}</td>
                  <td>{{$item->created_at}}</td>
                  <td class="text-center">
                    <button onclick="selectOutItem({{ $item->id }})" class="btn btn-sm btn-default" title="Select"><i class="fa fa-check"></i></button>
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
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->
@endsection

@section('js')
<script>
  $(function () {
    $('#data').DataTable();
    $('.datatables').DataTable();
    $('.editor').wysihtml5();
    $("#formIn").on('keyup', "input[name='id']", function(){
      $.ajax({
        url: "{{url('inventory')}}/"+$(this).val(),
        dataType: "json",
        type: "GET",
        success: function(data){
          $("#formIn").find("input[name='id']").val(data.data.id);
          $("#formIn").find("input[name='name']").val(data.data.name);
        }
      });
    });

    $("#formOut").on('keyup', "input[name='id']", function(){
      $.ajax({
        url: "{{url('inventory')}}/"+$(this).val(),
        dataType: "json",
        type: "GET",
        success: function(data){
          $("#formOut").find("input[name='id']").val(data.data.id);
          $("#formOut").find("input[name='name']").val(data.data.name);
        }
      });
    });

    $("#formOut").on('keyup', "input[name='qty']", function(){
      var id = $("#formOut").find("input[name='id']").val();
      $.ajax({
        url: "{{url('inventory')}}/"+id,
        dataType: "json",
        type: "GET",
        success: function(data){
          if($("#formOut").find("input[name='qty']").val() > data.data.stock){
            swal("Error!", "Not Enough Stock", "warning"); 
          }
        }
      });
    });
  })
  // Add Goods
  function addGoods(e){
    $.ajax({
      type: "POST",
      url: $("#formAddGoods").attr('action'),
      dataType: "json",
      data: $("#formAddGoods").serialize(),
      success: function(data)
      {
        if(data.error){
          var errors = $.makeArray(data.error);
          var html = "<ul>";
          $.map(errors, function(a){
            html += "<li>"+ a +"</li>";
          });
          html += "</ul>";
          $("#addGoodsAlert span").html(html);

          $("#addGoodsAlert").fadeIn('slow');
        }

        if(data.success == 'true'){
          $("#addGoods").modal('hide');
          $("formAddGoods").find("input[type=text], input[type=number], input[type=checkbox], textarea").val("");
          swal("Success!", data.msg, "success");          
        }else if(data.success == 'false'){
          swal("Error!", data.msg, "warning");          
        }
        
      }
    })
  }
  // Show Goods details
  function detailGoods(id){
    $.ajax({
      url: "{{url('inventory')}}/"+id,
      dataType: "json",
      type: "GET",
      success: function(data){
        $("#dtId").html(data.data.id);
        $("#dtName").html(data.data.name);
        $("#dtPrice").html(data.data.price);
        $("#dtCondition").html(data.data.condition);
        $("#dtStock").html(data.data.stock);
        $("#dtSpecification").html(data.data.specification);
        $("#dtNotes").html(data.data.notes);
        $("#dtBarcode").attr('src', 'http://bwipjs-api.metafloor.com/?bcid=code128&text='+data.data.id+'&includetext');
      }
    })
    $("#detailGoods").modal("show");
  }
  // Open Edit modal
  function updGoods(id){
    $.ajax({
      url: "{{url('inventory')}}/"+id,
      dataType: "json",
      type: "GET",
      success: function(data){
        $("#formUpdGoods").find("input[name='id']").val(data.data.id);
        $("#formUpdGoods").find("input[name='name']").val(data.data.name);
        $("#formUpdGoods").find("input[name='price']").val(data.data.price);
        $("#formUpdGoods").find("input[name='stock']").val(data.data.stock);
        if(data.data.in_stock == 1)
        {
          $("#formUpdGoods").find("input[name='in_stock']").prop('checked', true);
        }else{
          $("#formUpdGoods").find("input[name='in_stock']").prop('checked', false);
        }
        $("#formUpdGoods").find("input[name='condition']").val(data.data.condition);
        $('#formUpdGoodsSpec iframe').contents().find('.wysihtml5-editor').html(data.data.specification);
        $('#formUpdGoodsNotes iframe').contents().find('.wysihtml5-editor').html(data.data.notes);
      }
    })
    $("#updGoods").modal("show");
  }
  // Process to update Goods
  function doUpdGoods(e){
    $.ajax({
      type: "POST",
      url: $("#formUpdGoods").attr('action'),
      dataType: "json",
      data: $("#formUpdGoods").serialize(),
      success: function(data)
      {
        if(data.error){
          var errors = $.makeArray(data.error);
          var html = "<ul>";
          $.map(errors, function(a){
            html += "<li>"+ a +"</li>";
          });
          html += "</ul>";
          $("#addGoodsAlert span").html(html);

          $("#addGoodsAlert").fadeIn('slow');
        }

        if(data.success == 'true'){
          $("#updGoods").modal('hide');
          swal("Success!", data.msg, "success");          
        }else if(data.success == 'false'){
          swal("Error!", data.msg, "warning");          
        }
        
      }
    })    
  }
  // Deleting Goods
  function delGoods(id){
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
        url: "{{url('inventory')}}/"+id,
        dataType: "json",
        data: {_method: 'delete', _token : '{{ csrf_token() }}' },
        success: function(data){
          swal("Deleted!", "Your data has been deleted.", "success");
        }
      });
    });
  }

  var indicator = 0;
  // Select Item
  function selectItem(id){
    $.ajax({
      url: "{{url('inventory')}}/"+id,
      dataType: "json",
      type: "GET",
      success: function(data){
        if(indicator == 0){
          $("#formIn").find("input[name='id']").val(data.data.id);
          $("#formIn").find("input[name='name']").val(data.data.name);
          $("#stockIn").modal('show');
        }else{
          $("#formOut").find("input[name='id']").val(data.data.id);
          $("#formOut").find("input[name='name']").val(data.data.name);
          $("#stockOut").modal('show');          
        }
        $("#selectItem").modal('hide');
      }
    });
  }
  // Select Out Item
  function selectOutItem(id){
    $.ajax({
      url: "{{url('inventory')}}/out/"+id,
      dataType: "json",
      type: "GET",
      success: function(data){
        console.log(id);
        $("#formReturn").find("input[name='id']").val(data.data.id);
        $("#formReturn").find("input[name='name']").val(data.data.goods_name);
        $("#formReturn").find("input[name='pic']").val(data.data.pic);
        $("#formReturn").find("input[name='qty']").val(data.data.qty);
        $('#formReturnNotes iframe').contents().find('.wysihtml5-editor').html(data.data.notes);

        $("#selectStockOut").modal('hide');
      }
    });
  }

  $('#stockIn').on('shown.bs.modal', function (e) {
    indicator= 0;
  });

  $('#stockOut').on('shown.bs.modal', function (e) {
    indicator= 1;
  });

  // Stock In
  function stockIn(){
    $.ajax({
      type: "POST",
      url: $("#formIn").attr('action'),
      dataType: "json",
      data: $("#formIn").serialize(),
      success: function(data)
      {
        if(data.error){
          var errors = $.makeArray(data.error);
          var html = "<ul>";
          $.map(errors, function(a){
            html += "<li>"+ a +"</li>";
          });
          html += "</ul>";
          $("#InAlert span").html(html);

          $("#InAlert").fadeIn('slow');
        }

        if(data.success == 'true'){
          $("#stockIn").modal('hide');
          $("#formIn").find("input[type=text], input[type=number], textarea").val("");
          swal("Success!", data.msg, "success");          
        }else if(data.success == 'false'){
          swal("Error!", data.msg, "warning");          
        }
        
      }
    })
  }

  // Stock Out
  function stockOut(){
    $.ajax({
      type: "POST",
      url: $("#formOut").attr('action'),
      dataType: "json",
      data: $("#formOut").serialize(),
      success: function(data)
      {
        if(data.error){
          var errors = $.makeArray(data.error);
          var html = "<ul>";
          $.map(errors, function(a){
            html += "<li>"+ a +"</li>";
          });
          html += "</ul>";
          $("#OutAlert span").html(html);

          $("#OutAlert").fadeIn('slow');
        }

        if(data.success == 'true'){
          $("#stockOut").modal('hide');
          $("#formOut").find("input[type=text], input[type=number], textarea").val("");
          window.location = '{{ url('inventory/receipt/out') }}/'+data.receipt ;     
        }else if(data.success == 'false'){
          swal("Error!", data.msg, "warning");          
        }
        
      }
    })
  }

  // Stock Return
  function stockReturn(){
    $.ajax({
      type: "POST",
      url: $("#formReturn").attr('action'),
      dataType: "json",
      data: $("#formReturn").serialize(),
      success: function(data)
      {
        if(data.error){
          var errors = $.makeArray(data.error);
          var html = "<ul>";
          $.map(errors, function(a){
            html += "<li>"+ a +"</li>";
          });
          html += "</ul>";
          $("#RtAlert span").html(html);

          $("#RtAlert").fadeIn('slow');
        }

        if(data.success == 'true'){
          $("#stockReturn").modal('hide');
          $("#formReturn").find("input[type=text], input[type=number], textarea").val("");
          window.location = '{{ url('inventory/receipt/out') }}/'+data.receipt ;     
        }else if(data.success == 'false'){
          swal("Error!", data.msg, "warning");          
        }
        
      }
    })
  }
</script>
@endsection