<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Po;
use App\PoVendor;
use App\PoItem;

class PoController extends Controller
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
        $data['page_title'] = 'Purchase Order';
        $data['po'] = Po::where('issued_by', '=', $data['AGENT']['email'])->get();
        
        if($data['AGENT']['role'] == 1){
            return view('public/po', $data);       
        }else if($data['AGENT']['role'] == 4){
            return view('public/po', $data);       
        }else if($data['AGENT']['role'] == 3){
            return view('public/po', $data);                  
        }else if($data['AGENT']['role'] == 6){
            return view('public/po', $data);                  
        }else{
            return view('public/po', $data);
        }
    }

    // Read PO
    public function read(Request $request, $id)
    {
        $data['AGENT'] = $this->AGENT;
        $data['page_title'] = 'Create Purchase Order';

        if(!$id){
            return redirect('po');
        }

        $data['po'] = Po::find($id);
        $data['vendors'] = PoVendor::all();
        $data['items'] = PoItem::where('po_id', '=', $id)->get();
        $data['itemTotal'] = number_format(PoItem::where('po_id', '=', $id)->sum('amount'), 0, "", ",");
                
        return view('public/po_create', $data);
    } 

    // Create
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'issued_by' => 'required'
        ]);

        if($validator->passes()){
            $po = new Po;
            $po->title = $request->title;
            $po->tax = 0;
            $po->total = 0;
            $po->status = 0;
            $po->issued_by = $request->issued_by;
            $po->save();

            return response()->json(['success' => 'true', 'msg' => 'Data has been saved!', 'id' => $po->id]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }

    // Update
    public function update(Request $request, $id)
    {
        if($id){
            $po = Po::find($id);
            
            if($po){
                if($request->title) $po->title = $request->title;
                if($request->vendor_id) $po->vendor_id = $request->vendor_id;
                if($request->delivery) $po->delivery = $request->delivery;
                if($request->shipment_to) $po->shipment_to = $request->shipment_to;
                if($request->freight) $po->freight = $request->freight;
                if($request->insurance) $po->insurance = $request->insurance;
                if($request->payment) $po->payment = $request->payment;
                if($request->total) $po->total = $request->total;
                if($request->tax) $po->tax = $request->tax;
                if($request->issued_by) $po->issued_by = $request->issued_by;
                if($request->status) $po->status = $request->status;
                $po->save();

                return response()->json(['success' => 'true', 'msg' => 'Data has been saved!']);            
            }else{
                return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);                            
            }
        }else{
            return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);   
        }
    }

    // Vendor
    // Create
    public function createVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);

        if($validator->passes()){
            $vendor = new PoVendor;
            $vendor->name = $request->name;
            $vendor->email = $request->email;
            $vendor->phone = $request->phone;
            $vendor->address = $request->address;
            $vendor->save();

            $po = Po::find($request->poID);
            $po->vendor_id = $vendor->id;
            $po->save();

            return response()->json(['success' => 'true', 'msg' => 'Data has been saved!', 'data' => $vendor]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
    // Read
    public function readVendor(Request $request, $id)
    {
        if($id){
            $vendor = PoVendor::find($id);

            if($vendor){
                if($request->poID){
                    $po = Po::find($request->poID);
                    $po->vendor_id = $vendor->id;
                    $po->save();
                }

                return response()->json(['success' => 'true', 'msg' => 'Data has been saved!', 'data' => $vendor]);                
            }

            return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);                            
        }
        return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);
    }

    // Item
    // Read Item
    public function readItem(Request $request, $id)
    {
        if($id){
            $item = PoItem::find($id);
            $item->price = number_format($item->price,0, "", ",");
            $item->amount = number_format($item->amount,0, "", ",");

            if($item){
                return response()->json(['success' => 'true', 'msg' => 'Success!', 'data' => $item]);
            }
            return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);            
        }
    }
    // Create
    public function createItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'amount' => 'required'
        ]);

        if($validator->passes()){
            $price = explode(".", $request->price);
            $priceClear = str_replace(',', '', $price[0]);
            $amount = explode(".", $request->amount);
            $amountClear = str_replace(',', '' , $amount[0]);

            $item = new PoItem;
            $item->po_id = $request->poID;
            $item->name = $request->name;
            $item->quantity = $request->quantity;
            $item->price = $priceClear;
            $item->amount = $amountClear;
            $item->save();

            $item->price = number_format($item->price,0, "", ",");
            $item->amount = number_format($item->amount,0, "", ",");
            
            $total = number_format(PoItem::where('po_id', '=', $request->poID)->sum('amount'), 0, "", ",");

            return response()->json(['success' => 'true', 'msg' => 'Data has been saved!', 'data' => $item, 'total' => $total]);
        }

        return response()->json(['error'=>$validator->errors()->all()]);
    }
    // Delete Item
    public function deleteItem(Request $request, $id)
    {
        if($id){
            $item = PoItem::find($id);
            $item->delete();

            $total = number_format(PoItem::where('po_id', '=', $item->po_id)->sum('amount'), 0, "", ",");
            
            return response()->json(['success' => 'true', 'msg' => 'Data has been deleted!', 'total' => $total]);            
        }

        return response()->json(['success' => 'false', 'msg' => 'Something went wrong!']);                    
    }
}