<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Goods;
use App\StockIn;
use App\StockOut;
use App\StockReturn;
use DB;
use Excel;

class InventoryController extends Controller
{
    protected $AGENT = array();

    public function __construct()
    {
        $this->AGENT = session()->get("login_data");    
    }
    // Inventory
    public function index(Request $request)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Inventory';
        // All Goods
        $data['goods'] = Goods::all();
        $data['newID'] = date('ymd').sprintf("%04s", ($data['goods']->count()+1));;
        // Out Of Stock
        $data['oos'] = Goods::where('in_stock', 1)
                                ->where('stock', '<', 1)
                                ->get();
        // Less Stock
        $data['lessStock'] = Goods::where('in_stock', 1)
                                    ->where('stock', '<=', 50)
                                    ->get();
        // Stock Out
        $data['stockOut'] = DB::table('inv_goods_out')
                                ->join('inv_goods', 'inv_goods_out.goods_id', '=', 'inv_goods.id')
                                ->select('inv_goods_out.*', 'inv_goods.name as goods_name')
                                ->where('inv_goods_out.borrow', '=', 1)
                                ->where('inv_goods_out.status', '!=', 1)->get();

        if($data['AGENT']['role'] == 4){
            return view('private/inventory', $data);        
        }else{
            return view('public/inventory', $data);                    
        }
    }
    // Read
    public function read(Request $request, $id)
    {
        if($id){
            $goods = Goods::find($id);
            $goods->price = ($goods->price != '')?number_format((float)$goods->price, 0, '.', ','):'-';

            if($goods){
                return json_encode(array(
                    'success' => true,
                    'data' => $goods
                ));
            }else{
                return json_encode(array(
                    'success' => false,
                    'msg' => 'Something went wrong!'
                ));
            }
        }
    }
    // Create Process
    public function create(Request $request)
    {
        if(!$request->id){
            return json_encode(array(
                'success' => false,
                'msg' => 'Something went wrong!'
            ));
        }else{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'stock' => 'required'
            ]);

            if ($validator->passes()) {
                $goods = new Goods;
                $goods->id = $request->id;
                $goods->name = $request->name;
                $goods->price = $request->price;
                $goods->stock = $request->stock;
                $goods->in_stock = ($request->in_stock == "on")?1:0;
                $goods->condition = $request->condition;
                $goods->specification = $request->specification;
                $goods->notes = $request->notes;
                $goods->save();

                return response()->json(['success' => 'true', 'msg' => 'Data has been saved!']);
            }

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    // Update Goods
    public function update(Request $request)
    {
        if(!$request->id){
            return json_encode(array(
                'success' => false,
                'msg' => 'Something went wrong!'
            ));
        }else{
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'stock' => 'required'
            ]);

            if ($validator->passes()) {
                $goods = Goods::find($request->id);
                $goods->name = $request->name;
                $goods->price = $request->price;
                $goods->stock = $request->stock;
                $goods->in_stock = ($request->in_stock == "on")?1:0;
                $goods->condition = $request->condition;
                $goods->specification = $request->specification;
                $goods->notes = $request->notes;
                $goods->save();

                return response()->json(['success' => 'true', 'msg' => 'Data has been saved!']);
            }

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    // Delete Goods
    public function delete(Request $request, $id)
    {
        if(!$request->id){
            return json_encode(array(
                'success' => false,
                'msg' => 'Something went wrong!'
            ));
        }else{
            $goods = Goods::find($id)->delete();

            return response()->json(['success' => 'true', 'msg' => 'Data has been deleted!']);
        }
    }

    //Stock In
    public function stockIn(Request $request)
    {
        if(!$request->id){
            return json_encode(array(
                'success' => false,
                'msg' => 'Something went wrong!'
            ));
        }else{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'qty' => 'required'
            ]);

            if ($validator->passes()) {
                $in = new StockIn;
                $in->goods_id = $request->id;
                $in->qty = $request->qty;
                $in->notes = $request->notes;
                $in->save();

                $goods = Goods::find($request->id);
                $goods->stock = $goods->stock+$request->qty;
                $goods->save();

                return response()->json(['success' => 'true', 'msg' => 'Data has been saved!']);
            }

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    } 

    //Stock Out
    public function stockOut(Request $request)
    {
        if(!$request->id){
            return json_encode(array(
                'success' => false,
                'msg' => 'Something went wrong!'
            ));
        }else{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'pic' => 'required',
                'qty' => 'required'
            ]);

            if ($validator->passes()) {
                $out = new StockOut;
                $out->goods_id = $request->id;
                $out->pic = $request->pic;
                $out->qty = $request->qty;
                $out->borrow = ($request->borrow == "on")?1:0;
                $out->notes = $request->notes;
                $out->status = 0;
                $out->save();

                $goods = Goods::find($request->id);
                $goods->stock = $goods->stock-$request->qty;
                $goods->save();

                return response()->json(['success' => 'true', 'msg' => 'Data has been saved!', 'receipt' => $out->id]);
            }

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    } 

    // Get Stock Out
    public function getStockOut(Request $request, $id)
    {
        if($id){
            $stockOut = DB::table('inv_goods_out')
                        ->join('inv_goods', 'inv_goods_out.goods_id', '=', 'inv_goods.id')
                        ->select('inv_goods_out.*', 'inv_goods.name as goods_name')
                        ->where('inv_goods_out.id', '=', $id)
                        ->where('inv_goods_out.status', '!=', 1)->first();

            if($stockOut){
                return json_encode(array(
                    'success' => true,
                    'data' => $stockOut
                ));
            }else{
                return json_encode(array(
                    'success' => false,
                    'msg' => 'Something went wrong!'
                ));
            }
        }
    }

    // Get Borrowed
    public function getBorrowed(Request $request, $id)
    {
        if($id){
            $stockOut = DB::table('inv_goods_out')
                        ->join('inv_goods', 'inv_goods_out.goods_id', '=', 'inv_goods.id')
                        ->select('inv_goods_out.*', 'inv_goods.name as goods_name')
                        ->where('inv_goods_out.id', '=', $id)
                        ->where('inv_goods_out.borrow', '=', 1)
                        ->where('inv_goods_out.status', '!=', 1)->first();

            if($stockOut){
                return json_encode(array(
                    'success' => true,
                    'data' => $stockOut
                ));
            }else{
                return json_encode(array(
                    'success' => false,
                    'msg' => 'Something went wrong!'
                ));
            }
        }
    }

    // Stock Return
    public function stockReturn(Request $request)
    {
        if(!$request->id){
            return json_encode(array(
                'success' => false,
                'msg' => 'Something went wrong!'
            ));
        }else{

            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'pic' => 'required',
                'qty' => 'required'
            ]);

            if ($validator->passes()) {
                // Add Return Stock
                $rt = new stockReturn;
                $rt->inv_goods_out_id = $request->id;
                $rt->qty = $request->qty;
                $rt->notes = $request->notes;
                $rt->save();
                // Check
                $check = StockOut::where('id','=',$request->id)
                                    ->where('qty', '>', $request->qty)
                                    ->first();

                if($check){
                    // if return < out
                    $out = StockOut::find($request->id);
                    $out->qty = $out->qty - $request->qty;
                    $out->save();
                }else{
                    // if return = out
                    $out = stockOut::find($request->id);
                    $out->status = 1;
                    $out->save();
                }
                
                $goods = Goods::find($out->goods_id);
                $goods->stock = $goods->stock + $request->qty;
                $goods->save();

                return response()->json(['success' => 'true', 'msg' => 'Data has been saved!', 'receipt' => $request->id]);
            }

            return response()->json(['error'=>$validator->errors()->all()]);
        }
    }

    public function export()
    {
        $goods = Goods::all();

        foreach($goods as $item){
            $data[] = array(
                'ID' => $item->id,
                'Name' => $item->name,
                'Stock' => $item->stock,
                'Price' => $item->price,
                'Condition' => $item->condition,
                'Specification' => strip_tags($item->specification),
                'Notes' => strip_tags($item->notes),
                'Update' => $item->updated_at
            );
        }
        
        Excel::create('Inventory', function($excel) use($data) {
            $excel->setTitle('Inventory Gardi Tour');

            $excel->sheet('Inventory', function($sheet) use($data) {
        
                $sheet->fromArray($data);
        
            });
        
        })->export('xls');
    }

    // Receipt
    public function receipt(Request $request, $type, $id)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Receipt';
        
        if($type == 'out'){
            $data['stockOut'] = DB::table('inv_goods_out')
                        ->join('inv_goods', 'inv_goods_out.goods_id', '=', 'inv_goods.id')
                        ->select('inv_goods_out.*', 'inv_goods.name as goods_name')
                        ->where('inv_goods_out.id', '=', $id)->first();

            if($data['stockOut']){
                
                return view('receipt', $data);

            }else{
                return json_encode(array(
                    'success' => false,
                    'msg' => 'Something went wrong!'
                ));
            }
        }
    }
}
